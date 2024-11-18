<template>
  <layout>
    <main>
      <div class="tags my-3 container mx-auto w-2/3 space-x-2">
        <span
          class="tag text-xs rounded-full cursor-pointer p-2"
          :class="{
            'bg-base-alt text-black': internshipType === 'applied',
            'bg-black text-white': internshipType !== 'applied',
          }"
          @click="changeType('applied')"
          >Applied (10)</span
        >
        <span
          class="tag text-xs rounded-full cursor-pointer p-2"
          :class="{
            'bg-base-alt text-black': internshipType === 'interviewing',
            'bg-black text-white': internshipType !== 'interviewing',
          }"
          @click="changeType('interviewing')"
          >Interviewing (1)</span
        >
        <span
          class="tag text-xs rounded-full cursor-pointer p-2"
          @click="changeType('rejected')"
          :class="{
            'bg-base-alt text-black': internshipType === 'rejected',
            'bg-black text-white': internshipType !== 'rejected',
          }"
          >Rejected (9)</span
        >
        <span
          class="tag text-xs rounded-full cursor-pointer p-2"
          @click="changeType('selected')"
          :class="{
            'bg-base-alt text-black': internshipType === 'selected',
            'bg-black text-white': internshipType !== 'selected',
          }"
          >Selected (0)</span
        >
      </div>
      <section
        id="internships"
        class="container mx-auto mt-9 w-2/3 divide-y-2"
        :class="{ 'flex justify-center items-center': is_loading }"
      >
        <div
          v-for="data in internshipsData"
          :key="data.id"
          class="relative internship bg-white mt-3 rounded-md p-2 hover:bg-grey cursor-pointer"
        >
          <Intership :internship="data.internship" :is_loading="is_loading"></Intership>
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
        <loader v-if="is_loading" :is_loading="true" class="loader"></loader>
      </section>
    </main>
  </layout>
</template>
<script setup>
import useFetch from "./composables/fetch";
import { onMounted, ref, watch } from "vue";
import Intership from "./Internee/Intership.vue";
import Loader from "./Utils/Loader.vue";
import LoadMore from "./Utils/LoadMore.vue";

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
