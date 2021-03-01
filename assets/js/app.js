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
import SuccessView from "./vue/views/SuccessView";
import CharteView from "./vue/views/CharteView";
import MentionsView from "./vue/views/MentionsView";

Vue.use(VueRouter)
const appElement = document.getElementById('app')
const userEmail = appElement.getAttribute('userEmail')

const routes = [
    {path: "/", component: HomeView, props: {userEmail: userEmail}},
    {path: "/basket", component: BasketView, props: {userEmail: userEmail}},
    {path: "/success", component: SuccessView},
    {path: "/charte-vie-privee", component: CharteView},
    {path: "/mentions-et-cgv", component: MentionsView}
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
