<template>
  <div class="projects flex flex-wrap justify-start gap">
    <div
      v-for="data in internshipsData"
      :key="data.id"
      @click="$emit('show', data)"
      class="cursor-pointer project hover:border-base-alt rounded-md p-1 mb-1"
    >
      <Project :image="data.project_pic"></Project>
    </div>
  </div>
</template>
<script setup>
import Project from "./Project.vue";

const props = defineProps({
  internshipsData: Array,
});
</script>
