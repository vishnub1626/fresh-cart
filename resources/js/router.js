import {createRouter, createWebHashHistory} from "vue-router";

import HomePage from "./components/pages/HomePage.vue";

const routes = [{ path: "/", name: "home", component: HomePage }];

export default createRouter({
    history: createWebHashHistory(),
    routes,
});
