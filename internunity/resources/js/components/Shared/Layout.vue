<template>
  <header class="bg-base text-white py-4">
    <div class="container mx-auto w-2/3 flex justify-between items-center">
      <div class="logo">
        <h1 class="text-3xl font-bold">Internunity</h1>
      </div>
      <nav>
        <ul class="flex items-center space-x-2">
          <li
            class="px-3 rounded py-1"
            :class="{ 'bg-shade text-black': $route.name === 'home' }"
          >
            <RouterLink to="/">Apply</RouterLink>
          </li>
          <li
            class="hover:bg-shade hover:text-black px-3 py-1 rounded"
            :class="{ 'bg-shade text-black': $route.name === 'applications' }"
          >
            <RouterLink to="/applications">Internships</RouterLink>
          </li>
          <li
            class="hover:bg-shade hover:text-black px-3 py-1 rounded"
            :class="{ 'bg-shade text-black': $route.name === 'profile' }"
          >
            <RouterLink to="/profile">Profile</RouterLink>
          </li>
          <li
            v-if="isLoggedin"
            class="hover:bg-shade hover:text-black px-3 py-1 rounded"
            @click="logout"
          >
            Logout
          </li>
          <li v-else class="hover:bg-shade hover:text-black px-3 py-1 rounded">
            <RouterLink to="/login">Login</RouterLink>
          </li>
        </ul>
      </nav>
    </div>
  </header>
  <slot></slot>
</template>

<script setup>
import { RouterLink } from "vue-router";
import { useRouter } from "vue-router";
import { ref } from "vue";

const router = useRouter();
const isLoggedin = ref(localStorage.getItem("token")?.length ?? false);

const logout = async () => {
  const status = await axios.delete("/api/logout");
  if (status.data) {
    localStorage.removeItem("token");
    router.push("/");
    isLoggedin.value = false;
  }
};
</script>
