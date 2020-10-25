/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';
import Vue from 'vue'
import vuetify from "./vue/plugins/vuetify";
import App from "./vue/App";
import VueRouter from "vue-router";
import store from "./store";

import HomeView from "./vue/views/HomeView";
import BasketView from "./vue/views/BasketView";

Vue.use(VueRouter)
const userEmail = document.getElementById('app').getAttribute('userEmail')
const routes = [
    {path: "/", component: HomeView, props: {userEmail: userEmail}},
    {path: "/basket", component: BasketView, props: {userEmail: userEmail}},
    {path: "/success"}
]

const router = new VueRouter({
    routes,
    mode: "history"
})

new Vue({
    vuetify,
    router,
    store,
    render: h => h(App)
}).$mount("#app")
