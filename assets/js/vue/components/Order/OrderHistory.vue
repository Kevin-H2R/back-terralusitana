<template>
    <v-card>
        <v-card-title>Mes Commandes</v-card-title>
        <v-card-text v-if="loading">
            <v-container>
                <v-row justify="center" align="center">
                    <v-progress-circular
                            color="primary"
                            indeterminate/>
                </v-row>
            </v-container>
        </v-card-text>
        <v-card-text v-else>
            <v-expansion-panels flat multiple hover>
                <v-expansion-panel
                        v-for="(order, index) in orders" :key="'order_' + index">
                    <v-expansion-panel-header>
                        <v-row class="px-3">
                            <v-col>{{ order.date }}</v-col>
                            <v-col class="text-right">{{ order.totalPrice.toFixed(2) }}€</v-col>
                        </v-row>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-container>
                            <v-row v-for="(item, index) in order.items" :key="'orderdetail_' + order.date + index"
                                align="center">
                                <v-col cols="1">
                                    <v-img :src="'https://terralusitana-bucket.s3.eu-west-3.amazonaws.com/images/wines/' + item.image + '.png'"
                                           height="32" width="32" contain></v-img>
                                </v-col>
                                <v-col>{{ item.wine }}</v-col>
                                <v-col cols="1">x{{ item.quantity }}</v-col>
                                <v-col cols="1">{{ item.unitePrice.toFixed(2) }}€</v-col>
                            </v-row>
                        </v-container>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>
        </v-card-text>
    </v-card>
</template>

<script>
    import axios from "axios"
    export default {
        name: "OrderHistory",
        created: function () {
            axios.get("/api/order/")
                .then(response => {
                    console.log(response.data)
                    this.orders = response.data
                    this.loading = false

                })
                .catch(error => {
                    console.log(error)
                })
        },
        data: function () {
            return {
                loading: true,
                orders: []
            }
        }
    }
</script>

<style scoped>

</style>