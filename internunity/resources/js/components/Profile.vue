<template>
  <Layout>
    <main>
      <section class="profile container mx-auto w-2/3 flex mt-4 gap-2 items-start">
        <nav class="options bg-base-alt text-white w-1/3 p-2 rounded-md">
          <ul class="space-y-3">
            <li
              @click="tab = 'personal'"
              class="cursor-pointer hover:bg-black/50 px-3 py-1 rounded-md"
              :class="{ 'bg-black': tab === 'personal' }"
            >
              Personal Information
            </li>
            <li
              @click="tab = 'portfolio'"
              class="cursor-pointer hover:bg-black/50 px-3 py-1 rounded-md"
              :class="{ 'bg-black': tab === 'portfolio' }"
            >
              Portfolio
            </li>
            <li
              @click="tab = 'experiences'"
              class="cursor-pointer hover:bg-black/50 px-3 py-1 rounded-md"
              :class="{ 'bg-black': tab === 'experiences' }"
            >
              Experiences
            </li>
            <li
              @click="tab = 'education'"
              class="cursor-pointer hover:bg-black/50 px-3 py-1 rounded-md"
              :class="{ 'bg-black': tab === 'education' }"
            >
              Education
            </li>
          </ul>
        </nav>
        <Personal v-if="tab === 'personal'"></Personal>
        <Portfolio v-if="tab === 'portfolio'"></Portfolio>
        <Experiences v-if="tab === 'experiences'"></Experiences>
        <Education v-if="tab === 'education'"></Education>
      </section>
    </main>
  </Layout>
</template>
<script setup>
import Layout from "./Shared/Layout.vue";
import { ref } from "vue";
import Personal from "./TabComponents/Personal.vue";
import Portfolio from "./TabComponents/Portfolio.vue";
import Experiences from "./TabComponents/Experiences.vue";
import Education from "./TabComponents/Education.vue";

const tab = ref("personal");
</script>
