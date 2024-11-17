<template>
  <section
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
          @change="upload_image"
          id="project_file"
          class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
        />
      </label>
      <div class="actions flex">
        <button
          class="disabled:bg-base-alt/50 bg-base-alt text-white px-3 py-1 rounded-md mr-1"
          @click="$emit('create', newProject)"
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
          @click="$emit('close')"
          class="bg-red-500 text-white px-3 py-1 rounded-md"
        >
          Cancel
        </button>
      </div>
    </div>
  </section>
</template>
<script setup>
import { onMounted, reactive } from "vue";

const props = defineProps({
  isLoading: Boolean,
  errors: Object,
  project: {
    default: {},
    type: Object,
  },
});

const newProject = reactive({
  title: "",
  youtube: "",
  github: "",
  description: "",
  id: "",
  project_file: "",
});

const upload_image = () => {
  newProject.project_file = project_file.files[0];
};

onMounted(() => {
  if (Object.keys(props.project).length) {
    newProject.title = props.project.title;
    newProject.youtube = props.project.youtube;
    newProject.github = props.project.github;
    newProject.description = props.project.description;
    newProject.id = props.project.id;
  }
});
</script>
