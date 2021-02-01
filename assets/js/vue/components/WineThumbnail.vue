<template>
    <v-card class="wine-thumbnail px-4" width="300" hover @click="thumbnailClicked">
        <v-container>
            <v-row>
                <v-img :src="require('../../../images/azulejoModified.jpg')" height="120px" style="position: absolute; left: 0; top: 0"></v-img>
                <v-img :src="wineImage" contain height="200px"></v-img>
            </v-row>
            <v-row class="mt-5">
                <h1 class="wine-thumbnail__name">{{ name }} </h1>
            </v-row>
            <v-row>
                <h3 class="wine-thumbnail__region">{{ locationName }}</h3>
            </v-row>
            <v-row class="mt-5" align="center">
                <h3>{{(Math.round(price * 100) / 100).toFixed(2)}} €</h3>
            </v-row>
            <v-row align="center">
                <v-btn-toggle>
                    <v-btn @click.native.stop="decrease" ref="decreaseButton">-</v-btn>
                    <v-btn class="wine-thumbnail__button--disabled">{{ bottleCount }}</v-btn>
                    <v-btn @click.native.stop="increase" ref="increaseButton">+</v-btn>
                </v-btn-toggle>
                <v-col>
                    <v-btn @click.native.stop="addToBasket(id, bottleCount)" rounded color="success" block
                        :loading="loading">
                        <v-icon>mdi-basket</v-icon>
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
    </v-card>
</template>
<script>
    import { EventBus } from '../plugins/eventbus.js';
    import addToCart from "../mixins/addToCart";

    export default {
        name: 'wine-thumbnail',
        mixins: [addToCart],
        methods: {
            thumbnailClicked: function () {
                EventBus.$emit('wine-clicked', this.name)
            },
        },
        props: {
            id: {
                type: Number,
                required: true
            },
            imagePath: {
                type: String,
                required: true
            },
            name: {
                type: String,
                required: true
            },
            locationName: {
                type: String,
                required: true
            },
            price: {
                type: Number,
                required: true
            }
        },
        data: function () {
            return {
                wineImage: require('../../../images/wines/' + this.imagePath + '.png'),
            }
        }
    }
</script>
<style lang="scss">
    .wine-thumbnail {
        &__name {
            font-size: 1em;
        }
        &__region {
            font-size: 0.75em;
        }
        &__button--disabled {
            pointer-events: none;
        }
    }
    .v-btn.v-item--active.v-btn--active::before {
        background-color: inherit;
    }

</style>
