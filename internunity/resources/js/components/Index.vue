<template>
  <main>
    <section id="search" class="container mx-auto w-2/3 flex justify-between">
      <InputMarkup v-model="keyword" @search="keyword = $event"></InputMarkup>
    </section>
    <section
      id="internships"
      class="container mx-auto mt-9 w-2/3"
      :class="{ 'divide-y-2': !is_loading }"
    >
      <Internships :internships="internshipsData" :is_loading="is_loading"></Internships>
      <Loader :is_loading="is_loading" className="loader"></Loader>

      <div
        v-if="!is_loading && next"
        class="load-button w-full text-center m-3 flex justify-center"
      >
        <LoadMore
          v-if="next"
          :is_loading="is_loading_more"
          @click="url = next"
        ></LoadMore>
      </div>
    </section>
  </main>
</template>

<script setup>
import { ref } from "vue";
import { watch } from "vue";
import Internships from "./Internee/Internships.vue";
import Loader from "./Utils/Loader.vue";
import LoadMore from "./Utils/LoadMore.vue";
import { debounce } from "lodash";
import InputMarkup from "./Utils/InputMarkup.vue";
import useFetch from "./composables/fetch";

const url = ref(`/api/internships`);
const show_global_loading = ref(false);
const { internshipsData, is_loading, is_loading_more, next } = useFetch(
  url,
  show_global_loading
);
const keyword = ref();

const searchInternships = () => {
  internshipsData.value = [];
  show_global_loading.value = true;
  url.value = `/api/internships?keyword=${keyword.value}`;
};

watch(keyword, debounce(searchInternships, 500));
</script>
