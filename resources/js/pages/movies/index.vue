<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { success, error } from '@/lib/Notification';
import { ref, onMounted, onUnmounted, nextTick, watch } from 'vue';
import { ApiCall } from '@/lib/Api';
import { formatDateFromDB } from '@/lib/utils';
import { SquarePen, Trash2, Loader2, Search } from 'lucide-vue-next';

interface Movie {
    id: number;
    name: string;
    id_user: number;
    date: string;
    created_at: string;
    updated_at: string;
    id_genres: number[];
    genres_names: string[];
}

interface Pagination {
    current_page: number;
    per_page: number;
    total: number;
    last_page: number;
    has_more: boolean;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Movies',
        href: '/movies',
    },
];

const props = defineProps<{
    movies: Movie[];
    pagination: Pagination;
}>();

const localMovies = ref<Movie[]>([]);
const currentPage = ref(1);
const isLoading = ref(false);
const hasMore = ref(true);
const loadMoreTrigger = ref<HTMLElement | null>(null);
const searchTerm = ref('');
const isSearching = ref(false);
const searchTimeout = ref<number | null>(null);

// Inicializar a lista local quando o componente for montado
onMounted(() => {
    localMovies.value = [...props.movies];
    currentPage.value = props.pagination.current_page;
    hasMore.value = props.pagination.has_more;
    
    // Configurar Intersection Observer após o próximo tick para garantir que o DOM está renderizado
    nextTick(() => {
        setupInfiniteScroll();
    });
});

onUnmounted(() => {
    if (observer) {
        observer.disconnect();
    }
});

// watcher para reconfigurar o observer quando o trigger for atualizado
watch(loadMoreTrigger, (newTrigger) => {
    if (newTrigger && hasMore.value) {
        nextTick(() => {
            setupInfiniteScroll();
        });
    }
});

let observer: IntersectionObserver | null = null;

const setupInfiniteScroll = () => {
    if (observer) {
        observer.disconnect();
    }
    
    observer = new IntersectionObserver(
        (entries) => {
            if (entries[0].isIntersecting && hasMore.value && !isLoading.value) {
                loadMoreMovies();
            }
        },
        { threshold: 0.1 }
    );

    if (loadMoreTrigger.value) {
        observer.observe(loadMoreTrigger.value);
    }
};

const loadMoreMovies = async () => {
    if (isLoading.value || !hasMore.value || isSearching.value) return;

    isLoading.value = true;
    currentPage.value += 1;

    try {
        const response = await axios.get(route('movies.api.index'), {
            params: {
                page: currentPage.value,
                per_page: props.pagination.per_page
            }
        });

        const { movies, pagination } = response.data;
        
        // Verificar e remover duplicatas por ID
        const uniqueMovies = movies.filter((movie: Movie, index: number, self: Movie[]) => 
            index === self.findIndex(m => m.id === movie.id)
        );
        
        // Combinar com lista existente e remover duplicatas
        const combinedMovies = [...localMovies.value, ...uniqueMovies];
        const finalMovies = combinedMovies.filter((movie: Movie, index: number, self: Movie[]) => 
            index === self.findIndex(m => m.id === movie.id)
        );
        
        localMovies.value = finalMovies;
        hasMore.value = pagination.has_more;
    } catch (err) {
        console.error('Error loading more movies:', err);
        error('Error loading more movies');
        currentPage.value -= 1; // Revert page on error
    } finally {
        isLoading.value = false;
    }
};

const searchMovies = async (term: string) => {
    if (searchTimeout.value) {
        clearTimeout(searchTimeout.value);
    }

    searchTimeout.value = setTimeout(async () => {
        if (term.trim() === '') {
            // Se o termo de pesquisa estiver vazio, recarregar a lista original
            localMovies.value = [...props.movies];
            currentPage.value = props.pagination.current_page;
            hasMore.value = props.pagination.has_more;
            isSearching.value = false;
            return;
        }

        isSearching.value = true;
        isLoading.value = true;

        try {
            const response = await axios.get(route('movies.search'), {
                params: {
                    q: term,
                    page: 1,
                    per_page: props.pagination.per_page
                }
            });

            const { movies, pagination } = response.data;
            
            // Verificar e remover duplicatas por ID
            const uniqueMovies = movies.filter((movie: Movie, index: number, self: Movie[]) => 
                index === self.findIndex(m => m.id === movie.id)
            );
            
            // Sempre substituir completamente a lista para evitar duplicatas
            localMovies.value = [...uniqueMovies];
            currentPage.value = pagination.current_page;
            hasMore.value = pagination.has_more;
        } catch (err) {
            console.error('Error searching movies:', err);
            error('Error searching movies');
        } finally {
            isLoading.value = false;
            isSearching.value = false;
        }
    }, 300); // Debounce de 300ms
};

// Watcher para o termo de pesquisa
watch(searchTerm, (newTerm) => {
    searchMovies(newTerm);
});

const deleteMovie = (id: number) => {
    ApiCall(route('movies.destroy', { id: id }), 'delete', {}).then((response: any) => {
        if (response.data.success) {
            success('Movie deleted successfully');
            localMovies.value = localMovies.value.filter((movie) => movie.id !== id);
            return;
        }
        error('Error deleting movie!');
        return;
    });
}

const downloadXlsx = () => {
    window.open(route('movies.download'), '_blank');
    success('Download started');
}

</script>

<template>
    <Head title="Movies" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            
            <div class="flex justify-between items-center gap-4">
                <div class="flex gap-2">
                    <Link :href="route('movies.create')" class="flex justify-start">
                        <Button class="cursor-pointer">Add</Button>
                    </Link>

                    <div class="flex justify-start">
                        <Button @click="downloadXlsx" class="cursor-pointer" variant="secondary">Download XLSX</Button>
                    </div>
                </div>

                <!-- Campo de pesquisa -->
                <div class="relative flex-1 max-w-md">
                    <div class="relative">
                        <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4" />
                        <input
                            v-model="searchTerm"
                            type="text"
                            placeholder="Pesquisar filmes..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                        />
                        <div v-if="isSearching" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <Loader2 class="w-4 h-4 animate-spin text-gray-400" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-4">
                <div v-for="movie in localMovies" :key="movie.id" class="border rounded-lg p-4 bg-white shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ movie.name }}</h3>
                            <div class="mt-2">
                                <span class="text-sm text-gray-600">Genres: </span>
                                <span v-if="movie.genres_names && movie.genres_names.length > 0" class="text-sm text-gray-800">
                                    {{ movie.genres_names.join(', ') }}
                                </span>
                                <span v-else class="text-sm text-gray-400">No genres</span>
                            </div>
                            <div class="mt-1 text-xs text-gray-500">
                                Watched at: {{ formatDateFromDB(movie.date) }}
                            </div>
                        </div>
                        <div class="flex gap-2">

                            <Link :href="route('movies.edit', { id: movie.id })">
                                <Button variant="outline" size="sm" class="cursor-pointer"> <SquarePen class="w-4 h-4" /></Button>
                            </Link>

                            <Button variant="destructive" size="sm" class="cursor-pointer" @click="deleteMovie(movie.id)"><Trash2 class="w-4 h-4" /></Button>

                        </div>
                    </div>
                </div>
                
                <div v-if="isLoading" class="flex justify-center py-4">
                    <div class="flex items-center gap-2 text-gray-600">
                        <Loader2 class="w-5 h-5 animate-spin" />
                        <span>Loading more movies...</span>
                    </div>
                </div>
                
                <div 
                    v-if="hasMore && !isLoading" 
                    ref="loadMoreTrigger" 
                    class="h-4"
                ></div>
                
                <div v-if="!hasMore && localMovies.length > 0" class="text-center py-4 text-gray-500">
                    All movies have been loaded
                </div>
                
                <div v-if="localMovies.length === 0" class="text-center py-8 text-gray-500">
                    <div v-if="searchTerm.trim() === ''">
                        No movies found. Click on "Add" to create your first movie.
                    </div>
                    <div v-else>
                        No movies found for "{{ searchTerm }}". Try a different search term.
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
