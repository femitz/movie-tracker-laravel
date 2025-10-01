<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { success, info, error, loading, dismissToast } from '@/lib/Notification';
import { ref, onMounted } from 'vue';
import { GeminiCall } from '@/lib/Api';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { ApiCall } from '@/lib/Api';

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

interface Suggestion {
    movie_title: string;
    summary: string;
    why_you_ll_like_it: string;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Movies - Suggestions',
        href: '/movies/suggestions',
    },
];

const props = defineProps<{
    movies: Movie[];
}>();

const limit = ref(10);

const suggestions = ref<Suggestion[]>([]);
const localMovies = ref<Movie[]>([]);
const isLoading = ref(false);

onMounted(() => {
    localMovies.value = [...props.movies];
});

const getSuggestions = async () => {
    isLoading.value = true;
    
    // Captura o ID do toast de loading para poder fechá-lo depois
    const loadingToastId = loading("Getting suggestions... Please wait...");

    try {
        const prompt = `
        Based on my list of the ${localMovies.value.length} most recent movies I've watched, please suggest a list of ${limit.value} films for me.

        ${localMovies.value.map(movie => `- ${movie.name}`).join('\n')}
        Remember that your response must be in JSON format and contain a list of objects, as it will be directed to another user for rendering in HTML. Each object in the list should represent a movie suggestion and follow the structure below:

        [
        {
            "movie_title": "[Name of the movie]",
            "summary": "[A concise plot summary, no more than 3 lines.]",
            "why_you_ll_like_it": "[A specific reason why this film aligns with my tastes, based on the movies I've watched.]"
        },
        {
            "movie_title": "[Name of the movie]",
            "summary": "[A concise plot summary, no more than 3 lines.]",
            "why_you_ll_like_it": "[A specific reason why this film aligns with my tastes, based on the movies I've watched.]"
        }
        ... (up to ${limit.value} objects)
        ]
        `;

        const result = await GeminiCall(prompt);
        
        if (!result) {
            // Fecha o toast de loading e mostra erro
            dismissToast(loadingToastId);
            error("Failed to get suggestions. Please try again.");
            console.log('error', result);
            return;
        }
        
        const [response, response_gemini, model] = result;
        
        dismissToast(loadingToastId);
        success("Suggestions received successfully");

        const clean_response = (response as string)?.replace(/```json/g, '').replace(/```/g, '');

        suggestions.value = JSON.parse(clean_response || '[]');

        try {
            await ApiCall(route('movies.save-log-gemini'), 'POST', {
                prompt: prompt,
                response: response_gemini,
                response_text: response,
                model: model,
            });
        } catch (error) {
            console.log('error save log gemini', error);
        }
    } catch (err) {
        dismissToast(loadingToastId);
        error("An error occurred while getting suggestions. Please try again.");
        console.log('error', err);
    } finally {
        isLoading.value = false;
    }
}

</script>

<template>
    <Head title="Movies" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">

            <div class="grid gap-4">
                <Card>
                    <CardHeader>
                        <CardTitle>Suggestions</CardTitle>
                        <CardDescription>
                            <p>
                                Based on my list of the 50 most recent movies I've watched, please suggest a list of {{ limit }} films for me.
                            </p>
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                    <div class="flex flex-col space-y-1.5">
                        <div class="flex flex-col space-y-1.5">
                            <Label for="limit">Limit</Label>
                            <Input id="limit" type="number" placeholder="Limit" v-model="limit" />
                        </div>
                        <Button @click="getSuggestions()" :disabled="isLoading" class="cursor-pointer">
                            {{ isLoading ? 'Getting suggestions...' : 'Get Suggestions' }}
                        </Button> 
                    </div>

                    <div v-if="suggestions.length > 0" v-for="suggestion in suggestions" :key="suggestion.movie_title" class="border rounded-lg p-4 bg-white shadow-sm mt-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ suggestion.movie_title }}</h3>
                                <p class="text-sm text-gray-500">{{ suggestion.summary }}</p>
                                <br>
                                <!-- as vezes nao tem o why_you_ll_like_it -->
                                <p class="text-sm text-gray-500">{{ suggestion.why_you_ll_like_it }}</p>
                            </div>
                        </div>
                    </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
