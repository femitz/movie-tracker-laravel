<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'
import { Primitive, type PrimitiveProps } from 'reka-ui'
import { type TextVariants, textVariants } from './index'

interface Props extends PrimitiveProps {
  variant?: TextVariants['variant']
  size?: TextVariants['size']
  weight?: TextVariants['weight']
  align?: TextVariants['align']
  leading?: TextVariants['leading']
  class?: HTMLAttributes['class']
}

const props = withDefaults(defineProps<Props>(), {
  as: 'p',
})
</script>

<template>
  <Primitive
    data-slot="text"
    :as="as"
    :as-child="asChild"
    :class="cn(textVariants({ variant, size, weight, align, leading }), props.class)"
  >
    <slot />
  </Primitive>
</template>
