<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { error, success } from '@/lib/Notification';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { Multiselect } from 'vue-multiselect';
import { ApiCall } from '@/lib/Api';

interface Genre {
    id: number;
    name: string;
}

interface Movie {
    id: number;
    name: string;
    id_genres: number[];
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Movies',
        href: '/movies',
    },
    {
        title: 'Edit Movie',
        href: '#',
    },
];

const props = defineProps<{
    movie: Movie;
    genres: Genre[];
}>();

const form = ref<{
    name: string;
    id_genre: Genre[];
}>({
    name: props.movie.name,
    id_genre: [],
});

const isSubmitting = ref(false);

// Inicializar os gêneros selecionados no formato correto para o Multiselect
onMounted(() => {
    // Converter os IDs dos gêneros para objetos com id e name
    const selectedGenres = props.genres.filter((genre) => props.movie.id_genres.includes(genre.id));
    form.value.id_genre = selectedGenres;
});

const submitForm = () => {
    if (form.value.name.trim() === '') {
        error('Movie name is required!');
        return;
    }

    isSubmitting.value = true;

    // Converter os objetos de gênero para o formato esperado pelo backend
    const formData = {
        name: form.value.name,
        id_genre: form.value.id_genre.map((genre) => ({ id: genre.id })),
    };

    ApiCall(route('movies.update', { id: props.movie.id }), 'put', formData).then((response: any) => {
        if (response.data.success) {
            success('Movie updated successfully!');
            isSubmitting.value = false;
            return;
        }
        isSubmitting.value = false;
        error('Error updating movie!');
        return;
    });
};

const onSelectGenre = (selectedGenres: Genre[]) => {
    form.value.id_genre = selectedGenres;
};

</script>

<template>
    <Head title="Edit Movie" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <form @submit.prevent="submitForm">
                <Card>
                    <CardHeader>
                        <CardTitle>Edit Movie</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="grid w-full items-center gap-4">
                            <div class="flex flex-col space-y-1.5">
                                <Label for="name">Movie Name</Label>
                                <Input id="name" v-model="form.name" type="text" placeholder="Enter the movie name" required />
                            </div>

                            <div class="flex flex-col space-y-1.5">
                                <Label for="genre">Genre</Label>
                                <Multiselect
                                    v-model="form.id_genre"
                                    id="id_genre"
                                    placeholder="Search genre"
                                    :options="genres"
                                    label="name"
                                    track-by="id"
                                    @input="onSelectGenre"
                                    :multiple="true"
                                    :close-on-select="false"
                                />
                            </div>

                        </div>
                    </CardContent>
                    <CardFooter class="relative z-0 gap-4 space-x-4">

                        <Button type="submit" :disabled="isSubmitting" class="flex-1 cursor-pointer">
                            <span v-if="isSubmitting">Saving...</span>
                            <span v-else>Save Changes</span>
                        </Button>

                        <Button type="button" variant="outline" @click="router.visit(route('movies.index'))" :disabled="isSubmitting">
                            Cancel
                        </Button>
                    </CardFooter>
                </Card>
            </form>
        </div>
    </AppLayout>
</template>
