<template>
<v-list class="basket-list">
    <v-list-item v-for="(item, index) in getBasket" :key="'basket_item_' + index">
        <v-list-item-avatar tile>
            <v-img :src="'https://terralusitana-bucket.s3.eu-west-3.amazonaws.com/images/wines/' + item.imagePath + '.png'" contain></v-img>
        </v-list-item-avatar>
        <v-list-item-content>
            <v-list-item-title>{{ item.name }}</v-list-item-title>
            <v-list-item-subtitle>{{ item.price.toFixed(2) }}€ (x{{ item.quantity}})</v-list-item-subtitle>
        </v-list-item-content>
        <div>{{ item.totalPrice.toFixed(2) }}€</div>
        <v-list-item-action>
            <v-btn icon color="error" @click="removeItem(item.id)"><v-icon>mdi-trash-can</v-icon></v-btn>
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
            <v-btn color="primary" @click="pay" v-if="this.$store.state.loggedIn">Consulter & payer</v-btn>
            <v-btn color="primary" @click="login" v-else>Consulter & payer</v-btn>
        </v-list-item-content>
    </v-list-item>
</v-list>
</template>

<script>
    import axios from "axios"
    import {EventBus} from "../plugins/eventbus";

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
            removeItem: function (itemId) {
                axios.post('/api/basket/remove', itemId).then(response => {
                    console.log(response.data)
                }).catch(error => {
                    console.log(error)
                })
                this.$store.commit('removeFromBasket', itemId)
            },
            pay: function () {
                let stripe = Stripe("pk_test_51HgIMEInzdbznQgdYdSNGRU8n5LJNj4UGzW2Tgh5ppT6dzYKnpZYEYoDnpWnbSM9CU8qR9t3o72uIsZ5cbFPf1Eq00DrbP660l")
                axios.post('/api/payment/').then(response => {
                    stripe.redirectToCheckout({sessionId: response.data.id})
                }).catch(error => {
                    console.log(error)
                })
            },
            login: function () {
                EventBus.$emit('login-required_by-basket')
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