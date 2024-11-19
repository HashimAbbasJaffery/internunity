<template>
  <layout>
    <main>
      <application-status
        :internshipType="internshipType"
        @changeType="changeType($event)"
      ></application-status>
      <section
        id="internships"
        class="container mx-auto mt-9 w-2/3 divide-y-2"
        :class="{ 'flex justify-center items-center': is_loading }"
        v-if="internshipsData.length"
      >
        <div
          v-for="data in internshipsData"
          :key="data.id"
          class="relative internship bg-white mt-3 rounded-md p-2 hover:bg-grey cursor-pointer"
        >
          <Intership
            :is_applied="true"
            :internship="data.internship"
            :is_loading="is_loading"
          ></Intership>
        </div>
        <div
          class="load-button w-full text-center m-3 flex justify-center"
          v-if="!is_loading && next"
        >
          <LoadMore
            v-if="next"
            :is_loading="is_loading_more"
            @click="url = next"
          ></LoadMore>
        </div>
      </section>
      <div class="loader flex justify-center items-center">
        <loader v-if="is_loading" :is_loading="true" class="loader"></loader>
      </div>
      <result-not-found
        v-if="!(internshipsData.length || is_loading)"
        class="container mx-auto w-2/3 mt-6"
        >You haven’t applied for an internship yet!</result-not-found
      >
    </main>
  </layout>
</template>
<script setup>
import useFetch from "./composables/fetch";
import { ref } from "vue";
import Intership from "./Internee/Intership.vue";
import Loader from "./Utils/Loader.vue";
import LoadMore from "./Utils/LoadMore.vue";
import ApplicationStatus from "./Utils/ApplicationStatus.vue";
import ResultNotFound from "./Utils/ResultNotFound.vue";

const global_loading = ref(false);
const internshipType = ref("applied");
const url = ref(`/api/user/applications`);
const { internshipsData, is_loading, is_loading_more, next, fetch, per_page } = useFetch(
  url,
  global_loading
);

const changeType = (type) => {
  if (internshipType.value === type) return;
  internshipsData.value = [];
  internshipType.value = type;
  is_loading.value = true;
  url.value = `/api/user/applications?type=${type}`;
};
</script>
