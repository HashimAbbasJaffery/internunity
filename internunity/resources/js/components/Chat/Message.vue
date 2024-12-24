<template>
  <div
    class="reciever w-full p-2 flex gap-1 items-start"
    :class="{ 'flex-row-reverse': reciever }"
  >
    <!-- sender w-full p-2 flex gap-1 items-start -->
    <div class="sender-image">
      <img src="https://placehold.co/30x30" class="rounded-md" alt="" />
    </div>
    <div class="sender-message">
      <div class="text-xs bg-base text-white rounded-md p-1 max-w-96">
        <slot></slot>
      </div>
    </div>
  </div>
</template>
<script setup>
const props = defineProps({
  reciever: {
    type: Boolean,
    default: false,
  },
});
</script>
