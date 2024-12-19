import './bootstrap';

import { createApp } from 'vue';

import app from "./components/app.vue";
import router from './router/index.js';
import Layout from './components/Shared/Layout.vue';
import { createPinia } from 'pinia';

const pinia = createPinia();

createApp(app)
    .component('Layout', Layout)
    .use(router)
    .use(pinia)
    .mount("#app");
