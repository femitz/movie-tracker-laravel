<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { success, error } from '@/lib/Notification';
import { ref, onMounted } from 'vue';
import { ApiCall } from '@/lib/Api';
import { formatDateFromDB } from '@/lib/utils';
import { SquarePen, Trash2 } from 'lucide-vue-next';

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

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Movies',
        href: '/movies',
    },
];

const props = defineProps<{
    movies: Movie[];
}>();

const localMovies = ref<Movie[]>([]);

// Inicializar a lista local quando o componente for montado
onMounted(() => {
    localMovies.value = [...props.movies];
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
            
            <div class="flex justify-start gap-2">
                <Link :href="route('movies.create')" class="flex justify-start">
                    <Button class="cursor-pointer">Add</Button>
                </Link>

                <div class="flex justify-start">
                    <Button @click="downloadXlsx" class="cursor-pointer" variant="secondary">Download XLSX</Button>
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
                
                <div v-if="localMovies.length === 0" class="text-center py-8 text-gray-500">
                    No movies found. Click on "Add" to create your first movie.
                </div>
            </div>
        </div>
    </AppLayout>
</template>
