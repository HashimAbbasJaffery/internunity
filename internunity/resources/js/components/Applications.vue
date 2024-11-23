<template>
  <layout>
    <main>
      <application-status
        :internshipType="internshipType"
        @changeType="changeType($event)"
      ></application-status>
      <section
        id="internships"
        class="container mx-auto mt-9 w-2/3"
        :class="{ 'flex justify-center items-center': is_loading }"
      >
        <custom-internships-data
          v-if="!is_loading"
          :internships="internshipsData.map((application) => application.internship)"
          :is_loading="is_loading"
          :is_loading_more="is_loading_more"
          :next="next"
          @reported="reported"
          @next="url = next"
        ></custom-internships-data>
      </section>
      <div
        v-if="is_loading"
        class="container w-2/3 mx-auto relative internship bg-white mt-3 rounded-md p-2 hover:bg-grey cursor-pointer"
      >
        <loading-skeleton v-for="i in 8" :key="i"></loading-skeleton>
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
import ApplicationStatus from "./Utils/ApplicationStatus.vue";
import ResultNotFound from "./Utils/ResultNotFound.vue";
import CustomInternshipsData from "./Internee/CustomInternshipsData.vue";
import LoadingSkeleton from "./Utils/LoadingSkeleton.vue";

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

const reported = () => {
  let i = per_page.value;
  while (i--) {
    internshipsData.value.pop();
  }
  fetch();
};
</script>
