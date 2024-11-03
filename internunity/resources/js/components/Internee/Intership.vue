<template>
  <div class="actions absolute right-5 flex gap-2 text-xs">
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
</template>
<script setup>
import moment from "moment";

const props = defineProps({
  internship: Object,
  is_loading: Boolean,
});
</script>
