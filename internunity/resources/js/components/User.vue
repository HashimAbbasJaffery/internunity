<template>
  <div class="container mx-auto mb-3 mt-3 space-y-4">
    <div class="user-header flex gap-2 pb-3">
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
      <div class="skills flex gap-2 mt-3" v-if="user.skills.length">
        <span
          v-for="skill in user.skills"
          :key="skill.id"
          class="text-xs text-white skill bg-base-alt px-2 py-1 rounded-full"
          >{{ skill.tag }}</span
        >
      </div>
      <p class="text-sm mt-3 text-gray-600">
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet qui maxime est.
        Cumque, laudantium dolores tenetur deleniti voluptates iusto, minima quo quam,
        esse suscipit mollitia exercitationem. Inventore beatae totam saepe perferendis
        rerum veniam illum illo rem nostrum ipsum sunt tenetur culpa omnis pariatur
        architecto, fuga animi cum magni commodi repudiandae.
      </p>
    </div>
    <div class="user-footer flex justify-between">
      <button
        class="bg-base-alt text-white px-3 py-1 rounded-md mt-3 hover:bg-base-alt/75"
      >
        See Profile
      </button>
      <button class="px-3 py-1 rounded-md mt-3 text-black">
        <i class="fa-regular fa-heart" v-if="!is_hearted" @click="heartTo(user.id)"></i>
        <i
          class="fa-solid fa-heart text-red-500"
          v-if="is_hearted"
          @click="heartTo(user.id)"
        ></i>
      </button>
    </div>
  </div>
</template>
<script setup>
import { inject, onMounted, ref, watch } from "vue";
import Loader from "./Utils/Loader.vue";

const props = defineProps({
  user: Object,
  is_hearted: Number,
});
const company = inject("company");
const is_hearted = ref(props.user.hearted_by_company.length > 0);

watch(company, function () {
  is_hearted.value =
    props.user.hearted_by_company?.filter(
      (comp) => parseInt(comp.id) === parseInt(company.value.id)
    ).length > 0 ?? false;
});

const heartTo = async (user_id) => {
  is_hearted.value = !is_hearted.value;
  await axios.post(`/api/company/heart/${user_id}`);
};
</script>
