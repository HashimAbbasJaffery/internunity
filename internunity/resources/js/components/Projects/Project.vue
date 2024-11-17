<template>
  <img
    :src="image ? `/storage/projects/${image}` : 'https://placehold.co/95x95'"
    class="rounded-md"
    style="width: 95px; height: 95px; object-fit: contain"
    alt=""
  />
</template>
<script setup>
const props = defineProps({
  image: String,
});
</script>
