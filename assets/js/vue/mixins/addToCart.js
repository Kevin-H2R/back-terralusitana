import axios from "axios"

export default {
    methods: {
        increase: function () {
            ++this.bottleCount
        },
        decrease: function () {
            if (this.bottleCount === 0) {
                return
            }
            --this.bottleCount
        },
        addToBasket: function (id, quantity) {
            console.log(id, quantity)
            this.loading = true
            axios.post('/basket/add', {id: id, quantity: quantity})
                .then(response => {
                    console.log(response)
                    this.$store.commit('addToBasket', response.data)
                    this.loading = false
                    console.log(this.$store.state.basket)
                })
                .catch(error => {console.log(error); this.loading = false})
        }
    },
    data: function () {
        return {
            bottleCount: 6,
            loading: false
        }
    }
}