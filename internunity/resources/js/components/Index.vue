<template>

<main>
        <section id="search" class="container mx-auto w-2/3 flex justify-between">
            <input type="text" @keyup="getInternships(`/api/internships?q=${keyword}`)" v-model="keyword" class="shade w-full outline-none rounded-md px-3 py-2 mt-3" placeholder="Search">
        </section>
        <section id="internships" class="container mx-auto mt-9 w-2/3" :class="{ 'divide-y-2': !is_loading }">
            <div v-show="!is_loading" v-for="internship in internshipsData" :key="internship.id" class="relative internship bg-white mt-3 rounded-md p-2 hover:bg-grey cursor-pointer">
                <div class="actions absolute right-5 flex gap-2 text-xs">
                    <button class="bg-base-alt px-2 py-1 text-white rounded-md">
                        <i class="fa-solid fa-heart text-black"></i>
                    </button>
                    <button class="notify bg-red-500 text-white px-2 py-1 rounded-md">
                        <i class="fa-solid fa-flag"></i>
                    </button>
                </div>
                <p class="text-xs">Posted {{ moment(internship.created_at).fromNow() }}</p>
                <h1 class="font-bold">{{ internship.title }}</h1>
                <p class="text-sm mt-1">{{ internship.description.substring(0, 299) }} {{ internship.length > 300 ? '...' : ''}}</p>
                <p class="text-xs mt-3">Stipend {{ internship.stipend.toLocaleString() }} PKR</p>
                <div class="tags my-3 space-x-2">
                    <span v-for="tag in internship.tags" :key="tag.id" class="tag bg-base-alt text-black text-xs rounded-full p-2">{{ tag.tag }}</span>
                </div>
            </div>

            <div class="spinner flex justify-center items-center">
                <span v-show="is_loading" class="loader"></span>
            </div>

            <div v-if="!is_loading && next" class="load-button w-full text-center m-3 flex justify-center">
                <button :disabled="is_loading_more" @click="getInternships(next)" class="bg-black disabled:bg-black/50 text-white px-5 py-2 rounded-full flex justify-center items-center gap-2">
                    Load more
                    <span v-if="is_loading_more" class="loader loader-white loader-short"></span>
                </button>
            </div>

        </section>
    </main>
</template>

<script setup>

import { onMounted, ref } from 'vue';
import moment from "moment"

const internshipsData = ref([]);
const is_loading = ref(true);
const is_loading_more = ref(false);
const next = ref();
const keyword = ref();

const getInternships = async (url = '/api/internships') => {
    is_loading_more.value = true;
    const internships = await axios.get(url);
    internshipsData.value.push(...internships.data.data);
    next.value = internships.data.links[internships.data.links.length - 1].url;
    is_loading_more.value = false;
}


onMounted(async () => {
    await getInternships();

    is_loading.value = false;
})


</script>

<style scoped>
.loader {
  width: 48px;
  height: 48px;
  display: inline-block;
  position: relative;
}
.loader::after,
.loader::before {
  content: '';
  box-sizing: border-box;
  width: 48px;
  height: 48px;
  border-radius: 50%;
  border: 2px solid black;
  position: absolute;
  left: 0;
  top: 0;
  animation: animloader 2s linear infinite;
}
.loader::after {
  animation-delay: 1s;
}

.loader-white::after,
.loader-white::before {
    border: 2px solid white;
}

.loader-short {
    width: 20px;
    height: 20px;
}
.loader-short::after,
.loader-short::before {
    width: 20px;
    height: 20px;
}

@keyframes animloader {
  0% {
    transform: scale(0);
    opacity: 1;
  }
  100% {
    transform: scale(1);
    opacity: 0;
  }
}


</style>
