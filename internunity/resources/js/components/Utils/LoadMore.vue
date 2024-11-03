<template>
  <button
    :disabled="is_loading"
    class="bg-black disabled:bg-black/50 text-white px-5 py-2 rounded-full flex justify-center items-center gap-2"
  >
    Load more
    <Loader v-if="is_loading" class="loader loader-white loader-short"></Loader>
  </button>
</template>
<script setup>
import Loader from "./Loader.vue";

const props = defineProps({
  is_loading: Boolean,
});
</script>
