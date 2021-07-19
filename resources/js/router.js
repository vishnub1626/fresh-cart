import { createRouter, createWebHistory } from "vue-router";
import Register from "./components/Register";
import Login from "./components/Login";
import Home from "./components/Home";
import Cart from "./components/Cart";
import Checkout from "./components/Checkout";
import OrderList from "./components/OrderList";
import Order from "./components/Order";

import store from "./store";

const ifAuthenticated = (to, from, next) => {
    if (store.getters['user/isAuthenticated']) {
        next();
    } else {
        next("/login");
    }
};

const ifNotAuthenticated = (to, from, next) => {
    if (!store.getters['user/isAuthenticated']) {
        next();
    } else {
        next("/");
    }
};

const routes = [
    {
        path: "/",
        name: "home",
        component: Home,
        beforeEnter: ifAuthenticated,
    },
    {
        path: "/cart",
        name: "cart",
        component: Cart,
        beforeEnter: ifAuthenticated,
    },
    {
        path: "/checkout",
        name: "checkout",
        component: Checkout,
        beforeEnter: ifAuthenticated,
    },
    {
        path: "/orders",
        name: "orders",
        component: OrderList,
        beforeEnter: ifAuthenticated,
    },
    {
        path: "/orders/:id",
        name: "order",
        component: Order,
        beforeEnter: ifAuthenticated,
    },
    {
        path: "/register",
        name: "register",
        component: Register,
        beforeEnter: ifNotAuthenticated,
    },
    {
        path: "/login",
        name: "login",
        component: Login,
        beforeEnter: ifNotAuthenticated,
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
