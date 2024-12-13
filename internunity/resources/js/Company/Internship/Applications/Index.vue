<template>
  <company-layout>
    <div class="container mt-4 rounded mx-auto w-2/3">
      <div class="internship shade p-2">
        <h1 class="text-xl font-bold">Laravel Developer</h1>
        <p class="text-sm">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem quo odio
          impedit pariatur distinctio, eius animi? Nostrum sunt repellat voluptas
          blanditiis labore sed ea perspiciatis, nesciunt itaque accusamus reprehenderit
          iusto tempore illo natus suscipit. Minus quisquam aliquam neque facere
          distinctio deleniti, iusto ipsum labore, voluptates iste dolor reprehenderit
          atque! Nisi officiis veritatis odit reprehenderit saepe soluta incidunt aut,
          quisquam quam, veniam assumenda, dolorum temporibus rerum repellendus qui! Sit,
          quas nemo. Tempore quae eaque porro cumque magnam pariatur minus reprehenderit
          sint quasi accusantium expedita facere excepturi recusandae modi, ab asperiores,
          unde corrupti natus cupiditate ipsam impedit autem quis eligendi. Molestias,
          alias.
        </p>

        <p class="text-xs text-gray-400 italic mt-3">Stipend: 10,000 RS</p>
      </div>
      <div class="applications">
        <div class="application mt-4 p-4 shade flex">
          <div
            class="application-submitter w-1/6 flex flex-col justify-center items-center"
          >
            <img
              src="https://placehold.co/60x60"
              width="60"
              class="rounded-full"
              alt=""
            />
            <p class="text-xs text-gray-400 mt-1">Hashim Abbas</p>
            <button class="text-xs bg-base-alt text-white rounded-md px-2 py-1 mt-2">
              View Profile
            </button>
          </div>
          <div class="w-5/6">
            <p class="text-xs leading-5 cover-letter">
              Lorem ipsum dolor sit, amet consectetur adipisicing elit. Similique deserunt
              enim iste autem sint sit adipisci modi asperiores dolor voluptas consequatur
              maiores, sapiente eveniet accusamus libero pariatur nesciunt quis mollitia
              vitae quaerat quisquam consequuntur. Officiis dolore commodi atque a
              similique voluptates voluptate voluptatum, doloremque provident ad ullam
              eveniet. Eius rem nesciunt corrupti quidem a consequatur repudiandae error,
              iure impedit ipsam odit quas nisi amet praesentium recusandae molestias
              labore eveniet pariatur non. In, excepturi maxime. Alias voluptatibus
              quisquam repudiandae est praesentium molestiae, iste ratione expedita eius
              maxime maiores reprehenderit quo illo mollitia esse nulla possimus, id
              reiciendis doloribus! Aut, enim natus!
            </p>
            <div class="actions flex gap-2">
              <button class="bg-black text-white text-xs rounded-md px-2 py-1 mt-2">
                Message
              </button>
              <button class="bg-black text-white text-xs rounded-md px-2 py-1 mt-2">
                Hire
              </button>
              <button class="bg-black text-white text-xs rounded-md px-2 py-1 mt-2">
                Reject
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </company-layout>
</template>
<script setup>
import CompanyLayout from "../../../components/Shared/CompanyLayout.vue";
</script>
