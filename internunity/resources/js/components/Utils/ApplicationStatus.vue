<template>
  <div v-if="!is_loading" class="tags my-3 container mx-auto w-2/3 space-x-2">
    <span
      class="tag text-xs rounded-full cursor-pointer p-2"
      :class="{
        'bg-base-alt text-black': internshipType === 'applied',
        'bg-black text-white': internshipType !== 'applied',
      }"
      @click="$emit('changeType', 'applied')"
      >Applied ({{
        internshipsData.filter((status) => status.status === "applied")[0]?.count ?? 0
      }})</span
    >
    <span
      class="tag text-xs rounded-full cursor-pointer p-2"
      :class="{
        'bg-base-alt text-black': internshipType === 'interviewing',
        'bg-black text-white': internshipType !== 'interviewing',
      }"
      @click="$emit('changeType', 'interviewing')"
      >Interviewing ({{
        internshipsData.filter((status) => status.status === "interviewing")[0]?.count ??
        0
      }})</span
    >
    <span
      class="tag text-xs rounded-full cursor-pointer p-2"
      @click="$emit('changeType', 'rejected')"
      :class="{
        'bg-base-alt text-black': internshipType === 'rejected',
        'bg-black text-white': internshipType !== 'rejected',
      }"
      >Rejected ({{
        internshipsData.filter((status) => status.status === "rejected")[0]?.count ?? 0
      }})</span
    >
    <span
      class="tag text-xs rounded-full cursor-pointer p-2"
      @click="$emit('changeType', 'selected')"
      :class="{
        'bg-base-alt text-black': internshipType === 'selected',
        'bg-black text-white': internshipType !== 'selected',
      }"
      >Selected ({{
        internshipsData.filter((status) => status.status === "selected")[0]?.count ?? 0
      }})</span
    >
  </div>
  <div v-else class="tags my-3 container mx-auto w-2/3 space-x-2 flex">
    <div>
      <span
        class="tag text-xs rounded-full cursor-pointer p-2 bg-gray-400 opacity-50 text-gray-400"
        style="width: 200px"
        >Applied</span
      >
    </div>
    <div>
      <span
        class="tag text-xs rounded-full cursor-pointer p-2 bg-gray-400 opacity-50 text-gray-400"
        style="width: 200px"
        >Interviewing</span
      >
    </div>
    <div>
      <span
        class="tag text-xs rounded-full cursor-pointer p-2 bg-gray-400 opacity-50 text-gray-400"
        style="width: 200px"
        >Rejected</span
      >
    </div>
    <div>
      <span
        class="tag text-xs rounded-full cursor-pointer p-2 bg-gray-400 opacity-50 text-gray-400"
        style="width: 200px"
        >Selected</span
      >
    </div>
  </div>
</template>
<script setup>
import { ref } from "vue";
import useFetch from "../composables/fetch";

const props = defineProps({
  internshipType: String,
});

const global_loading = ref(false);
const url = ref(`/api/status/get`);
const { internshipsData, is_loading, is_loading_more, next, fetch, per_page } = useFetch(
  url,
  global_loading
);
</script>
