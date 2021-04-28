<template>
    <span>
        <v-row align="center" justify="center">
            <v-col cols="12" sm="2" md="1">
                <v-row justify="center">
                    <v-img :src="'https://terralusitana-bucket.s3.eu-west-3.amazonaws.com/images/wines/' + imagePath + '.png'"
                           height="64" contain></v-img>
                </v-row>
            </v-col>
            <v-col cols="12" sm="6" md="3"><v-row justify="center">{{ name }}</v-row></v-col>
            <v-col v-if="getOldPrice === getNewPrice" cols="12" sm="6" md="4">
                <v-row justify="center">
                    {{ getOldPrice }}€
                </v-row>
            </v-col>
            <v-col v-else cols="12" sm="6" md="4">
                <v-row justify="center" align="center">
                    <span class="text-decoration-line-through">{{ getOldPrice }}€</span>
                    <v-icon>mdi-arrow-right</v-icon>
                    <span class="green--text font-weight-bold">{{ getNewPrice }}€</span>
                </v-row>
            </v-col>
            <v-col cols="12" sm="6" md="4">
                <v-row justify="center">
                    <v-btn-toggle>
                        <v-btn @click.native.stop="decrease" ref="decreaseButton">-</v-btn>
                        <v-btn class="wine-thumbnail__button--disabled">{{ currentQuantity }}</v-btn>
                        <v-btn @click.native.stop="increase" ref="increaseButton">+</v-btn>
                    </v-btn-toggle>
                </v-row>
            </v-col>
        </v-row>
        <v-divider v-if="!last"/>
    </span>
</template>

<script>
    export default {
        name: "BasketRowModify",
        props: {
            id: {
                type: Number,
                required: true
            },
            name : {
                type: String,
                required: true
            },
            imagePath: {
                type: String,
                required: true
            },
            quantity: {
                type: Number,
                required: true
            },
            price: {
                type: Number,
                required: true
            },
            last: {
                type: Boolean,
                required: false,
                default: false
            }
        },
        methods: {
            decrease: function () {
                if (this.currentQuantity <= 0) return
                this.currentQuantity--
            },
            increase: function () {
                this.currentQuantity++
            }
        },
        computed: {
            getNewPrice: function () {
                return (this.currentQuantity * this.price).toFixed(2)
            } ,
            getOldPrice: function () {
                return (this.quantity * this.price).toFixed(2)
            }
        },
        data: function () {
            return {
                currentQuantity: this.quantity
            }
        }
    }
</script>

<style scoped>

</style>