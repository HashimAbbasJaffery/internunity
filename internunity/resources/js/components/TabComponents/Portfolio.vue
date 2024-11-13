<template>
  <section
    id="project-modal"
    class="bg-black/75 fixed w-full h-full top-0 left-0 flex justify-center items-center z-10"
    v-if="Object.keys(project ?? [])?.length ?? false"
  >
    <div class="project bg-white w-1/2 p-3 rounded-md relative">
      <div
        @click="project = []"
        class="cursor-pointer close bg-red-500 absolute p-1 right-5 top-5 px-2 rounded-md text-white"
      >
        <i class="fa-solid fa-xmark"></i>
      </div>
      <img src="https://placehold.co/600x300" class="w-full rounded-md" alt="" />
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

  <section
    v-if="addModal"
    id="project-add-modal"
    class="bg-black/75 fixed w-full h-full top-0 left-0 flex justify-center items-center z-10"
  >
    <div class="experience bg-white w-1/2 p-3 rounded-md relative">
      <label for="name">
        <p class="text-sm mb-1">Project Title</p>
        <p class="text-red-500 text-xs mb-1" v-if="errors.title">{{ errors.title[0] }}</p>
        <input
          type="text"
          id="name"
          v-model="newProject.title"
          class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
          :class="{ 'border border-red-500': errors.title?.length ?? false }"
        />
      </label>
      <div class="duration flex gap-2">
        <label for="name" class="w-1/2">
          <p class="text-sm mb-1">Youtube Link</p>
          <p class="text-red-500 text-xs mb-1" v-if="errors.youtube">
            {{ errors.youtube[0] }}
          </p>
          <input
            type="text"
            id="name"
            v-model="newProject.youtube"
            :class="{ 'border border-red-500': errors.youtube?.length ?? false }"
            class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
          />
        </label>
        <label for="name" class="w-1/2">
          <p class="text-sm mb-1">Github Link</p>
          <p class="text-red-500 text-xs mb-1" v-if="errors.github">
            {{ errors.github[0] }}
          </p>
          <input
            type="text"
            id="name"
            v-model="newProject.github"
            :class="{ 'border border-red-500': errors.github?.length ?? false }"
            class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
          />
        </label>
      </div>
      <label for="name" class="w-1/2">
        <p class="text-sm mb-1">Project Description</p>

        <p class="text-red-500 text-xs mb-1" v-if="errors.description">
          {{ errors.description[0] }}
        </p>
        <textarea
          type="date"
          id="name"
          rows="4"
          v-model="newProject.description"
          :class="{ 'border border-red-500': errors.description?.length ?? false }"
          class="resize-none mb-3 shade outline-none p-1 text-sm w-full rounded-md"
        ></textarea>
      </label>
      <label for="name" class="w-1/2">
        <p class="text-sm mb-1">Project Image</p>
        <input
          type="file"
          id="name"
          class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
        />
      </label>
      <div class="actions flex">
        <button
          class="disabled:bg-base-alt/50 bg-base-alt text-white px-3 py-1 rounded-md mr-1"
          @click="addProject"
          :disabled="isLoading"
          :class="{ 'flex justify-center items-center gap-2': isLoading }"
        >
          Add

          <Loader
            :is_loading="isLoading"
            className="loader loader-white loader-short"
          ></Loader>
        </button>
        <button
          @click="addModal = false"
          class="bg-red-500 text-white px-3 py-1 rounded-md"
        >
          Cancel
        </button>
      </div>
    </div>
  </section>
  <section
    id="portfolio"
    class="shade w-2/3 p-3 rounded-md"
    :class="{ 'flex justify-center items-center': is_loading }"
  >
    <div class="content" v-if="internshipsData.length">
      <h1 class="font-bold mb-2 text-xl">Projects</h1>
      <div class="projects flex flex-wrap justify-start gap">
        <div
          v-for="data in internshipsData"
          @click="project = data"
          :key="data.id"
          class="cursor-pointer project hover:border-base-alt rounded-md p-1 mb-1"
        >
          <img src="https://placehold.co/95x95" class="rounded-md" alt="" />
        </div>
        <div
          class="cursor-pointer project hover:border-base-alt rounded-md p-1 mb-1 border-dotted border-2 border-base-alt"
          @click="addModal = true"
        >
          <div class="add flex justify-center items-center h-full" style="width: 90px">
            <i class="fa-solid fa-plus"></i>
          </div>
        </div>
      </div>
      <div class="load-more w-full flex justify-center items-center">
        <button
          @click="url = next"
          v-if="next"
          class="bg-base-alt text-white px-3 py-1 rounded-md mt-3 disabled:bg-base-alt/50 disabled:cursor-not-allowed"
          :disabled="is_loading_more"
          :class="{ 'flex justify-center items-center gap-2': is_loading_more }"
        >
          Load More
          <Loader
            :is_loading="is_loading_more"
            className="loader loader-white loader-short"
          ></Loader>
        </button>
      </div>
    </div>
    <Loader v-else :is_loading="is_loading" class="loader"></Loader>
  </section>
</template>
<script setup>
import { onMounted, reactive, ref } from "vue";
import useFetch from "../composables/fetch";
import Loader from "../Utils/Loader.vue";
import usePost from "../composables/post";
import { add } from "lodash";

const project = ref();
const url = ref(`/api/user/projects`);
const is_global_loading = ref(false);
const { internshipsData, is_loading, is_loading_more, next } = useFetch(
  url,
  is_global_loading
);
const { isLoading, addData, errors } = usePost(`/api/user/project/create`);
const addModal = ref(false);
const newProject = reactive({
  title: "",
  youtube: "",
  github: "",
  description: "",
});

const addProject = () => {
  addData(newProject);
};
</script>
