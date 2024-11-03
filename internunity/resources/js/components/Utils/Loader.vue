<template>
  <div class="spinner flex justify-center items-center">
    <span v-show="is_loading" :class="className"></span>
  </div>
</template>
<script setup>
const props = defineProps({
  is_loading: Boolean,
  className: String,
});
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
  content: "";
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
