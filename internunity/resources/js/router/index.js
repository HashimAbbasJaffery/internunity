import { createRouter, createWebHistory } from "vue-router";

import Index from "../components/Index.vue"
import Login from "../components/User/Login.vue";
import isAuthenticated from "../middleware/isAuthenticated";
import Profile from "../components/Profile.vue";
import Applications from "../components/Applications.vue";

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
        name: 'profile',
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem("token");
            if(token) {
                next();
            } else {
                next({ name: 'home' })
            }
        }
    },
    {
        path: '/applications',
        component: Applications,
        name: 'applications',
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem("token");
            if(token) {
                next();
            } else {
                next({ name: 'home' })
            }
        }
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;
