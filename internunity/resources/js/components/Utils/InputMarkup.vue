<template>
  <input
    type="text"
    v-model="keyword"
    class="shade w-full outline-none rounded-md px-3 py-2 mt-3"
    placeholder="Search"
  />
</template>
<script setup>
import { ref, watch, defineEmits } from "vue";

let emit = defineEmits(["search"]);

const keyword = ref();

watch(keyword, function () {
  emit("search", keyword.value);
});
</script>
