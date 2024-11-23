<template>
  <Layout>
    <main>
      <section id="search" class="container mx-auto w-2/3 flex justify-between">
        <InputMarkup v-model="keyword" @search="keyword = $event"></InputMarkup>
      </section>
      <section
        id="internships"
        class="container mx-auto mt-9 w-2/3"
        :class="{ 'divide-y-2': !is_loading }"
      >
        <Internships
          @reported="reported"
          :internships="internshipsData"
          :is_loading="is_loading"
        ></Internships>
        <div
          v-if="is_loading"
          class="relative internship bg-white mt-3 rounded-md p-2 hover:bg-grey cursor-pointer"
        >
          <loading-skeleton v-for="i in 8" :key="i"></loading-skeleton>
        </div>
      </section>
    </main>
  </Layout>
</template>

<script setup>
import { provide, ref } from "vue";
import Internships from "./Internee/Internships.vue";
import InputMarkup from "./Utils/InputMarkup.vue";
import Layout from "./Shared/Layout.vue";
import LoadingSkeleton from "./Utils/LoadingSkeleton.vue";

const internship = ref([]);
provide("internship", internship);

const keyword = ref();

provide("keyword", keyword);
</script>
