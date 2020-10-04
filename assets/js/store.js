import Vue from "vue"
import Vuex from "vuex"

Vue.use(Vuex)
const userEmail = document.getElementById('app').getAttribute('userEmail')

export default new Vuex.Store({
    state: {
        loggedIn: userEmail !== "",
        basket: [],
        wines: []
    },
    mutations: {
        addToBasket: function (state, item) {
            state.basket.push(item)
        },
        initBasket: function (state, items) {
            state.basket = items
        },
        initWines: function (state, wines) {
            state.wines = wines
        }
    },
    getters: {
        wines: function (state) {
            return state.wines.map(wine => {
                return {
                    name: wine.name,
                    imagePath: wine.imagePath,
                    locationName: wine.region.name,
                    price: wine.price
                }
            })
        }
    }
})