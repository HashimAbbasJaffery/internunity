import { createRouter, createWebHistory } from "vue-router";

import Index from "../components/Index.vue"
import Login from "../components/User/Login.vue";
import isAuthenticated from "../middleware/isAuthenticated";
import Profile from "../components/Profile.vue";

const routes = [
    {
        path: '/',
        component: Index,
        name: 'home'
    },
    {
        path: '/Login',
        component: Login,
        name: 'login',
        beforeEnter: [isAuthenticated]
    },
    {
        path: '/profile',
        component: Profile,
        name: 'profile'
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;
