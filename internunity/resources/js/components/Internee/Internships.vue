<template>
  <div
    v-show="!is_loading"
    v-for="internship in internships"
    :key="internship.id"
    class="relative internship bg-white mt-3 rounded-md p-2 hover:bg-grey cursor-pointer"
  >
    <Intership :internship="internship" :is_loading="is_loading"></Intership>
  </div>
</template>

<script setup>
import { inject } from "vue";
import Intership from "./Intership.vue";

const props = defineProps({
  is_loading: Boolean,
  internships: Array,
});
</script>
