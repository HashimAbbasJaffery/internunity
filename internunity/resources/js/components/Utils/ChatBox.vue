<template>
  <div class="hover:bg-gray-200 cursor-pointer chat rounded z-10 w-1/5">
    <div
      class="chat-header bg-white flex items-center gap-2 border border-black py-2"
      @click="showChats"
    >
      <p class="pl-2">Messages</p>
    </div>

    <div
      v-if="is_clicked"
      class="chat-contents shade bg-white"
      style="height: 300px; overflow: auto"
    >
      <div
        class="contacts"
        v-for="room in rooms?.sort(sorting_criteria)"
        @click="addChat(room)"
        :key="room.id"
      >
        <Room :room="room"></Room>
      </div>
    </div>
  </div>
</template>
<script setup>
import { onMounted, ref, inject } from "vue";
import Room from "./Room.vue";

const is_clicked = ref(false);

const props = defineProps({
  message_notifications: Object,
  rooms: Object,
});

const sorting_criteria = (a, b) => {
  if (!a.is_read && b.is_read) {
    return -1;
  }
  if (!b.is_read && a.is_read) {
    return 1;
  }
};

let chats = inject("chats");

const addChat = (room) => {
  if (chats.value.filter((chat) => chat.id === room.id).length) return;
  chats.value.push(room);
};

const showChats = () => {
  is_clicked.value = !is_clicked.value;
};
</script>
