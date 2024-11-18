<template>
  <section
    id="project-add-modal"
    class="bg-black/75 fixed w-full h-full top-0 left-0 flex justify-center items-center z-10"
  >
    <div class="experience bg-white w-1/2 p-3 rounded-md relative">
      <label for="name">
        <p class="text-sm mb-1">Education</p>
        <p class="text-red-500 text-xs mb-1" v-if="errors.education">
          {{ errors.education[0] }}
        </p>
        <input
          type="text"
          id="name"
          v-model="newEducation.education"
          class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
          :class="{ 'border border-red-500': errors.education?.length ?? false }"
        />
      </label>
      <label for="name">
        <p class="text-sm mb-1">Organization</p>
        <p class="text-red-500 text-xs mb-1" v-if="errors.organization">
          {{ errors.organization[0] }}
        </p>
        <input
          type="text"
          id="name"
          v-model="newEducation.organization"
          class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
          :class="{ 'border border-red-500': errors.organization?.length ?? false }"
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
            v-model="newEducation.from"
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
            v-model="newEducation.to"
            :class="{ 'border border-red-500': errors.to?.length ?? false }"
            class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
          />
        </label>
      </div>
      <div class="flex gap-2">
        <label for="name" class="w-3/4">
          <p class="text-sm mb-1">Grade</p>
          <p class="text-red-500 text-xs mb-1" v-if="errors.grade">
            {{ errors.grade[0] }}
          </p>
          <input
            :type="gradeType"
            id="name"
            v-model="newEducation.grade"
            :class="{ 'border border-red-500': errors.grade?.length ?? false }"
            class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
          />
        </label>
        <label for="name" class="w-1/4">
          <p class="text-sm mb-1">Type</p>
          <p class="text-red-500 text-xs mb-1" v-if="errors.type">
            {{ errors.type[0] }}
          </p>
          <select
            name=""
            class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
            v-model="newEducation.type"
            :class="{ 'border border-red-500': errors.grade?.type ?? false }"
            @change="changeGradeType"
            id=""
          >
            <option value="1" :selected="newEducation.type === '1'">Percentage</option>
            <option value="2" :selected="newEducation.type === '2'">
              Alphabetical Grade
            </option>
            <option value="3" :selected="newEducation.type === '3'">GPA</option>
          </select>
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
          v-model="newEducation.description"
          :class="{ 'border border-red-500': errors.description?.length ?? false }"
          class="resize-none mb-3 shade outline-none p-1 text-sm w-full rounded-md"
        ></textarea>
      </label>
      <div class="actions flex">
        <button
          class="disabled:bg-base-alt/50 bg-base-alt text-white px-3 py-1 rounded-md mr-1"
          @click="$emit('create', newEducation)"
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
import { reactive, ref } from "vue";

const props = defineProps({
  isLoading: Boolean,
  errors: Object,
  experience: {
    default: {},
    type: Object,
  },
});

const gradeType = ref("number");

const changeGradeType = () => {
  if (newEducation.type === "1") gradeType.value = "number";
  if (newEducation.type === "2") gradeType.value = "text";
  if (newEducation.type === "3") gradeType.value = "number";
};

const newEducation = reactive({
  education: "",
  organization: "",
  description: "",
  grade: "",
  from: "",
  to: "",
  id: "",
  type: "1",
});
</script>
