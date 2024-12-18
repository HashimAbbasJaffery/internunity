<template>
  <div class="modals" v-if="viewFor === 'user'">
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
    <report-modal
      @create="sendReport($event)"
      v-if="is_reporting"
      :errors="errors"
      @close="is_reporting = false"
    ></report-modal>
  </div>
  <div>
    <div
      v-if="is_reported"
      class="reported absolute bg-white text-sm w-full h-full flex justify-center items-center gap-2"
    >
      <i class="fa-solid fa-circle-info"></i>
      Thank you for reporting!
    </div>
    <div
      v-if="is_deleted"
      class="reported absolute bg-white text-sm w-full h-full flex justify-center items-center gap-2"
    >
      <i class="fa-solid fa-circle-info"></i>
      This Internship is deleted
    </div>
    <div v-else-if="!is_reported" class="actions absolute right-5 text-xs">
      <div class="action-for-users flex gap-2" v-if="viewFor === 'user'">
        <div
          class="bg-blue-500 text-white rounded flex justify-center items-center p-2 text-normal"
          v-if="is_applied"
        >
          Applied
        </div>
        <button
          v-if="is_logged_in"
          class="bg-base-alt px-2 py-1 text-white rounded-md"
          @click="heart"
        >
          <i
            class="fa-solid fa-heart text-black like-button"
            :class="{ active: is_hearted }"
            v-if="is_hearted"
          ></i>
          <i class="fa-regular fa-heart" v-else></i>
        </button>
        <button
          v-if="is_logged_in"
          class="notify bg-red-500 text-white px-2 py-1 rounded-md"
          @click="is_reporting = true"
        >
          <i class="fa-solid fa-flag"></i>
        </button>
      </div>
      <div class="action-for-companies relative" v-if="viewFor === 'company'">
        <bar
          :show_more_options="show_more_options"
          @toggle="show_more_options = !show_more_options"
        >
          <ul class="space-y-2">
            <li
              class="flex items-center gap-2"
              @click="$router.push(`/company/internship/${internship.id}/applications`)"
            >
              Applications
              <i class="fa-solid fa-chart-simple"></i>
            </li>
            <li
              @click="$router.push(`/company/internship/${internship.id}/update`)"
              class="flex items-center gap-2"
            >
              Update
              <i class="fa-solid fa-pen"></i>
            </li>
            <li class="flex items-center gap-2" @click="deleteInternship(internship.id)">
              Delete
              <i class="fa-solid fa-trash"></i>
            </li>
          </ul>
        </bar>
      </div>
    </div>
    <div class="internship-container" @click="showMore = true">
      <p class="text-xs">
        Posted {{ moment(internship.created_at).fromNow() }} |
        {{ internship?.applications_count ?? 0 }} Applications
      </p>
      <h1 class="font-bold">{{ internship.title }}</h1>
      <p class="text-sm mt-1">
        {{ internship.description?.substring(0, 299) ?? "lol" }}
        {{ internship.length > 300 ? "..." : "" }}
      </p>
      <div class="others flex items-center justify-between mt-3 gap-2">
        <p class="text-xs">Stipend {{ internship.stipend }} PKR</p>
      </div>
      <div class="tags my-3 space-x-2">
        <span
          v-for="tag in internship.tags"
          :key="tag.id"
          class="tag bg-base-alt text-black text-xs rounded-full p-2"
          >{{ tag.tag }}</span
        >
      </div>
    </div>
  </div>
</template>
<script setup>
import moment from "moment";
import { computed, ref } from "vue";
import ShowMore from "../Modals/ShowMore.vue";
import usePost from "../composables/post";
import SubmitApplication from "../Modals/SubmitApplication.vue";
import ReportModal from "../Modals/ReportModal.vue";
import Bar from "../Utils/Bar.vue";

const props = defineProps({
  internship: Object,
  is_loading: Boolean,
  is_applied: Boolean,
  viewFor: {
    type: String,
    default() {
      return "user";
    },
  },
});
const showMore = ref(false);
const is_applied = ref(props.is_applied);
const is_hearted = ref(props.internship.hearts?.length ?? false);
const is_creating_application = ref(false);
const postUrl = ref(`/api/user/${props.internship.id}/application/create`);
const { isLoading, sendRequest, errors } = usePost(postUrl);
const is_reporting = ref(false);
const emits = defineEmits(["reported"]);
const is_reported = ref(false);
const show_more_options = ref(false);
const is_deleted = ref(false);

const apply = () => {
  is_creating_application.value = true;
  showMore.value = false;
};

const is_logged_in = computed(() => localStorage.token?.length ?? false);

const createApplication = (application) => {
  isLoading.value = true;
  postUrl.value = `/api/user/${props.internship.id}/application/create`;
  sendRequest(application, function () {
    is_creating_application.value = false;
    is_applied.value = true;
    isLoading.value = false;
  });
};

const heart = () => {
  postUrl.value = `/api/user/${props.internship.id}/heart`;
  sendRequest({}, function (res) {
    if (res.data) is_hearted.value = !is_hearted.value;
  });
};

const sendReport = (report) => {
  postUrl.value = `/api/user/${props.internship.id}/report`;
  sendRequest(report, function (res) {
    if (res.data) {
      is_reporting.value = false;
      is_reported.value = true;
    }
  });
};

const deleteInternship = async (id) => {
  const status = await axios.post(`/api/company/internship/${id}/delete`, {
    _method: "DELETE",
  });
  console.log(status.data);
  if (status.data) {
    is_deleted.value = true;
  }
};
</script>
