<template>
  <company-layout>
    <div class="container mx-auto w-2/3 mt-2">
      <form @submit="create">
        <label for="title">
          <p class="text-sm mb-1 font-bold">Title</p>
          <p class="text-xs text-red-500 mb-1" v-if="errors.title">
            {{ errors.title[0] }}
          </p>
          <input
            type="text"
            id="title"
            v-model="form.title"
            placeholder="Laravel Developer"
            class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
            :class="{ 'border border-red-500': errors.title }"
          />
        </label>
        <label for="stipend">
          <p class="text-sm mb-1 font-bold">Stipend (in PKR)</p>
          <p class="text-xs text-red-500 mb-1" v-if="errors.stipend">
            {{ errors.stipend[0] }}
          </p>
          <input
            type="number"
            id="stipend"
            v-model="form.stipend"
            class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
            placeholder="10000"
            :class="{ 'border border-red-500': errors.stipend }"
          />
        </label>
        <label for="description">
          <p class="text-sm mb-1 font-bold">Description</p>
          <p class="text-xs text-red-500 mb-1" v-if="errors.description">
            {{ errors.description[0] }}
          </p>
          <textarea
            type="text"
            id="description"
            rows="5"
            v-model="form.description"
            style="resize: none"
            placeholder="We are looking for a Laravel Developer"
            class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
            :class="{ 'border border-red-500': errors.description }"
          ></textarea>
        </label>

        <div class="added-skills flex gap-2 flex-wrap" v-if="added_skills.length">
          <span
            v-for="skill in added_skills"
            :key="skill.id"
            class="added-skill bg-base-alt text-xs text-white px-2 py-1 mb-3 rounded-full"
            >{{ skill.name }}
            <i class="ml-1 fa-solid fa-x cursor-pointer" @click="removeSkill(skill)"></i
          ></span>
        </div>
        <label for="tags">
          <p class="text-sm mb-1 mt-3 font-bold">tags</p>
          <p class="text-xs text-red-500 mb-1" v-if="errors.tags">
            {{ errors.tags[0] }}
          </p>
          <input
            type="text"
            id="tags"
            v-model="form.q"
            class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
            placeholder="PHP"
            :class="{ 'border border-red-500': errors.tags }"
          />
          <div class="drawer bg-white absolute shade w-1/4 rounded">
            <div
              v-if="is_fetching_skills"
              class="loader-container flex justify-center p-2"
            >
              <loader class="loader loader-short"></loader>
            </div>
            <ul v-else>
              <li
                @click="add_skill(skill)"
                class="hover:bg-slate-200 p-1 text-sm cursor-pointer"
                v-for="skill in skillsList"
                :key="skill.id"
              >
                {{ skill.name }}
              </li>
            </ul>
          </div>
        </label>
        <button
          type="submit"
          :disabled="isLoading"
          class="bg-base-alt text-white px-2 py-1 rounded flex items-center gap-1 justify-center disabled:bg-base-alt/50"
        >
          Create
          <Loader v-if="isLoading" class="loader loader-short loader-white"></Loader>
        </button>
      </form>
    </div>
  </company-layout>
</template>
<script setup>
import { reactive, onMounted, watch, watchEffect, ref } from "vue";
import usePost from "../../components/composables/post";
import CompanyLayout from "../../components/Shared/CompanyLayout.vue";
import Loader from "../../components/Utils/Loader.vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { debounce } from "lodash";

const router = useRouter();

const url = "/api/company/internship/create";
const { isLoading, sendRequest, errors, returns } = usePost(url);
const skillsList = ref([]);
const is_fetching_skills = ref(false);
const added_skills = ref([]);

const form = reactive({
  title: "",
  stipend: "",
  description: "",
  tags: "",
  q: "",
});

const getAccessToken = async () => {
  const config = {
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
  };
  const data = {
    client_id: "bumcth193y8a4lo1",
    client_secret: "PwNYUgRV",
    scope: "emsi_open",
    grant_type: "client_credentials",
  };
  const status = await axios.post(
    "https://auth.emsicloud.com/connect/token",
    data,
    config
  );
  localStorage.access_token = status.data.access_token;
};

const IsApiHealthy = async () => {
  const config = { headers: { Authorization: `Bearer ${localStorage.access_token}` } };
  const status = await axios.get("https://emsiservices.com/skills/status", config);
  return status.data.data.healthy;
};

onMounted(async () => {
  try {
    const IsHealthy = await IsApiHealthy();
  } catch (e) {
    getAccessToken();
  }
  //   if (!localStorage.access_token || IsHealthy.status === 401) getAccessToken();
});

const add_skill = (skill) => {
  const does_exist = added_skills.value.filter(
    (added_skill) => added_skill.id === skill.id
  ).length;
  if (does_exist) return;
  added_skills.value.push(skill);
  form.q = "";
  skillsList.value = [];
};

const removeSkill = (skill) => {
  added_skills.value = added_skills.value.filter(
    (added_skill) => added_skill.id !== skill.id
  );
};

const getSkill = async (q) => {
  if (!q) {
    skillsList.value = [];
    return;
  }
  is_fetching_skills.value = true;
  const config = {
    headers: {
      Authorization: `Bearer ${localStorage.access_token}`,
    },
  };
  const skills = await axios.get(
    `https://emsiservices.com/skills/versions/latest/skills?q=${q}&limit=5`,
    config
  );
  console.log(skills.data.data);
  skillsList.value = skills.data.data;
  is_fetching_skills.value = false;
};

watch(
  () => form.q,
  debounce(() => getSkill(form.q), 500)
);

const create = (e) => {
  e.preventDefault();
  form.tags = added_skills;
  sendRequest({ ...form }, function (res) {
    if (res.data) {
      router.push("/company");
    }
  });
};
</script>
