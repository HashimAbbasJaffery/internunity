<template>
  <section
    id="project-add-modal"
    class="bg-black/75 fixed w-full h-full top-0 left-0 flex justify-center items-center z-10"
  >
    <div class="experience bg-white w-1/2 p-3 rounded-md relative">
      <label for="name" class="w-1/2">
        <p class="text-sm mb-1">Report</p>

        <p class="text-red-500 text-xs mb-1" v-if="errors.report_type_id">
          {{ errors.report_type_id[0] }}
        </p>
        <select
          name=""
          id="report_types"
          v-model="newReport.report_type_id"
          :class="{ 'border border-red-500': errors.report_type_id?.length ?? false }"
          class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
        >
          <option :value="type.id" v-for="type in types" :key="type.id">
            {{ type.report }}
          </option>
        </select>
      </label>
      <label for="name" class="w-1/2">
        <p class="text-sm mb-1">Description</p>

        <p class="text-red-500 text-xs mb-1" v-if="errors.description">
          {{ errors.description[0] }}
        </p>
        <textarea
          type="date"
          id="name"
          v-model="newReport.description"
          :class="{ 'border border-red-500': errors.description?.length ?? false }"
          class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
        ></textarea>
      </label>
      <div class="actions flex">
        <button
          class="disabled:bg-base-alt/50 bg-base-alt text-white px-3 py-1 rounded-md mr-1"
          @click="$emit('create', newReport)"
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
import { inject, onMounted, reactive } from "vue";

const props = defineProps({
  errors: Object,
  project: {
    default: {},
    type: Object,
  },
});

const newReport = reactive({
  report_type_id: 1,
  id: "",
  description: "",
});

onMounted(() => {
  if (Object.keys(props.project).length) {
    newReport.title = props.project.title;
    newReport.youtube = props.project.youtube;
    newReport.github = props.project.github;
    newReport.report = props.project.report;
    newReport.id = props.project.id;
  }
});

const isLoading = inject("is_loading");

const types = inject("report_types");
</script>
