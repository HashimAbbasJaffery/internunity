<template>
  <section
    id="project-add-modal"
    class="bg-black/75 fixed w-full h-full top-0 left-0 flex justify-center items-center z-10"
  >
    <div class="experience bg-white w-1/2 p-3 rounded-md relative">
      <label for="name">
        <p class="text-sm mb-1">Company</p>
        <p class="text-red-500 text-xs mb-1" v-if="errors.company_name">
          {{ errors.company_name[0] }}
        </p>
        <input
          type="text"
          id="name"
          v-model="newExperience.company_name"
          class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
          :class="{ 'border border-red-500': errors.company_name?.length ?? false }"
        />
      </label>
      <div class="duration flex gap-2">
        <label for="name" class="w-1/2">
          <p class="text-sm mb-1">From</p>
          <p class="text-red-500 text-xs mb-1" v-if="errors.from">
            {{ errors.from[0] }}
          </p>
          <input
            type="date"
            id="name"
            v-model="newExperience.from"
            :class="{ 'border border-red-500': errors.from?.length ?? false }"
            class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
          />
        </label>
        <label for="name" class="w-1/2">
          <p class="text-sm mb-1">To</p>
          <p class="text-red-500 text-xs mb-1" v-if="errors.to">
            {{ errors.to[0] }}
          </p>
          <input
            type="date"
            id="name"
            v-model="newExperience.to"
            :class="{ 'border border-red-500': errors.to?.length ?? false }"
            class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
          />
        </label>
      </div>
      <label for="name" class="w-1/2">
        <p class="text-sm mb-1">Description</p>

        <p class="text-red-500 text-xs mb-1" v-if="errors.description">
          {{ errors.description[0] }}
        </p>
        <textarea
          type="date"
          id="name"
          rows="4"
          v-model="newExperience.description"
          :class="{ 'border border-red-500': errors.description?.length ?? false }"
          class="resize-none mb-3 shade outline-none p-1 text-sm w-full rounded-md"
        ></textarea>
      </label>
      <div class="actions flex">
        <button
          class="disabled:bg-base-alt/50 bg-base-alt text-white px-3 py-1 rounded-md mr-1"
          @click="$emit('create', newExperience)"
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
  experience: {
    default: {},
    type: Object,
  },
});

const newExperience = reactive({
  company_name: "",
  description: "",
  from: "",
  to: "",
  id: "",
});

onMounted(() => {
  if (Object.keys(props.experience).length) {
    newExperience.company_name = props.project.company_name;
    newExperience.from = props.project.from;
    newExperience.to = props.project.to;
    newExperience.description = props.project.description;
    newExperience.id = props.project.id;
  }
});
</script>
