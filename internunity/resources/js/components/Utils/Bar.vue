<template>
  <div
    class="show-more-actions shade px-2 py-1 cursor-pointer rounded-md bg-white text-xs"
    :class="{ 'bg-gray-400 text-white': show_more_options }"
    @click="$emit('toggle')"
  >
    <i class="fa-solid fa-bars"></i>
  </div>
  <div
    class="menu bg-white absolute shade mt-2 p-2 left-0 rounded z-20"
    style="width: 150px"
    v-if="show_more_options"
  >
    <slot></slot>
  </div>
</template>

<script setup>
const props = defineProps({
  show_more_options: Boolean,
});
</script>
