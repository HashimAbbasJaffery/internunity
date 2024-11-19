<template>
  <EducationModal
    :isLoading="isLoading"
    v-if="is_adding"
    :errors="errors"
    @close="is_adding = false"
    @create="add($event)"
  ></EducationModal>
  <section
    id="Experiences"
    class="shade w-2/3 p-3 rounded-md space-y-4 divide-y-2"
    :class="{ 'flex justify-center items-center': is_loading }"
  >
    <div class="experiences space-y-3 divide-y-2 relative" v-if="!is_loading">
      <heading>Education</heading>
      <div class="experience py-1" v-for="data in internshipsData" :key="data.id">
        <h1 class="font-bold">{{ data.organization }}</h1>
        <p class="text-sm mb-1">{{ data.education }}</p>
        <p class="text-xs opacity-50 italic">
          {{ moment(data.from).format("DD MMMM YYYY") }} -
          {{ moment(data.to).format("DD MMMM YYYY") }}
        </p>
        <p class="text-sm">
          {{ data.description }}
        </p>
      </div>
      <result-not-found v-if="!internshipsData.length"
        >No Experience in this list</result-not-found
      >

      <LoadMoreButton
        v-if="next"
        :next="next"
        :is_loading="is_loading_more"
        @next="url = next"
      ></LoadMoreButton>
      <Button
        class="rounded-full flex justify-center items-center absolute top-0 right-0"
        @click="is_adding = true"
      >
        <i class="fa-solid fa-plus text-xs"></i>
      </Button>
    </div>
    <Loader v-else class="loader" :is_loading="is_loading"></Loader>
  </section>
</template>
<script setup>
import useFetch from "../composables/fetch";
import { ref } from "vue";
import moment from "moment";
import Loader from "../Utils/Loader.vue";
import Button from "../Utils/Button.vue";
import LoadMoreButton from "../Utils/LoadMoreButton.vue";
import EducationModal from "../Modals/EducationModal.vue";
import usePost from "../composables/post";
import ResultNotFound from "../Utils/ResultNotFound.vue";
import Heading from "../Utils/Heading.vue";

const url = ref(`/api/user/educations`);
const show_global_loading = ref(false);
const is_adding = ref(false);
const { internshipsData, is_loading, is_loading_more, next, fetch, per_page } = useFetch(
  url,
  show_global_loading
);
const { isLoading, sendRequest, errors, returns } = usePost(`/api/user/education/create`);

const add = (newEducation) => {
  sendRequest(newEducation, function () {
    is_adding.value = false;
    internshipsData.value = [];
    fetch();
  });
};
</script>
