<template>
  <div class="load-more w-full flex justify-center items-center">
    <button
      @click="$emit('next', next)"
      class="bg-base-alt text-white px-3 py-1 rounded-md mt-3 disabled:bg-base-alt/50 disabled:cursor-not-allowed"
      :disabled="is_loading"
      :class="{ 'flex justify-center items-center gap-2': is_loading }"
    >
      Load More
      <Loader
        :is_loading="is_loading"
        className="loader loader-white loader-short"
      ></Loader>
    </button>
  </div>
</template>
<script setup>
const props = defineProps({
  next: String,
  is_loading: Boolean,
});
</script>
