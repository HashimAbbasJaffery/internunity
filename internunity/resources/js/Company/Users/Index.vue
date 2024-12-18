<template>
  <company-layout>
    <section id="search" class="container mx-auto w-2/3 flex justify-between">
      <InputMarkup v-model="keyword" @search="keyword = $event"></InputMarkup>
    </section>
    <div class="user p-4" v-for="user in users" :key="user.id">
      <div class="container mx-auto w-2/3 mt-3 space-y-4">
        <div class="user-header flex gap-2 border-b border-gray-300 pb-3">
          <div class="left-col">
            <img
              :src="`${
                user.profile_pic
                  ? '/storage/profile/' + user.profile_pic
                  : 'https://placehold.co/70x70'
              }`"
              width="60"
              class="rounded-full"
              alt=""
            />
          </div>
          <div class="right-col">
            <h2 class="text-xs">{{ user.name }}</h2>
            <h1 class="font-bold">{{ user.tagline }}</h1>
            <p class="text-xs italic text-gray-500 mt-1">Pakistan</p>
          </div>
        </div>
        <div class="user-body">
          <div class="skills flex gap-2 mt-3">
            <span
              v-for="skill in user.skills"
              :key="skill.id"
              class="text-xs text-white skill bg-base-alt px-2 py-1 rounded-full"
              >{{ skill.tag }}</span
            >
          </div>
          <p class="text-sm mt-3 text-gray-600">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet qui maxime
            est. Cumque, laudantium dolores tenetur deleniti voluptates iusto, minima quo
            quam, esse suscipit mollitia exercitationem. Inventore beatae totam saepe
            perferendis rerum veniam illum illo rem nostrum ipsum sunt tenetur culpa omnis
            pariatur architecto, fuga animi cum magni commodi repudiandae.
          </p>
        </div>
        <div class="user-footer flex justify-between">
          <button
            class="bg-base-alt text-white px-3 py-1 rounded-md mt-3 hover:bg-base-alt/75"
          >
            See Profile
          </button>
          <button class="px-3 py-1 rounded-md mt-3 text-black">
            <i class="fa-regular fa-heart"></i>
            <!-- <i class="fa-solid fa-heart"></i> -->
          </button>
        </div>
      </div>
    </div>
    <load-more
      v-if="next"
      :is_loading="is_loading_more"
      @click="nextInternships"
      class="mx-auto mt-4 mb-4"
    ></load-more>
  </company-layout>
</template>
<script setup>
import { onMounted, ref, watch } from "vue";
import CompanyLayout from "../../components/Shared/CompanyLayout.vue";
import useFetch from "../../components/composables/fetch";
import LoadMore from "../../components/Utils/LoadMore.vue";
import InputMarkup from "../../components/Utils/InputMarkup.vue";
import { debounce } from "lodash";

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

const search = () => {
  users.value = [];
  url.value = `/api/company/users?q=${keyword.value}`;
  fetch();
};

watch(
  keyword,
  debounce(() => search(), 500)
);

const nextInternships = () => {
  url.value = next.value;
  fetch();
};
</script>
