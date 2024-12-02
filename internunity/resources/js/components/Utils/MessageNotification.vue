<template>
  <li
    class="text-xs hover:bg-gray-200 p-2 cursor-pointer"
    @click="console.log(notification)"
    v-if="
      notification.id &&
      ((notification.data?.extras?.type ?? notification.type) === 'broadcast.message' ||
        (notification.data?.extras?.type ?? notification.type) === 'message')
    "
  >
    <i class="fa-solid fa-message mr-2"></i>
    <span class="font-bold">
      {{
        notification.data?.extras?.room?.company?.name ??
        notification.extras?.room.company.name
      }}
    </span>
    Messaged you!
  </li>
</template>
<script setup>
const props = defineProps({
  notification: Object,
});
</script>
