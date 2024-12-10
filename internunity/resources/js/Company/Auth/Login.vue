<template>
  <div class="container mx-auto w-2/4 bg-shade h-screen flex items-center">
    <div class="login border rounded border-base w-full p-3">
      <form @submit="login">
        <h1 class="text-center font-bold mb-2">Login</h1>
        <label for="email" class="mt-4">
          <p class="mt-3 text-xs text-red-500 mb-1" v-if="errors.email">
            {{ errors.email[0] }}
          </p>
          <input
            type="email"
            v-model="form.email"
            class="shade w-full outline-none rounded-md px-3 py-2 mt-3"
            :class="{ 'border border-red-400': errors.email }"
            placeholder="Email"
          />
        </label>
        <label for="password" class="mt-4">
          <p class="mt-3 text-xs text-red-500 mb-1" v-if="errors.password">
            {{ errors.password[0] }}
          </p>
          <input
            type="password"
            v-model="form.password"
            class="shade w-full outline-none rounded-md px-3 py-2 mt-3"
            :class="{ 'border border-red-400': errors.password }"
            placeholder="Password"
          />
        </label>
        <button
          type="submit"
          class="bg-base text-white w-full rounded mt-3 cursor-pointer p-1 flex items-center justify-center disabled:bg-base/50 disabled:cursor-not-allowed"
          :disabled="isLoading"
        >
          <span v-if="!isLoading">Login</span>
          <Loader v-else class="loader loader-white loader-short p-3"></Loader>
        </button>
      </form>
    </div>
  </div>
</template>
<script setup>
import { reactive } from "vue";
import Loader from "../../components/Utils/Loader.vue";
import usePost from "../../components/composables/post";

const form = reactive({
  email: "",
  password: "",
});

const url = `/api/company/login`;
const { isLoading, sendRequest, errors, returns } = usePost(url);

const login = (e) => {
  e.preventDefault();
  sendRequest({ email: form.email, password: form.password }, function (res) {
    if (res.data.status === 200) {
      localStorage.setItem("company_token", res.data.token);
    }
  });
};
</script>
