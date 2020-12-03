import Vue from "vue"
import Vuex from "vuex"
import axios from "axios"

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
            let found = false
            state.basket.forEach(element => {
                if (element.id === item.id) {
                    element.quantity += item.quantity
                    element.totalPrice += item.totalPrice
                    found = true
                }
            })
            if (!found) {
                state.basket.push(item)
            }
        },
        initBasket: function (state, items) {
            state.basket = items
        },
        initWines: function (state, wines) {
            state.wines = wines
        },
        removeFromBasket: function (state, itemId) {
            for (let i = 0; i < state.basket.length; ++i) {
                if (state.basket[i].id === itemId) {
                    state.basket.splice(i, 1)
                    return
                }
            }
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