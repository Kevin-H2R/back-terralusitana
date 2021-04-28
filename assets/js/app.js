import '../css/app.css';
import Vue from 'vue'
import vuetify from "./vue/plugins/vuetify";
import App from "./vue/App";
import VueRouter from "vue-router";
import store from "./store";

import HomeView from "./vue/views/HomeView";
import SuccessView from "./vue/views/SuccessView";
import CharteView from "./vue/views/CharteView";
import MentionsView from "./vue/views/MentionsView";
import MyAccountView from "./vue/views/MyAccountView";
import NotFoundView from "./vue/views/NotFoundView";
import BasketView from "./vue/views/BasketView";

Vue.use(VueRouter)
const appElement = document.getElementById('app')
const userEmail = appElement.getAttribute('userEmail')

const routes = [
    {path: "/", component: HomeView, props: {userEmail: userEmail}},
    {path: "/success", component: SuccessView},
    {path: "/charte-vie-privee", component: CharteView},
    {path: "/mentions-et-cgv", component: MentionsView},
    {path: "*", component: NotFoundView},
]
if (userEmail !== '') {
    routes.push(
        {path: "/mon-compte", component: MyAccountView,  props: {userEmail: userEmail}},
        {path: "/panier", component: BasketView},
    )
}
const router = new VueRouter({
    routes,
    mode: "history"
})

new Vue({
    vuetify,
    router,
    store,
    render: h => h(App, {props: {userEmail: userEmail}})
}).$mount("#app")
