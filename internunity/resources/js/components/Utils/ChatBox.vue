<template>
  <div class="hover:bg-gray-200 cursor-pointer chat rounded z-10 w-1/5">
    <div
      class="chat-header bg-white flex items-center gap-2 border border-black py-2"
      @click="is_clicked = !is_clicked"
    >
      <p class="pl-2">Messages</p>
      <div
        class="quantity bg-red-500 text-white rounded-full text-xs flex justify-center items-center"
        style="width: 15px; height: 15px"
        v-if="message_notifications.length"
      >
        {{ message_notifications.length }}
      </div>
    </div>

    <div
      v-if="is_clicked"
      class="chat-contents shade bg-white"
      style="height: 300px; overflow: auto"
    >
      <div class="contacts" v-for="room in rooms" @click="addChat(room)" :key="room.id">
        <Room :room="room"></Room>
      </div>
    </div>
  </div>
</template>
<script setup>
import { onMounted, ref, inject, computed } from "vue";
import Room from "./Room.vue";

const is_clicked = ref(false);

const props = defineProps({
  message_notifications: Object,
  rooms: Object,
});

onMounted(() => {
  console.log(props.rooms);
  console.log("lo");
});

let chats = inject("chats");

const addChat = (room) => {
  if (chats.value.filter((chat) => chat.id === room.id).length) return;
  chats.value.push(room);
};
</script>
