<template>
  <section
    v-if="Object.keys(internship).length"
    id="internship-modal"
    class="bg-black/75 fixed w-full h-full top-0 flex justify-center items-center z-10"
  >
    <div class="internship bg-white w-1/2 p-3 rounded-md relative">
      <div class="actions absolute right-5 flex gap-2 text-xs">
        <button class="bg-base-alt px-2 py-1 text-white rounded-md">
          <i class="fa-solid fa-heart text-black"></i>
        </button>
        <button class="notify bg-red-500 text-white px-2 py-1 rounded-md">
          <i class="fa-solid fa-flag"></i>
        </button>
      </div>

      <h1 class="font-bold text-xl">{{ internship.title }}</h1>
      <p class="text-xs italic opacity-75">
        Posted {{ moment(internship.created_at).fromNow() }}
      </p>
      <p class="text-sm mt-3 border-b border-grey pb-3">
        {{ internship.description }}
      </p>
      <p class="stipend text-sm">
        Stipend: {{ internship.stipend.toLocaleString() }} PKR
      </p>
      <p class="skills mt-3 space-x-2">
        <span
          v-for="tag in internship.tags"
          :key="tag.id"
          class="tag bg-base-alt text-black text-xs rounded-full p-2"
          >{{ tag.tag }}</span
        >
      </p>
      <div class="actions space-x-2">
        <button
          @click="$emit('apply')"
          :disabled="internship.applications.length"
          class="disabled:bg-blue-500/50 disabled:cursor-not-allowed bg-blue-500 text-white px-3 py-1 rounded-md mt-5 text-xs"
        >
          Apply
        </button>
        <button
          @click="internship = []"
          class="bg-red-500 text-white px-3 py-1 rounded-md mt-5 text-xs"
        >
          Cancel
        </button>
      </div>
    </div>
  </section>
</template>
<script setup>
import { inject } from "vue";
import moment from "moment";

const internship = inject("internship");
</script>
