<template>
  <section
    id="project-add-modal"
    class="bg-black/75 fixed w-full h-full top-0 left-0 flex justify-center items-center z-10"
  >
    <div class="experience bg-white w-1/2 p-3 rounded-md relative">
      <label for="name" class="w-1/2">
        <p class="text-sm mb-1">Cover Letter</p>

        <p class="text-red-500 text-xs mb-1" v-if="errors.cover_letter">
          {{ errors.cover_letter[0] }}
        </p>
        <textarea
          type="date"
          id="name"
          rows="4"
          v-model="newApplication.cover_letter"
          :class="{ 'border border-red-500': errors.cover_letter?.length ?? false }"
          class="resize-none mb-3 shade outline-none p-1 text-sm w-full rounded-md"
        ></textarea>
      </label>
      <label for="name" class="w-1/2">
        <p class="text-sm mb-1">Resume</p>
        <input
          type="file"
          @change="upload_image"
          id="resume"
          class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
        />
      </label>
      <div class="actions flex">
        <button
          class="disabled:bg-base-alt/50 bg-base-alt text-white px-3 py-1 rounded-md mr-1"
          @click="$emit('create', newApplication)"
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

const newApplication = reactive({
  cover_letter: "",
  id: "",
  resume: "",
});

const upload_image = () => {
  newApplication.resume = resume.files[0];
};

onMounted(() => {
  if (Object.keys(props.project).length) {
    newApplication.title = props.project.title;
    newApplication.youtube = props.project.youtube;
    newApplication.github = props.project.github;
    newApplication.cover_letter = props.project.cover_letter;
    newApplication.id = props.project.id;
  }
});
</script>
