<template>
  <div id="chat_body" class="chat-body" style="height: 80%; overflow-y: auto">
    <message
      v-for="(message, index) in messages"
      :key="index"
      :reciever="message.from !== 'company'"
    >
      {{ message.message }}
    </message>
  </div>
</template>

<script setup>
import Message from "./Message.vue";
import { onUpdated } from "vue";

const props = defineProps({
  messages: Array,
});

onUpdated(() => {
  chat_body.scrollTop = chat_body.scrollHeight;
});
</script>
