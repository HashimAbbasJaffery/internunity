<template>
  <show-more
    class="right-0"
    :is_applied="is_applied"
    :internship="internship"
    v-if="showMore"
    @apply="apply"
    @close="showMore = false"
  ></show-more>
  <submit-application
    @create="createApplication($event)"
    v-if="is_creating_application"
    :errors="errors"
    @close="is_creating_application = false"
  ></submit-application>

  <div @click="showMore = true">
    <div class="actions absolute right-5 flex gap-2 text-xs">
      <div
        class="bg-blue-500 text-white rounded flex justify-center items-center p-2 text-normal"
        v-if="is_applied"
      >
        Applied
      </div>
      <button class="bg-base-alt px-2 py-1 text-white rounded-md">
        <i class="fa-solid fa-heart text-black"></i>
      </button>
      <button class="notify bg-red-500 text-white px-2 py-1 rounded-md">
        <i class="fa-solid fa-flag"></i>
      </button>
    </div>
    <p class="text-xs">Posted {{ moment(internship.created_at).fromNow() }}</p>
    <h1 class="font-bold">{{ internship.title }}</h1>
    <p class="text-sm mt-1">
      {{ internship.description.substring(0, 299) }}
      {{ internship.length > 300 ? "..." : "" }}
    </p>
    <p class="text-xs mt-3">Stipend {{ internship.stipend.toLocaleString() }} PKR</p>
    <div class="tags my-3 space-x-2">
      <span
        v-for="tag in internship.tags"
        :key="tag.id"
        class="tag bg-base-alt text-black text-xs rounded-full p-2"
        >{{ tag.tag }}</span
      >
    </div>
  </div>
</template>
<script setup>
import moment from "moment";
import { provide, ref } from "vue";
import ShowMore from "../Modals/ShowMore.vue";
import usePost from "../composables/post";
import SubmitApplication from "../Modals/SubmitApplication.vue";

const props = defineProps({
  internship: Object,
  is_loading: Boolean,
  is_applied: Boolean,
});
const showMore = ref(false);
const is_applied = ref(props.is_applied);
const is_creating_application = ref(false);
const postUrl = ref(`/api/user/${props.internship.id}/application/create`);
const { isLoading, sendRequest, errors } = usePost(postUrl);

const apply = () => {
  is_creating_application.value = true;
  showMore.value = false;
};

const createApplication = (application) => {
  isLoading.value = true;
  postUrl.value = `/api/user/${props.internship.id}/application/create`;
  sendRequest(application, function () {
    is_creating_application.value = false;
    is_applied.value = true;
    isLoading.value = false;
  });
};
</script>
