<template>
    <v-row>
        <v-col>
            <v-row><v-col><h2>Panier</h2></v-col></v-row>
            <v-row justify="end">
                <v-col cols="12" sm="6">
                    <v-card class="pa-8">
                        <v-container>
                            <v-row justify="center"><h2>Total</h2></v-row>
                            <v-row justify="center" class="my-5">
                                <h1>{{ totalPrice }}€</h1>
                            </v-row>
                            <v-row justify="center"><v-btn color="primary" width="75%">Payer</v-btn></v-row>
                        </v-container>
                    </v-card>
                </v-col>
            </v-row>
            <v-row><v-col><h2>Détail</h2></v-col></v-row>
            <v-row>
                <v-col>
                    <v-card>
                        <v-container>
                            <v-row justify="center">
                                <v-col><v-row justify="center" align="center">Image</v-row></v-col>
                                <v-col><v-row justify="center" align="center">Nom</v-row></v-col>
                                <v-col><v-row justify="center" align="center">Prix unitaire</v-row></v-col>
                                <v-col><v-row justify="center" align="center">Quantité</v-row></v-col>
                                <v-col><v-row justify="center" align="center">Prix total</v-row></v-col>
                            </v-row>
                        </v-container>
                    </v-card>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <basket-row v-for="(item, index) in this.$store.state.basket"
                                :key="'basket_item_' + index"
                                v-bind="item"
                    />
                </v-col>
            </v-row>
            <v-row justify="center">
                <v-col cols="12" sm="6" md="4" lg="2">
                    <modify-basket-dialog/>
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</template>

<script>
    import BasketRow from "../components/Basket/BasketRow";
    import ModifyBasketDialog from "../components/Basket/ModifyBasketDialog";
    export default {
        name: "BasketView.vue",
        components: {ModifyBasketDialog, BasketRow},
        computed: {
            totalPrice: function () {
                const price = this.$store.state.basket.reduce((acc, cur) => {
                    return acc + cur.totalPrice
                }, 0)
                return price.toFixed(2)
            }
        },
        methods: {
          getBasket: function () {
              console.log(this.$store.state.basket)
          }
        }
    }
</script>

<style scoped>

</style>