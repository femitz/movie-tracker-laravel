<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';



const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Movies Create',
        href: '/movies/create',
    },
];

const genres = [
    { name: 'Action', value: 'action' },
    { name: 'Adventure', value: 'adventure' },
    { name: 'Comedy', value: 'comedy' },
];

const form = useForm({
    name: '',
    description: '',
    director: '',
    year: '',
    genre: '',
    duration: '',
    classification: '',
});

const handleSubmit = () => {
    form.post(route('movies.store'));
};


</script>

<template>
    <Head title="Movies Create" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            
            <form @submit.prevent="handleSubmit">
                <Card>
                    <CardHeader>
                        <CardTitle>Add Movie</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="grid w-full items-center gap-4">
                            <div class="flex flex-col space-y-1.5">
                                <Label for="name">Movie Name</Label>
                                <Input id="name" type="text" placeholder="Movie Name" v-model="form.name" />
                            </div>
                            

                        </div>
                    </CardContent>
                    <CardFooter class="relative z-0">
                        <Button type="submit" class="cursor-pointer">Salvar</Button>
                    </CardFooter>
                </Card>
            </form>
            
        </div>
    </AppLayout>
</template>