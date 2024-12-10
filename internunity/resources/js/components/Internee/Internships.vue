<template>
  <div
    v-show="!is_loading"
    v-for="internship in internships"
    :key="internship.id"
    class="relative internship bg-white mt-3 rounded-md p-2 hover:bg-grey cursor-pointer"
  >
    <Intership
      :is_applied="internship.applications?.length ?? false"
      :internship="internship"
      :is_loading="is_loading"
      :viewFor="viewFor"
    ></Intership>
  </div>
  <div
    v-if="is_loading"
    class="relative internship bg-white mt-3 rounded-md p-2 hover:bg-grey cursor-pointer"
  >
    <loading-skeleton v-for="i in 8" :key="i"></loading-skeleton>
  </div>
  <div
    v-if="!is_loading && next"
    class="load-button w-full text-center m-3 flex justify-center"
  >
    <LoadMore v-if="next" :is_loading="is_loading_more" @click="url = next"></LoadMore>
  </div>
</template>

<script setup>
import { inject, provide, ref, watch } from "vue";
import Intership from "./Intership.vue";
import useFetch from "../composables/fetch";
import LoadMore from "../Utils/LoadMore.vue";
import { debounce } from "lodash";
import LoadingSkeleton from "../Utils/LoadingSkeleton.vue";

const props = defineProps({
  is_loading: Boolean,
  internshipsList: {
    type: Array,
    optional: true,
  },
  nextList: {
    type: String,
    optional: true,
  },
  url: {
    type: String,
    default() {
      return "/api/internships";
    },
  },
  viewFor: {
    type: String,
    default() {
      return "user";
    },
  },
});

const show_global_loading = ref(false);
const { internshipsData } = useFetch(`/api/report_types`, show_global_loading);
const emits = defineEmits(["next"]);

provide("report_types", internshipsData);

const url = ref(props.url);
const {
  internshipsData: internships,
  is_loading,
  is_loading_more,
  next,
  fetch,
  per_page,
} = useFetch(url, show_global_loading);

const reported = () => {
  let i = per_page.value;
  while (i--) {
    internships.value.pop();
  }
  fetch();
};

const searchInternships = () => {
  internships.value = [];
  show_global_loading.value = true;
  url.value = `${props.url}?keyword=${keyword.value}`;
};

const keyword = inject("keyword");
watch(keyword, debounce(searchInternships, 500));

const nextData = () => {
  if (!props.nextList) {
    url.value = next.value;
  } else {
  }
};
</script>
