<template>
  <section
    id="personal-info"
    class="shade w-2/3 rounded-md p-3"
    :class="{ 'flex justify-center items-center': isFetching }"
  >
    <form v-if="!isFetching" @submit="update">
      <label for="profile">
        <img
          :src="user.profile_pic ? user.profile_pic : 'https://placehold.co/90x90'"
          class="mb-3 rounded-full mx-auto cursor-pointer"
          alt=""
        />
        <input type="file" id="profile" class="hidden" />
      </label>
      <label for="name">
        <p class="text-sm mb-1">Name</p>
        <input
          type="text"
          id="name"
          v-model="user.name"
          class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
        />
      </label>
      <label for="email">
        <p class="text-sm mb-1">Email</p>
        <input
          type="email"
          id="email"
          v-model="user.email"
          class="shade mb-3 outline-none p-1 text-sm w-full rounded-md"
        />
      </label>
      <label for="dob">
        <p class="text-sm mb-1">Date of birth</p>
        <input
          type="date"
          id="dob"
          v-model="user.dob"
          class="shade outline-none p-1 text-sm w-full rounded-md"
        />
      </label>
      <button type="submit" class="bg-base-alt text-white px-3 py-1 rounded-md mt-3">
        Update
      </button>
    </form>
    <Loader v-else :is_loading="isFetching" class="loader"></Loader>
  </section>
</template>
<script setup>
import { onMounted, reactive, ref } from "vue";
import Loader from "../Utils/Loader.vue";

const isFetching = ref(false);
const user = reactive({
  name: "",
  email: "",
  dob: "",
  picture: "",
});

onMounted(async () => {
  isFetching.value = true;
  const userData = await axios.get("/api/user");
  console.log(userData);
  user.name = userData.data.name;
  user.email = userData.data.email;
  user.dob = userData.data.date_of_birth;
  user.picture = userData.data.profile_pic;
  isFetching.value = false;
});

const update = async (e) => {
  e.preventDefault();

  const status = await axios.post("/api/user/update", {
    name: user.name,
    email: user.email,
    dob: user.dob,
    _method: "PATCH",
  });
  console.log(status);
};
</script>
