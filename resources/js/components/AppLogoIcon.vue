<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <img 
        src="/favicon.ico" 
        alt="Mitz App Logo" 
        :class="className" 
        v-bind="$attrs"
    />
</template>
