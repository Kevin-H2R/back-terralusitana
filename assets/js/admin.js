import Vue from 'vue'
import vuetify from "./vue/plugins/vuetify";
import AdminApp from "./vue/AdminApp";

new Vue({
    vuetify,
    render: h => h(AdminApp)
}).$mount("#admin-app")
