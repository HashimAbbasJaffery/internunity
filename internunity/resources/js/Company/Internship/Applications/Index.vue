<template>
  <company-layout>
    <div class="content" v-if="!actions.loading">
      <div class="container mt-4 rounded mx-auto w-2/3 relative">
        <div class="absolute right-3 top-3">
          <bar
            class="text-xs"
            @toggle="show_more_options = !show_more_options"
            :show_more_options="show_more_options"
          >
            <ul class="space-y-2 text-xs">
              <li class="flex items-center gap-2" @click="closeInternship">
                Close Application
              </li>
              <li
                @click="$router.push(`/company/internship/${internship.id}/update`)"
                class="flex items-center gap-2"
              >
                Update
                <i class="fa-solid fa-pen"></i>
              </li>
              <li
                class="flex items-center gap-2"
                @click="deleteInternship(internship.id)"
              >
                Delete
                <i class="fa-solid fa-trash"></i>
              </li>
            </ul>
          </bar>
        </div>
        <div class="internship shade p-2">
          <h1 class="text-xl font-bold">{{ internship.title }}</h1>
          <p class="text-sm">
            {{ internship.description }}
          </p>

          <p class="text-xs text-gray-400 italic mt-3">
            Stipend: {{ internship.stipend }} RS
          </p>
        </div>
        <div class="applications" v-if="applications?.length && !actions.closed">
          <application
            v-for="application in applications"
            :key="application.id"
            :application="application"
          ></application>
        </div>
        <div
          v-else-if="actions.closed"
          class="bg-red-400 text-white px-3 py-2 mt-3 rounded-md"
        >
          This internship has been closed!
        </div>
        <div v-else class="bg-base-alt px-3 py-2 rounded mt-2">No Applications yet!</div>
      </div>
      <div class="loading-container p-3">
        <load-more
          v-if="next_applications"
          :is_loading="is_loading_more"
          class="mx-auto"
          @click="get_applications(next_applications)"
        ></load-more>
      </div>
    </div>
    <div v-else class="mt-5 loader-container flex justify-center">
      <loader class="loader"></loader>
    </div>
  </company-layout>
</template>
<script setup>
import { provide, onMounted, reactive, ref } from "vue";
import CompanyLayout from "../../../components/Shared/CompanyLayout.vue";
import { useRoute } from "vue-router";
import axios from "axios";
import Application from "../../../components/Utils/Application.vue";
import LoadMore from "../../../components/Utils/LoadMore.vue";
import Bar from "../../../components/Utils/Bar.vue";
import Loader from "../../../components/Utils/Loader.vue";

const route = useRoute();
const internship = ref([]);
const global_loader = ref(false);
const is_loading_more = ref(false);
const applications = ref([]);
const next_applications = ref();
const show_more_options = ref(false);

const get_internship = async () => {
  const status = await axios.get(`/api/company/internships/${route.params.internship}`);
  internship.value = status.data;
};

const actions = reactive({
  closing: false,
  closed: false,
  loading: false,
});

provide("closed", actions.closed);

const get_applications = async () => {
  is_loading_more.value = true;
  const status = await axios.get(
    next_applications.value
      ? next_applications.value
      : `/api/company/applications/${internship.value.id}`
  );
  next_applications.value = status.data.next_page_url;
  is_loading_more.value = false;
  applications.value.push(...status.data.data);
};

onMounted(async () => {
  actions.loading = true;
  await get_internship();
  await get_applications();
  actions.loading = false;
  actions.closed = !internship.value.status;
});

const closeInternship = async () => {
  actions.closing = true;
  const status = await axios.post(
    `/api/company/internship/${route.params.internship}/close`,
    {
      _method: "PUT",
    }
  );
  actions.closing = false;
  console.log(status.data);
  if (status.data) actions.closed = true;
};
</script>
