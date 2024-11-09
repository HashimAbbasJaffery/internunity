<template>
  <Layout>
    <main>
      <section class="profile container mx-auto w-2/3 flex mt-4 gap-2 items-start">
        <nav class="options bg-base-alt text-white w-1/3 p-2 rounded-md">
          <ul class="space-y-3">
            <li
              @click="tab = 'personal'"
              class="cursor-pointer hover:bg-black/50 px-3 py-1 rounded-md"
              :class="{ 'bg-black': tab === 'personal' }"
            >
              Personal Information
            </li>
            <li
              @click="tab = 'portfolio'"
              class="cursor-pointer hover:bg-black/50 px-3 py-1 rounded-md"
              :class="{ 'bg-black': tab === 'portfolio' }"
            >
              Portfolio
            </li>
            <li
              @click="tab = 'experiences'"
              class="cursor-pointer hover:bg-black/50 px-3 py-1 rounded-md"
              :class="{ 'bg-black': tab === 'experiences' }"
            >
              Experiences
            </li>
            <li
              @click="tab = 'education'"
              class="cursor-pointer hover:bg-black/50 px-3 py-1 rounded-md"
              :class="{ 'bg-black': tab === 'education' }"
            >
              Education
            </li>
          </ul>
        </nav>
        <section
          v-if="tab === 'personal'"
          id="personal-info"
          class="shade w-2/3 rounded-md p-3"
        >
          <form>
            <label for="profile">
              <img
                src="https://placehold.co/90x90"
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
                class="mb-3 shade outline-none p-1 text-sm w-full rounded-md"
              />
            </label>
            <label for="email">
              <p class="text-sm mb-1">Email</p>
              <input
                type="email"
                id="email"
                class="shade mb-3 outline-none p-1 text-sm w-full rounded-md"
              />
            </label>
            <label for="dob">
              <p class="text-sm mb-1">Date of birth</p>
              <input
                type="date"
                id="dob"
                class="shade outline-none p-1 text-sm w-full rounded-md"
              />
            </label>
            <button
              type="submit"
              class="bg-base-alt text-white px-3 py-1 rounded-md mt-3"
            >
              Update
            </button>
          </form>
        </section>
        <section
          v-if="tab === 'portfolio'"
          id="portfolio"
          class="shade w-2/3 p-3 rounded-md"
        >
          <h1 class="font-bold mb-2 text-xl">Projects</h1>
          <div class="projects flex flex-wrap justify-start gap">
            <div class="cursor-pointer project hover:border-base-alt rounded-md p-1 mb-1">
              <img src="https://placehold.co/95x95" class="rounded-md" alt="" />
            </div>
            <div class="cursor-pointer project hover:border-base-alt rounded-md p-1 mb-1">
              <img src="https://placehold.co/95x95" class="rounded-md" alt="" />
            </div>
            <div class="cursor-pointer project hover:border-base-alt rounded-md p-1 mb-1">
              <img src="https://placehold.co/95x95" class="rounded-md" alt="" />
            </div>
            <div class="cursor-pointer project hover:border-base-alt rounded-md p-1 mb-1">
              <img src="https://placehold.co/95x95" class="rounded-md" alt="" />
            </div>
            <div class="cursor-pointer project hover:border-base-alt rounded-md p-1 mb-1">
              <img src="https://placehold.co/95x95" class="rounded-md" alt="" />
            </div>
            <div class="cursor-pointer project hover:border-base-alt rounded-md p-1 mb-1">
              <img src="https://placehold.co/95x95" class="rounded-md" alt="" />
            </div>
            <div class="cursor-pointer project hover:border-base-alt rounded-md p-1 mb-1">
              <img src="https://placehold.co/95x95" class="rounded-md" alt="" />
            </div>
            <div class="cursor-pointer project hover:border-base-alt rounded-md p-1 mb-1">
              <img src="https://placehold.co/95x95" class="rounded-md" alt="" />
            </div>
            <div class="cursor-pointer project hover:border-base-alt rounded-md p-1 mb-1">
              <img src="https://placehold.co/95x95" class="rounded-md" alt="" />
            </div>
            <div class="cursor-pointer project hover:border-base-alt rounded-md p-1 mb-1">
              <img src="https://placehold.co/95x95" class="rounded-md" alt="" />
            </div>
            <div class="cursor-pointer project hover:border-base-alt rounded-md p-1 mb-1">
              <img src="https://placehold.co/95x95" class="rounded-md" alt="" />
            </div>
            <div class="cursor-pointer project hover:border-base-alt rounded-md p-1 mb-1">
              <img src="https://placehold.co/95x95" class="rounded-md" alt="" />
            </div>
            <div class="cursor-pointer project hover:border-base-alt rounded-md p-1 mb-1">
              <img src="https://placehold.co/95x95" class="rounded-md" alt="" />
            </div>
            <div class="cursor-pointer project hover:border-base-alt rounded-md p-1 mb-1">
              <img src="https://placehold.co/95x95" class="rounded-md" alt="" />
            </div>
            <div
              class="cursor-pointer project hover:border-base-alt rounded-md p-1 mb-1 border-dotted border-2 border-base-alt"
            >
              <div
                class="add flex justify-center items-center h-full"
                style="width: 90px"
              >
                <i class="fa-solid fa-plus"></i>
              </div>
            </div>
          </div>
          <div class="load-more w-full flex justify-center items-center">
            <button class="bg-base-alt text-white px-3 py-1 rounded-md mt-3">
              Load More
            </button>
          </div>
        </section>
        <section
          v-if="tab === 'experiences'"
          id="Experiences"
          class="shade w-2/3 p-3 rounded-md space-y-3 divide-y-2"
        >
          <div class="experience">
            <h1 class="font-bold">Mimsoft Private Limited</h1>
            <p class="text-xs opacity-50 italic">May 2019 - Present</p>
            <p class="text-sm">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nemo placeat
              cumque aspernatur voluptatem est autem quis vero adipisci, at earum aperiam
              dignissimos architecto pariatur rem hic. Asperiores temporibus optio
              voluptas, sunt debitis assumenda itaque doloremque, mollitia corporis
              placeat ipsa. Sunt!
            </p>
          </div>
          <div class="experience pt-3">
            <h1 class="font-bold">Mimsoft Private Limited</h1>
            <p class="text-xs opacity-50 italic">May 2019 - Present</p>
            <p class="text-sm">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nemo placeat
              cumque aspernatur voluptatem est autem quis vero adipisci, at earum aperiam
              dignissimos architecto pariatur rem hic. Asperiores temporibus optio
              voluptas, sunt debitis assumenda itaque doloremque, mollitia corporis
              placeat ipsa. Sunt!
            </p>
          </div>
          <div class="experience pt-3">
            <h1 class="font-bold">Mimsoft Private Limited</h1>
            <p class="text-xs opacity-50 italic">May 2019 - Present</p>
            <p class="text-sm">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nemo placeat
              cumque aspernatur voluptatem est autem quis vero adipisci, at earum aperiam
              dignissimos architecto pariatur rem hic. Asperiores temporibus optio
              voluptas, sunt debitis assumenda itaque doloremque, mollitia corporis
              placeat ipsa. Sunt!
            </p>
          </div>

          <div class="load-more w-full flex justify-center items-center">
            <button class="bg-base-alt text-white px-3 py-1 rounded-md mt-3">
              Load More
            </button>
          </div>
        </section>
        <section
          id="education"
          v-if="tab === 'education'"
          class="shade w-2/3 p-3 rounded-md space-y-3 divide-y-2"
        >
          <div class="education">
            <h1 class="font-bold">Sindh Medressatul Islam University</h1>
            <p class="text-xs opacity-50 italic">September 2021 - July 2025 (Expected)</p>
            <p class="text-sm">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nemo placeat
              cumque aspernatur voluptatem est autem quis vero adipisci, at earum aperiam
              dignissimos architecto pariatur rem hic. Asperiores temporibus optio
              voluptas, sunt debitis assumenda itaque doloremque, mollitia corporis
              placeat ipsa. Sunt!
            </p>
          </div>
          <div class="education pt-3">
            <h1 class="font-bold">Fatimiyah Boys College</h1>
            <p class="text-xs opacity-50 italic">May 2019 - September 2021</p>
            <p class="text-sm">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nemo placeat
              cumque aspernatur voluptatem est autem quis vero adipisci, at earum aperiam
              dignissimos architecto pariatur rem hic. Asperiores temporibus optio
              voluptas, sunt debitis assumenda itaque doloremque, mollitia corporis
              placeat ipsa. Sunt!
            </p>
          </div>
          <div class="education pt-3">
            <h1 class="font-bold">Golden Career Primary and Secondary School</h1>
            <p class="text-xs opacity-50 italic">May 2008 - May 2019</p>
            <p class="text-sm">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nemo placeat
              cumque aspernatur voluptatem est autem quis vero adipisci, at earum aperiam
              dignissimos architecto pariatur rem hic. Asperiores temporibus optio
              voluptas, sunt debitis assumenda itaque doloremque, mollitia corporis
              placeat ipsa. Sunt!
            </p>
          </div>

          <div class="load-more w-full flex justify-center items-center">
            <button class="bg-base-alt text-white px-3 py-1 rounded-md mt-3">
              Load More
            </button>
          </div>
        </section>
      </section>
    </main>
  </Layout>
</template>
<script setup>
import Layout from "./Shared/Layout.vue";
import { ref } from "vue";

const tab = ref("personal");
</script>
