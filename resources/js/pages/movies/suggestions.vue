<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { success, info } from '@/lib/Notification';
import { ref, onMounted } from 'vue';
import { GeminiCall } from '@/lib/Api';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';

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

onMounted(() => {
    localMovies.value = [...props.movies];
});

const getSuggestions = async () => {

   info("Getting suggestions... Please wait...");

    const prompt = `
    Based on my list of the 50 most recent movies I've watched, please suggest a list of ${limit.value} films for me.

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

    var response = await GeminiCall(prompt);

    success("Suggestions received successfully")

    response = response?.replace(/```json/g, '').replace(/```/g, '');

    suggestions.value = JSON.parse(response || '[]');
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
                    </CardHeader>
                    <CardContent>
                    <div class="flex flex-col space-y-1.5">
                        <div class="flex flex-col space-y-1.5">
                            <Label for="limit">Limit</Label>
                            <Input id="limit" type="number" placeholder="Limit" v-model="limit" />
                        </div>
                        <Button @click="getSuggestions()">Get Suggestions</Button> 
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
