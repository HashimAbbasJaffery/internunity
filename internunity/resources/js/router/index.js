import { createRouter, createWebHistory } from "vue-router";

import Index from "../components/Index.vue"
import Login from "../components/User/Login.vue";
import isAuthenticated from "../middleware/isAuthenticated";
import Profile from "../components/Profile.vue";
import Applications from "../components/Applications.vue";
import CompanyLogin from "../Company/Auth/Login.vue"
import CompanyIndex from "../Company/Index.vue";
import { before } from "lodash";
import InternshipCreate from "../Company/Internship/create.vue";
import InternshipUpdate from "../Company/Internship/update.vue";
import ApplicationsList from "../Company/Internship/Applications/Index.vue";

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
                next({ name: 'company-login' })
            }
        }
    },
    {
        path: '/company',
        component: CompanyIndex,
        name: 'company',
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem("company_token");
            if(token) {
                next();
            } else {
                next({ name: 'company-login' })
            }
        }
    },
    {
        path: '/company/login',
        component: CompanyLogin,
        name: 'company-login',
        beforeEnter: [ isAuthenticated ]
    },
    {
        path: '/company/internship/create',
        component: InternshipCreate,
        name: 'company.create',
    },
    {
        path: '/company/internship/:internship/update',
        component: InternshipUpdate,
        name: 'company.update'
    },
    {
        path: '/company/internship/:internship/applications',
        component: ApplicationsList,
        name: 'company.applications'
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;
