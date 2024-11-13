<template>
  <section
    id="personal-info"
    class="shade w-2/3 rounded-md p-3"
    :class="{ 'flex justify-center items-center': isFetching }"
  >
    <form
      v-if="!isFetching"
      @submit="update"
      class="relative"
      enctype="multipart/form-data"
    >
      <label for="profile" class="relative">
        <img
          :src="
            user.picture
              ? '/storage/profile/' + user.picture
              : 'https://placehold.co/90x90'
          "
          id="imageUploader"
          class="mb-3 rounded-full mx-auto cursor-pointer"
          width="90"
          height="90"
          style="width: 90px; height: 90px"
          alt=""
        />

        <div
          v-if="isFileUploading"
          class="absolute inset-0 bg-white bg-opacity-50 rounded-full flex justify-center items-center"
        >
          <Loader :is_loading="isFileUploading" className="loader loader-short"></Loader>
        </div>

        <input type="file" @change="showImage" id="profile" v-show="false" />
      </label>
      <label for="name">
        <p class="text-sm mb-1">Name</p>
        <p class="text-xs text-red-500 mb-1" v-if="errors.name">{{ errors.name[0] }}</p>
        <input
          type="text"
          id="name"
          v-model="user.name"
          class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
          :class="{ 'border border-red-500': errors.name?.length ?? false }"
        />
      </label>
      <label for="email">
        <p class="text-sm mb-1">Email</p>
        <p class="text-xs text-red-500 mb-1" v-if="errors.email">{{ errors.email[0] }}</p>
        <input
          type="email"
          id="email"
          v-model="user.email"
          class="shade mb-3 outline-none p-1 text-sm w-full rounded-md"
          :class="{ 'border border-red-500': errors.email?.length ?? false }"
        />
      </label>
      <label for="dob">
        <p class="text-sm mb-1">Date of birth</p>

        <p class="text-xs text-red-500 mb-1" v-if="errors.dob">{{ errors.dob[0] }}</p>
        <input
          type="date"
          id="dob"
          :class="{ 'border border-red-500': errors.dob?.length ?? false }"
          v-model="user.dob"
          class="shade outline-none p-1 text-sm w-full rounded-md"
        />
      </label>
      <button
        type="submit"
        :disabled="isLoading"
        class="disabled:bg-base-alt/50 disabled:cursor-not-allowed bg-base-alt text-white px-3 py-1 rounded-md mt-3"
        :class="{ 'flex justify-center items-center gap-2': isLoading }"
      >
        Update
        <Loader
          :is_loading="isLoading"
          className="loader loader-white loader-short"
        ></Loader>
      </button>
    </form>
    <Loader v-else :is_loading="isFetching" class="loader"></Loader>
  </section>
</template>
<script setup>
import { onMounted, reactive, ref, watch } from "vue";
import Loader from "../Utils/Loader.vue";
import usePost from "../composables/post";

// Main Data source, which is providing data to be inserted in composables

const getData = () => {
  const data = new FormData();
  data.append("name", user.name);
  data.append("email", user.email);
  data.append("dob", user.dob);
  data.append("_method", "PATCH");

  return data;
};

const isFetching = ref(false);
const user = reactive({
  name: "",
  email: "",
  dob: "",
  picture: "",
});
const isFileUploading = ref(false);
const url = ref(`/api/user/update`);
const { isLoading, addData, errors } = usePost(url);

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

const showImage = () => {
  const reader = new FileReader();
  reader.onload = async (e) => {
    const data = getData();
    data.append("profile_pic", profile.files[0]);
    addData(data, isFileUploading);
    data.delete("profile_pic");
    imageUploader.src = e.target.result;
  };
  reader.readAsDataURL(profile.files[0]);
};

const update = async (e) => {
  e.preventDefault();
  addData(getData());
};
</script>
