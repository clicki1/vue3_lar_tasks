import {createRouter, createWebHashHistory, createWebHistory} from 'vue-router';

const routes = [
    {
        path: '/',
        component: () => import("./components/Tasks/Index.vue"),
        name: "index",
    },
    {
        path: '/create',
        component: () => import("./components/Tasks/Create.vue"),
        name: "create",
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes, // short for `routes: routes`
})

export default router;

