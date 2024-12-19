<template>
  <company-layout>
    <div class="wrapper container mx-auto w-2/3">
      <section id="search" class="flex justify-between">
        <InputMarkup v-model="keyword" @search="keyword = $event"></InputMarkup>
      </section>
      <div class="users divide-y-4">
        <div class="user w-full mt-5" v-for="user in users" :key="user.id">
          <user :user="user"></user>
        </div>
      </div>
      <div class="loading-container flex justify-center mt-3" v-if="is_loading">
        <loader class="loader" :is_loading="is_loading"></loader>
      </div>
      <load-more
        v-if="next && !is_loading"
        :is_loading="is_loading_more"
        @click="nextInternships"
        class="mx-auto mt-4 mb-4"
      ></load-more>
    </div>
  </company-layout>
</template>
<script setup>
import { onMounted, provide, ref, watch } from "vue";
import CompanyLayout from "../../components/Shared/CompanyLayout.vue";
import useFetch from "../../components/composables/fetch";
import LoadMore from "../../components/Utils/LoadMore.vue";
import InputMarkup from "../../components/Utils/InputMarkup.vue";
import { debounce } from "lodash";
import User from "../../components/User.vue";
import Loader from "../../components/Utils/Loader.vue";

const keyword = ref("");
const show_global_loading = ref(false);
const url = ref(`/api/company/users`);
const {
  internshipsData: users,
  is_loading,
  is_loading_more,
  next,
  fetch,
  per_page,
} = useFetch(url, show_global_loading);
const company = ref([]);
provide("company", company);

const search = () => {
  users.value = [];
  url.value = `/api/company/users?q=${keyword.value}`;
  fetch();
};

watch(
  keyword,
  debounce(() => search(), 500)
);

const get_company = async () => {
  const status = await axios.get("/api/company");
  company.value = status.data;
};

onMounted(async () => {
  await get_company();
});

const nextInternships = () => {
  url.value = next.value;
  fetch();
};
</script>
