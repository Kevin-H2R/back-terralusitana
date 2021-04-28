<template>
    <v-dialog v-model="dialog" max-width="800">
        <template v-slot:activator="{ on, attrs }">
            <v-btn color="warning" width="100%"
                   v-bind="attrs"
                   v-on="on">Modifier</v-btn>
        </template>
        <v-card class="pa-8">
            <v-container>
                <v-row><h3>Modifier le panier</h3></v-row>
                <basket-row-modify v-for="(item, index) in getBasket" :key="'modify_row_' + index"
                                   v-bind="item" :last="index === getBasket.length - 1"
                    />
                <v-row justify="center" class="mt-5">
                    <v-btn color="primary" @click="confirmUpdate">Confirmer</v-btn>
                </v-row>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
    import BasketRowModify from "./BasketRowModify";
    import {EventBus} from "../../plugins/eventbus";

    export default {
        name: "ModifyBasketDialog",
        components: {BasketRowModify},
        computed: {
            getBasket: function () {
                return this.$store.state.basket
            }
        },
        methods: {
            confirmUpdate: function () {
                EventBus.$emit('update-basket-quantity')
                this.dialog = false
            }
        },
        data: function () {
            return {
                dialog: false
            }
        }
    }
</script>

<style scoped>

</style>