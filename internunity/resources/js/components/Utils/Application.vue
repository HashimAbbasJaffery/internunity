<template>
  <div class="application mt-4 p-4 shade flex items-start">
    <div
      class="application-submitter w-1/6 flex flex-col justify-center items-center flex-shrink-0"
    >
      <img
        :src="
          application.user.profile_pic
            ? '/storage/profile/' + application.user.profile_pic
            : 'https://placehold.co/90x90'
        "
        width="60"
        class="rounded-full"
        alt=""
      />
      <p class="text-xs text-gray-400 mt-1">{{ application.user?.name }}</p>
      <button class="text-xs bg-base-alt text-white rounded-md px-2 py-1 mt-2">
        View Profile
      </button>
      <div
        v-if="is_done.rejected"
        class="text-xs bg-red-600 text-white rounded-md px-2 py-1 mt-2"
      >
        Rejected
      </div>
      <div
        v-if="!is_done.rejected && is_done.hired"
        class="text-xs bg-green-600 text-white rounded-md px-2 py-1 mt-2"
      >
        Hired
      </div>
    </div>
    <div class="w-5/6 flex flex-col justify-between">
      <p
        class="text-xs leading-5 cover-letter"
        v-html="`${application.cover_letter.substr(0, last_index_to_read)}`"
      ></p>
      <p class="text-xs underline mt-2 cursor-pointer" @click="readMore">
        {{ last_index_to_read < Infinity ? "Read More" : "Collapse" }}
      </p>
      <div class="actions">
        <button class="bg-black text-white text-xs rounded-md px-2 py-1 mt-2 mr-1">
          Message
        </button>
        <button
          :disabled="loaders.hire || is_done.rejected || is_done.hired || is_closed"
          @click="hire"
          class="bg-black text-white text-xs rounded-md px-2 py-1 mt-2 mr-1 disabled:bg-black/50 disabled:cursor-not-allowed"
        >
          <span v-if="!loaders.hire">Hire</span>
          <Loader v-else class="loader loader-white loader-short"></Loader>
        </button>
        <button
          class="bg-black text-white text-xs rounded-md px-2 py-1 mt-2 mb-1 disabled:bg-black/50 disabled:cursor-not-allowed"
          :disabled="loaders.reject || is_done.rejected || is_done.hired || is_closed"
          @click="reject"
        >
          <span v-if="!loaders.reject">Reject</span>
          <Loader v-else class="loader loader-white loader-short"></Loader>
        </button>
        <br />
        <a
          :href="`/storage/resumes/${application.resume}`"
          class="text-xs text-gray-400"
          download
        >
          <i class="fa-solid fa-paperclip"></i>
          Attachment
        </a>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, reactive, onMounted, inject } from "vue";
import Loader from "./Loader.vue";

const props = defineProps({
  application: Object,
});

const is_done = reactive({
  rejected: false,
  hired: false,
});

const is_closed = inject("closed");

onMounted(() => {
  if (props.application.status === "selected") {
    is_done.hired = true;
  }
});

const last_index = props.application.cover_letter.substr(0, 500).lastIndexOf(" ");
const last_index_to_read = ref(last_index);
const loaders = reactive({
  hire: false,
  reject: false,
  interview: false,
  closed: is_closed,
});

const readMore = () => {
  if (last_index_to_read.value < Infinity) {
    last_index_to_read.value = Infinity;
  } else {
    last_index_to_read.value = last_index;
  }
};

const reject = async () => {
  if (is_done.rejected) return;
  loaders.reject = true;
  const status = await axios.post(
    `/api/company/internship/${props.application.id}/reject`,
    { _method: "PUT" }
  );
  loaders.reject = false;
  is_done.rejected = true;
};

const hire = async () => {
  if (is_done.hired) return;
  loaders.hire = true;
  const status = await axios.post(
    `/api/company/internship/${props.application.id}/hire`,
    {
      _method: "PUT",
    }
  );
  loaders.hire = false;
  is_done.hired = true;
};
</script>
