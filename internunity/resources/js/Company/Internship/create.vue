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
import { reactive } from "vue";
import usePost from "../../components/composables/post";
import CompanyLayout from "../../components/Shared/CompanyLayout.vue";
import Loader from "../../components/Utils/Loader.vue";
import { useRouter } from "vue-router";

const router = useRouter();

const url = "/api/company/internship/create";
const { isLoading, sendRequest, errors, returns } = usePost(url);

const form = reactive({
  title: "",
  stipend: "",
  description: "",
  tags: "[1]",
});

const create = (e) => {
  e.preventDefault();
  sendRequest({ ...form }, function (res) {
    if (res.data) {
      router.push("/company");
    }
  });
};
</script>
