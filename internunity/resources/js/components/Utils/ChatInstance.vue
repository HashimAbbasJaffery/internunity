<template>
  <div class="chats bg-white rounded z-10 w-1/5 shade p-2">
    <div
      class="chatting-with flex gap-3 justify-between items-center"
      style="height: 20px"
      @click="is_opened = !is_opened"
    >
      <!-- <div class="new-message-marker bg-red-500" style="width: 10px; height: 10px">
        &nbsp;
      </div> -->
      <p class="text-sm">{{ chat.company.company }}</p>
      <i
        class="fa-solid fa-xmark cursor-pointer"
        @click="$emit('deleteChat', chat.id)"
      ></i>
    </div>
    <div
      v-if="is_opened"
      class="chat-contents mt-4 space-y-2 h-4/6 hidden-scrollbar"
      style="overflow: auto; height: 250px"
    >
      <div
        v-for="(chat, index) in chat.chats"
        class="receiver w-full flex"
        :class="{
          sender: chat.from === 'user',
          'flex-row-reverse': chat.from !== 'user',
        }"
        :key="index"
      >
        <div
          :class="{
            'sender-content bg-base-alt': chat.from === 'user',
            'receiver-content bg-base text-white': chat.from !== 'user',
          }"
          class="text-xs p-2 rounded"
          style="max-width: 75%"
        >
          <p>{{ chat.message }}</p>
        </div>
      </div>
    </div>
    <div class="flex gap-2 mt-3" v-if="is_opened">
      <input
        type="text"
        class="outline-none text-sm p-1 w-5/6 shade"
        placeholder="Type Messsage"
        name=""
        id=""
      />
      <button class="bg-base-alt w-1/5 text-white text-xs">Send</button>
    </div>
  </div>
</template>
<script setup>
import { ref, toRef } from "vue";

const is_opened = ref(true);

const props = defineProps({
  chat: Object,
});
</script>
