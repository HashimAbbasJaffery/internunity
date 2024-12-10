<template>
  <show-more
    class="right-0"
    :is_applied="is_applied"
    :internship="internship"
    v-if="showMore"
    @apply="apply"
    @close="showMore = false"
  ></show-more>

  <div>
    <div class="internship-container" @click="showMore = true">
      <p class="text-xs">Posted {{ moment(internship.created_at).fromNow() }}</p>
      <h1 class="font-bold">{{ internship.title }}</h1>
      <p class="text-sm mt-1">
        {{ internship.description.substring(0, 299) }}
        {{ internship.length > 300 ? "..." : "" }}
      </p>
      <p class="text-xs mt-3">Stipend {{ internship.stipend }} PKR</p>
      <div class="tags my-3 space-x-2">
        <span
          v-for="tag in internship.tags"
          :key="tag.id"
          class="tag bg-base-alt text-black text-xs rounded-full p-2"
          >{{ tag.tag }}</span
        >
      </div>
    </div>
  </div>
</template>
<script setup>
import moment from "moment";
import { ref } from "vue";
import ShowMore from "../components/Modals/ShowMore.vue";

const props = defineProps({
  internship: Object,
  is_loading: Boolean,
  is_applied: Boolean,
});
const showMore = ref(false);
const is_applied = ref(props.is_applied);
const is_creating_application = ref(false);
const emits = defineEmits(["reported"]);

const apply = () => {
  is_creating_application.value = true;
  showMore.value = false;
};
</script>
