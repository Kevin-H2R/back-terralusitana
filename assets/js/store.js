import Vue from "vue"
import Vuex from "vuex"

Vue.use(Vuex)
const userEmail = document.getElementById('app').getAttribute('userEmail')

export default new Vuex.Store({
    state: {
        loggedIn: userEmail !== "",
        basket: []
    },
    mutations: {
        addToBasket: function (state, item) {
            state.basket.push(item)
        },
        initBasket: function (state, items) {
            state.basket = items
        }
    }
})