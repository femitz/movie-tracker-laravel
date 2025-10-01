<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const navigateToMovies = () => {
    router.visit(route('movies.index'));
};

const navigateToSuggestions = () => {
    router.visit(route('movies.suggestions'));
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6 overflow-x-auto">
            <!-- Quick Navigation Section -->
            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-foreground">Quick Navigation</h2>
                <div class="grid gap-4 md:grid-cols-2">
                    <!-- Movies Button -->
                    <button 
                        @click="navigateToMovies"
                        class="group relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-card hover:bg-accent transition-all duration-200 p-6 text-left"
                    >
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h3a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1h3zM9 4h6V3H9v1zM5 7h14v10H5V7z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-foreground group-hover:text-accent-foreground transition-colors">
                                    Movies
                                </h3>
                                <p class="text-sm text-muted-foreground group-hover:text-accent-foreground/80 transition-colors">
                                    Manage your movie library
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-muted-foreground group-hover:text-accent-foreground transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </button>

                    <!-- Suggestions Button -->
                    <button 
                        @click="navigateToSuggestions"
                        class="group relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-card hover:bg-accent transition-all duration-200 p-6 text-left"
                    >
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-foreground group-hover:text-accent-foreground transition-colors">
                                    Suggestions
                                </h3>
                                <p class="text-sm text-muted-foreground group-hover:text-accent-foreground/80 transition-colors">
                                    Get personalized recommendations
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-muted-foreground group-hover:text-accent-foreground transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Additional Content Section
            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-foreground">Overview</h2>
                <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                    <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <PlaceholderPattern />
                    </div>
                    <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <PlaceholderPattern />
                    </div>
                    <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <PlaceholderPattern />
                    </div>
                </div>
                <div class="relative min-h-[200px] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div> -->
        </div>
    </AppLayout>
</template>
