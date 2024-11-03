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
        <LoadMore :is_loading="is_loading_more" @click="getInternships(next)"></LoadMore>
      </div>
    </section>
  </main>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { watch } from "vue";
import axios from "axios";
import Internships from "./Internee/Internships.vue";
import Loader from "./Utils/Loader.vue";
import LoadMore from "./Utils/LoadMore.vue";
import { debounce } from "lodash";
import InputMarkup from "./Utils/InputMarkup.vue";

const internshipsData = ref([]);
const is_loading = ref(true);
const is_loading_more = ref(false);
const next = ref();
const keyword = ref();

const getInternships = async (url = "/api/internships") => {
  is_loading_more.value = true;
  const internships = await axios.get(url);
  internshipsData.value.push(...internships.data.data);
  next.value = internships.data.links[internships.data.links.length - 1].url;
  is_loading_more.value = false;
};

const searchInternships = async () => {
  is_loading.value = true;
  const internships = await axios.get(`/api/internships?keyword=${keyword.value}`);
  internshipsData.value = internships.data.data;
  next.value = internships.data.links[internships.data.links.length - 1].url;
  is_loading.value = false;
};

watch(keyword, debounce(searchInternships, 500));

onMounted(async () => {
  await getInternships();

  is_loading.value = false;
});
</script>
