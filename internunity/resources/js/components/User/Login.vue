<template>
  <Layout>
    <div class="container mx-auto w-2/3 mt-4">
      <div
        class="invalid-credentials bg-red-400 text-white rounded p-2 mb-3"
        v-if="invalidCredentials"
      >
        Invalid Credentials!
      </div>
      <form @submit="login">
        <label for="email" class="mt-4">
          <h1 class="font-bold">Email</h1>
          <p class="mt-3 text-xs text-red-500 mb-1" v-if="errors.email.length">
            {{ errors.email[0] }}
          </p>
          <input
            type="email"
            v-model="form.email"
            class="shade w-full outline-none rounded-md px-3 py-2"
            :class="{ 'border border-red-400': errors.email.length }"
            placeholder="Email"
          />
        </label>
        <label for="password">
          <h1 class="font-bold mt-4">Password</h1>
          <p class="mt-3 text-xs text-red-500 mb-1" v-if="errors.password.length">
            {{ errors.password[0] }}
          </p>
          <input
            type="password"
            v-model="form.password"
            class="shade w-full outline-none rounded-md px-3 py-2"
            :class="{ 'border border-red-400': errors.password.length }"
            placeholder="Password"
          />
        </label>
        <button
          type="submit"
          :disabled="is_checking"
          class="bg-base-alt disabled:bg-base-alt/50 disabled:cursor-not-allowed shade w-full outline-none rounded-md px-3 py-2 mt-3"
        >
          <span v-if="!is_checking">Login</span>
          <Loader v-else class="loader loader-short"></Loader>
        </button>
      </form>
    </div>
  </Layout>
</template>
<script setup>
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
import Layout from "../Shared/Layout.vue";
import Loader from "../Utils/Loader.vue";

const router = useRouter();

const form = reactive({
  email: "",
  password: "",
});
const errors = reactive({
  email: [],
  password: [],
});
const invalidCredentials = ref(false);
const is_checking = ref(false);

const login = async (e) => {
  e.preventDefault();
  is_checking.value = true;
  try {
    errors.email = [];
    errors.password = [];
    const data = await axios.post("/api/login", {
      email: form.email,
      password: form.password,
    });
    if (data.data.status === 200) {
      invalidCredentials.value = false;
      localStorage.setItem("token", data.data.token);
      window.axios.defaults.headers.common[
        "Authentication"
      ] = `Bearer ${localStorage.getItem("token")}`;
      router.push("/");
    } else {
      invalidCredentials.value = true;
    }
  } catch (e) {
    if (e.status !== 422) return;
    errors.email = e.response.data.errors?.email ?? [];
    errors.password = e.response.data.errors?.password ?? [];
  } finally {
    is_checking.value = false;
  }
};
</script>
