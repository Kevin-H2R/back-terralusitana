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
        winesThumbnail: function (state) {
            return state.wines.map(wine => {
                return {
                    id: wine.id,
                    name: wine.name,
                    imagePath: wine.imagePath,
                    locationName: wine.region.name,
                    price: wine.price
                }
            })
        },
        wines: function (state) {
            return state.wines.map(wine => {
                wine.map = wine.region.imagePath
                wine.locationName = wine.region.name
                wine.varieties = wine.varieties.map(variety => variety.name)
                return wine
            })
        },
        basketCount: function (state) {
            return state.basket.length
        }
    }
})