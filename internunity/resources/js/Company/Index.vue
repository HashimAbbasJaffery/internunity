<template>
  <company-layout>
    <main>
      <section id="search" class="container mx-auto w-2/3 flex justify-between">
        <InputMarkup v-model="keyword" @search="keyword = $event"></InputMarkup>
      </section>
      <section
        id="internships"
        class="container mx-auto mt-9 w-2/3"
        :class="{ 'divide-y-2': !is_loading }"
      >
        <button class="bg-base-alt text-white px-2 py-1 rounded">New Internship</button>
        <Internships viewFor="company" url="/api/company/internships"></Internships>
        <div
          v-if="is_loading"
          class="relative internship bg-white mt-3 rounded-md p-2 hover:bg-grey cursor-pointer"
        >
          <loading-skeleton v-for="i in 8" :key="i"></loading-skeleton>
        </div>
      </section>
    </main>
  </company-layout>
</template>

<script setup>
import { provide, ref } from "vue";
import Internships from "../components/Internee/Internships.vue";
import InputMarkup from "../components/Utils/InputMarkup.vue";
import CompanyLayout from "../components/Shared/CompanyLayout.vue";
import LoadingSkeleton from "../components/Utils/LoadingSkeleton.vue";

const internship = ref([]);
provide("internship", internship);

const keyword = ref();

provide("keyword", keyword);
</script>
