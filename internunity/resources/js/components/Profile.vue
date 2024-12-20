<template>
  <Layout>
    <main>
      <p>{{ is_loading }}</p>
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
        <div class="w-2/3" v-if="!is_loading">
          <Personal v-if="tab === 'personal'"></Personal>
          <Portfolio v-if="tab === 'portfolio'"></Portfolio>
          <Experiences v-if="tab === 'experiences'"></Experiences>
          <Education v-if="tab === 'education'"></Education>
        </div>
        <div v-else class="w-2/3 flex justify-center shade p-3 rounded-md">
          <loader class="loader" :is_loading="true"></loader>
        </div>
      </section>
    </main>
  </Layout>
</template>
<script setup>
import Layout from "./Shared/Layout.vue";
import { ref, provide, onMounted } from "vue";
import Personal from "./TabComponents/Personal.vue";
import Portfolio from "./TabComponents/Portfolio.vue";
import Experiences from "./TabComponents/Experiences.vue";
import Education from "./TabComponents/Education.vue";
import { useRoute } from "vue-router";
import useFetch from "./composables/fetch";
import axios from "axios";
import Loader from "./Utils/Loader.vue";

const route = useRoute();
const tab = ref("personal");
const is_editable = ref(Boolean(route.params.user));
const user_data = ref(null);
const global_loader = ref(false);
const is_loading = ref(true);

// Provide user data to the children components
provide("user_data", user_data);

// Provide projects data to the children components
const projects = useFetch(`/api/user/projects?user=${route.params.user}`, global_loader);
provide("projects", projects);

// Provide experiences data to the children components
const experiences = useFetch(
  `/api/user/experiences?user=${route.params.user}`,
  global_loader
);
provide("experiences", experiences);

// Provide educations data to the children components
const educations = useFetch(
  `/api/user/educations?user=${route.params.user}`,
  global_loader
);
provide("educations", educations);

const get_user = async () => {
  const user = await axios.get(`/api/user?user=${route.params.user}`);
  user_data.value = user.data;
};

onMounted(async () => {
  await get_user();
  if (projects.is_loading && experiences.is_loading && educations.is_loading) {
    is_loading.value = false;
  }
});

axios
  .get("/api/send_message")
  .then((res) => {
    console.log(res);
  })
  .catch((err) => {
    console.log(err);
  });
</script>
