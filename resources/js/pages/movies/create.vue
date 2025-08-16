<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Multiselect } from 'vue-multiselect';
import { useReward } from 'vue-rewards';
import DatePicker from 'primevue/datepicker';



const { reward } = useReward('rewards', 'confetti', {
    startVelocity:10,
    spread:180,
    elementCount:100
});

const props = defineProps({
    genres: {
        type: Array,
        default: () => [],
    },
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Movies Create',
        href: '/movies/create',
    },
];

const form = useForm({
    name: '',
    id_genre: [],
    date: '',
});

const handleSubmit = () => {
    form.post(route('movies.store'));

};


const onSearchGenresChange = (search: string) => {
    console.log('onSearchGenresChange', search);
}

const onSelectGenre = (id_genre: any) => {
    form.id_genre = id_genre.id;
}



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

                            <div class="flex flex-col space-y-1.5">
                                <Label for="genre">Genre</Label>
                                <Multiselect
                                    v-model="form.id_genre"
                                    id="id_genre" placeholder="Search genre"
                                    :options="genres" label="name" track-by="id"
                                    @input="onSelectGenre"
                                    :multiple="true"
                                    :close-on-select="false"
                                />
                            </div>

                            <div class="flex flex-col space-y-1.5">
                                <Label for="date">Date</Label>
                                <DatePicker v-model="form.date" dateFormat="dd/mm/yy" />
                            </div>

                        </div>
                    </CardContent>
                    <CardFooter class="relative z-0">
                        <Button id="rewards" type="submit" class="cursor-pointer" @click="reward">Save</Button>
                    </CardFooter>
                </Card>
            </form>
            
        </div>
    </AppLayout>
</template>