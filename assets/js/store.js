import Vue from "vue"
import Vuex from "vuex"

Vue.use(Vuex)
const userEmail = document.getElementById('app').getAttribute('userEmail')

export default new Vuex.Store({
    state: {
        loggedIn: userEmail !== "",
        basket: [],
        wines: [],
        storedWines: [],
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
            state.storedWines = wines
        },
        removeFromBasket: function (state, itemId) {
            for (let i = 0; i < state.basket.length; ++i) {
                if (state.basket[i].id === itemId) {
                    state.basket.splice(i, 1)
                    return
                }
            }
        },
        filterWines: function (state, filters) {
            const allWines = state.storedWines
            let filteredWines = allWines.filter(wine => {
                if (filters.name !== '' && filters.name !== null) {
                    if (wine.name.toLowerCase().indexOf(filters.name.trim().toLowerCase()) === -1) {
                        return false
                    }
                }
                return true
            })
            state.wines = filteredWines
        }
    },
    getters: {
        winesThumbnail: function (state) {
            return state.wines.map(wine => {
                return {
                    id: wine.id,
                    name: wine.name,
                    imagePath: wine.imagePath,
                    locationName: wine.locationName,
                    price: wine.price
                }
            })
        },
        wines: function (state) {
            return state.wines
        },
        basketCount: function (state) {
            return state.basket.length
        },
    }
})