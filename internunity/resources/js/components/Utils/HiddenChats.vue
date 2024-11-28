<template>
  <div class="chat-list-container">
    <div v-if="is_expanded" class="bg-white shade mb-2">
      <ul>
        <li
          v-for="(chat, index) in chats"
          :key="index"
          @click="show_room(chat.id, index)"
          class="text-xs mt-2 hover:bg-gray-300 w-full p-1 px-3 cursor-pointer"
        >
          {{ chat.company.company }}
        </li>
      </ul>
    </div>
    <div
      @click="is_expanded = !is_expanded"
      class="hidden-chats bg-white p-2 border border-black flex justify-center items-center relative float-right cursor-pointer"
      style="width: 40px"
    >
      {{ chats.length }}
    </div>
  </div>
</template>
<script setup>
import { inject, ref } from "vue";

const is_expanded = ref(false);

const props = defineProps({
  chats: Object,
});

const chat_rooms = inject("chats");

const show_room = (id, index) => {
  let to_hide_index = chat_rooms.value.findIndex((chat_room) => chat_room.id === id);
  [chat_rooms.value[to_hide_index], chat_rooms.value[2]] = [
    chat_rooms.value[2],
    chat_rooms.value[to_hide_index],
  ];
};
</script>
