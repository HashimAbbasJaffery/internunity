<template>
  <section
    id="project-modal"
    class="bg-black/75 fixed w-full h-full top-0 left-0 flex justify-center items-center z-10"
  >
    <div class="project bg-white w-1/2 p-3 rounded-md relative">
      <div class="icons relative">
        <div
          @click="showMenu = !showMenu"
          class="cursor-pointer close bg-white absolute shade p-1 left-5 top-5 px-2 rounded-md text-white"
          :class="{ 'bg-gray-200': showMenu }"
        >
          <i class="fa-solid fa-bars text-black"></i>
        </div>
        <div
          @click="$emit('close')"
          class="cursor-pointer close bg-red-500 absolute p-1 right-5 mr-2 top-5 px-2 rounded-md text-white"
        >
          <i class="fa-solid fa-xmark"></i>
        </div>
        <div
          class="actions-list absolute left-5 top-12 mt-3 bg-white mr-3 px-1 py-2 shade rounded w-1/6 text-center"
          v-if="showMenu"
        >
          <ul class="space-y-1">
            <li class="text-xs" @click="$emit('delete')">
              Delete
              <i class="fa-solid fa-trash ml-1"></i>
            </li>
            <li class="text-xs" @click="$emit('update')">
              Update
              <i class="fa-solid fa-pen-to-square ml-1"></i>
            </li>
          </ul>
        </div>
      </div>
      <img
        :src="
          project.project_pic
            ? `/storage/projects/${project.project_pic}`
            : 'https://placehold.co/600x300'
        "
        style="height: 300px; width: 100%; object-fit: cover"
        class="w-full rounded-md"
        alt=""
      />
      <h1 class="text-3xl font-bold mt-3 opacity-75">{{ project.title }}</h1>
      <p class="mt-3 text-sm">
        {{ project.description }}
      </p>
      <div class="icons mt-3 space-x-1 text-sm">
        <a :href="project.github" v-if="project.github" class="fa-brands fa-github"></a>
        <a
          :href="project.youtube"
          v-if="project.youtube"
          class="fa-brands fa-youtube"
        ></a>
      </div>
    </div>
  </section>
</template>
<script setup>
import { ref } from "vue";

const props = defineProps({
  project: Object,
});

const showMenu = ref(false);
</script>
