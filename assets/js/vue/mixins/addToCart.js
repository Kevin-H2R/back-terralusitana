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
            this.loading = true
            axios.post('/basket/add', {id: id, quantity: quantity})
                .then(response => {
                    this.$store.commit('addToBasket', response.data)
                    this.loading = false
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