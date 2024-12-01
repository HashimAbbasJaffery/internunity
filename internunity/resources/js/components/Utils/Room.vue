<template>
  <div class="contact p-3 flex gap-2 hover:bg-gray-200" @click="read">
    <div class="contact-pic">
      <img src="https://placehold.co/50x50" class="rounded-full" alt="" />
    </div>
    <div class="contact-body">
      <p class="text-sm mt-1" :class="{ 'font-bold': !is_read }">
        {{ room.company.company.substr(0, 20) }}
      </p>
      <p class="text-xs text-gray-600 italic mt-1" :class="{ 'font-bold': !is_read }">
        {{
          room.chats[room.chats?.length - 1]?.["message"].substr(0, 25) ?? "*No Chats*"
        }}
      </p>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { computed, ref } from "vue";

const props = defineProps({
  room: Object,
});

const room = ref(props.room);

const is_read = computed(() => props.room.is_read);

const read = async () => {
  if (!is_read.value) {
    const request = await axios.post(`/api/message/${props.room.id}/changeStatus`, {
      _method: "PATCH",
    });
    props.room.is_read = true;
  }
};
</script>
