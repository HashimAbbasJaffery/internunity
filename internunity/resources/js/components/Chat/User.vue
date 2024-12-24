<template>
  <div class="user flex gap-2 p-1 rounded-md cursor-pointer">
    <div class="user-pic relative">
      <div
        class="online bg-green-500 rounded-full absolute border-2 border-white bottom-0"
        style="right: -3px; width: 12px; height: 12px"
      >
        &nbsp;
      </div>
      <img
        :src="
          user.profile_pic
            ? `/storage/profile/${user.profile_pic}`
            : 'https://placehold.co/45x45'
        "
        style="height: 45px; height: 45px"
        class="rounded-md"
        alt=""
      />
    </div>
    <div class="user-detail text-black">
      <p class="text-sm font-bold">
        {{ user.name }}
      </p>
      <div class="text-xs italic last-message">{{ last_message.substring(0, 40) }}</div>
    </div>
  </div>
</template>
<script setup>
const props = defineProps({
  last_message: String,
  user: Object,
});
</script>
