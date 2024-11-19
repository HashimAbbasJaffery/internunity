<template>
  <Layout>
    <ShowMore @apply="apply"></ShowMore>
    <submit-application
      @create="createApplication($event)"
      :is_loading="isLoading"
      v-if="is_creating_application"
      :errors="errors"
      @close="is_creating_application = false"
    ></submit-application>
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
  </Layout>
</template>

<script setup>
import { provide, ref } from "vue";
import { watch } from "vue";
import Internships from "./Internee/Internships.vue";
import Loader from "./Utils/Loader.vue";
import LoadMore from "./Utils/LoadMore.vue";
import { debounce } from "lodash";
import InputMarkup from "./Utils/InputMarkup.vue";
import useFetch from "./composables/fetch";
import ShowMore from "./Modals/ShowMore.vue";
import Layout from "./Shared/Layout.vue";
import SubmitApplication from "./Modals/SubmitApplication.vue";
import usePost from "./composables/post";

const url = ref(`/api/internships`);
const internship = ref([]);
provide("internship", internship);

const show_global_loading = ref(false);
const { internshipsData, is_loading, is_loading_more, next } = useFetch(
  url,
  show_global_loading
);
const postUrl = ref(`/api/user/${internship.id}/application/create`);
const { isLoading, sendRequest, errors, returns } = usePost(postUrl);
const keyword = ref();
const is_creating_application = ref(false);

const searchInternships = () => {
  internshipsData.value = [];
  show_global_loading.value = true;
  url.value = `/api/internships?keyword=${keyword.value}`;
};

watch(keyword, debounce(searchInternships, 500));

const apply = () => {
  is_creating_application.value = true;
};

const createApplication = (application) => {
  postUrl.value = `/api/user/${internship.value.id}/application/create`;
  sendRequest(application, function () {
    is_creating_application.value = false;
    internship.value = [];
  });
};
</script>
