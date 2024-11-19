<template>
  <Layout>
    <main>
      <section id="search" class="container mx-auto w-2/3 flex justify-between">
        <InputMarkup v-model="keyword" @search="keyword = $event"></InputMarkup>
      </section>
      <section
        id="internships"
        class="container mx-auto mt-9 w-2/3"
        :class="{ 'divide-y-2': !is_loading }"
      >
        <Internships
          :internships="internshipsData"
          :is_loading="is_loading"
        ></Internships>
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
          <LoadMore
            v-if="next"
            :is_loading="is_loading_more"
            @click="url = next"
          ></LoadMore>
        </div>
      </section>
    </main>
  </Layout>
</template>

<script setup>
import { provide, ref } from "vue";
import { watch } from "vue";
import Internships from "./Internee/Internships.vue";
import LoadMore from "./Utils/LoadMore.vue";
import { debounce } from "lodash";
import InputMarkup from "./Utils/InputMarkup.vue";
import useFetch from "./composables/fetch";
import Layout from "./Shared/Layout.vue";
import LoadingSkeleton from "./Utils/LoadingSkeleton.vue";

const url = ref(`/api/internships`);
const internship = ref([]);
provide("internship", internship);

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
