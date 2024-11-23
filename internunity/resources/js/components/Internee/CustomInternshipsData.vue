<template>
  <div
    v-show="!is_loading"
    v-for="internship in internships"
    :key="internship.id"
    class="relative internship bg-white mt-3 rounded-md p-2 hover:bg-grey cursor-pointer"
  >
    <Intership
      @reported="$emit('reported')"
      :is_applied="is_applied"
      :internship="internship"
      :is_loading="is_loading"
    ></Intership>
  </div>
  <div
    v-if="!is_loading && next"
    class="load-button w-full text-center m-3 flex justify-center"
  >
    <LoadMore v-if="next" :is_loading="is_loading_more" @click="$emit('next')"></LoadMore>
  </div>
</template>

<script setup>
import { provide, ref } from "vue";
import Intership from "./Intership.vue";
import useFetch from "../composables/fetch";
import LoadMore from "../Utils/LoadMore.vue";

const props = defineProps({
  is_loading: Boolean,
  internships: Array,
  next: String,
  is_applied: {
    type: Boolean,
    default: true,
  },
  is_loading_more: Boolean,
});

const show_global_loading = ref(false);
const { internshipsData } = useFetch(`/api/report_types`, show_global_loading);

provide("report_types", internshipsData);
</script>
