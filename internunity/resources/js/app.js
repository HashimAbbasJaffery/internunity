import './bootstrap';

import { createApp } from 'vue';

import app from "./components/app.vue";
import router from './router/index.js';
import Layout from './components/Shared/Layout.vue';

createApp(app)
    .component('Layout', Layout)
    .use(router)
    .mount("#app");
