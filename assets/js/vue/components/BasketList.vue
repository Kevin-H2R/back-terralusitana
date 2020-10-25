<template>
<v-list class="basket-list">
    <v-list-item v-for="(item, index) in getBasket" :key="'basket_item_' + index">
        <v-list-item-avatar tile>
            <v-img :src="getImage(item.imagePath)" contain></v-img>
        </v-list-item-avatar>
        <v-list-item-content>
            <v-list-item-title>{{ item.name }}</v-list-item-title>
            <v-list-item-subtitle>{{ item.price.toFixed(2) }}€ (x{{ item.quantity}})</v-list-item-subtitle>
        </v-list-item-content>
        <v-list-item-action>
            <div>{{ item.totalPrice.toFixed(2) }}€</div>
        </v-list-item-action>
    </v-list-item>
    <v-divider></v-divider>
    <v-list-item>
        <v-list-item-content>
            <v-list-item-title class="basket-list__total-price text-center">
                {{ this.totalPrice }}€
            </v-list-item-title>
        </v-list-item-content>
    </v-list-item>
    <v-list-item class="text-center" v-if="this.$router.currentRoute.path !== '/basket/'">
        <v-list-item-content>
            <v-btn color="primary" @click="pay">Consulter le panier</v-btn>
        </v-list-item-content>
    </v-list-item>
</v-list>
</template>

<script>
    import axios from "axios"
    export default {
        name: "basket-list",
        computed: {
            getBasket: function () {
                return this.$store.state.basket
            },
            totalPrice: function () {
                const price = this.getBasket.reduce((acc, cur) => {
                  return acc + cur.totalPrice
                }, 0)
                return price.toFixed(2)
            }
        },
        methods: {
            pay: function () {
                let stripe = Stripe("pk_test_JfSAnqpuNRbsfRH1RqFYuVPR00eUl2HtLX")
                axios.post('/payment/').then(response => {
                    stripe.redirectToCheckout({sessionId: response.data.id})
                    console.log(response.data)
                }).catch(error => {
                    console.log(error)
                })
            },
            getImage: function (imagePath) {
                return require('../../../images/wines/' + imagePath + '.png')
            }
        },
        data: function () {
            return {}
        }
    }
</script>

<style lang="scss">
    .basket-list {
        &__total-price {
            font-size: 2em;
         }
    }
</style>