<template>
    <v-card class="wine-card" min-height="550">
        <v-container>
            <v-row>
                <v-col cols="12" sm="2" md="3" class="pa-0 d-flex align-center">
                    <v-img :src="'https://terralusitana-bucket.s3.eu-west-3.amazonaws.com/images/wines/' + this.imagePath + '.png'"
                           height="400" contain></v-img>
                </v-col>
                <v-col cols="12" sm="10" md="9" light class="pa-8">
                    <h3>{{ name }}</h3>
                    <div>{{ description }}</div>
                    <v-row class="mt-4" align="center">
                        <v-col cols="12" lg="6">
                            <v-row align="center">
                                <v-col cols="3" md="2">Leger</v-col>
                                <v-col cols="6" md="8" class="pa-0">
                                    <v-progress-linear :value="soft"/>
                                </v-col>
                                <v-col cols="3" md="2">Puissant</v-col>
                            </v-row>
                            <v-row align="center">
                                <v-col cols="3" md="2">Sec</v-col>
                                <v-col cols="6" md="8" class="pa-0">
                                    <v-progress-linear :value="dry"/>
                                </v-col>
                                <v-col cols="3" md="2">Moelleux</v-col>
                            </v-row>
                            <v-row align="center">
                                <v-col cols="3" md="2">Doux</v-col>
                                <v-col cols="6" md="8" class="pa-0">
                                    <v-progress-linear :value="sweet"/>
                                </v-col>
                                <v-col cols="3" md="2">Acide</v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="12" lg="5" offset-lg="1">
                            <v-row align="center" justify="center">
                                <v-img :src="'https://terralusitana-bucket.s3.eu-west-3.amazonaws.com/images/regions/' + this.map + '.png'" height="150" contain></v-img>
                                <h4 class="primary--text">
                                    {{ locationName }}
                                </h4>
                            </v-row>
                        </v-col>
                    </v-row>
                    <v-row align="center" justify="center">
                        <v-col cols="12" md="8">
                            <v-row>
                                <v-col cols="2">
                                    <v-icon color="primary">mdi-percent</v-icon>
                                </v-col>
                                <v-col>{{ alcohol }} %</v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="2">
                                    <v-icon color="primary">mdi-fruit-grapes</v-icon>
                                </v-col>
                                <v-col>{{ formatVarieties }}</v-col>
                            </v-row>
                            <v-row align="center" v-if="this.trophies.length > 0">
                                <v-col cols="2">
                                    <v-icon color="primary">mdi-trophy</v-icon>
                                </v-col>
                                <v-col>
                                    <trophy-row  v-for="(trophy, index) in this.trophies" :key="'trophy_' + index" v-bind="trophy"/>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="12" md="4" v-if="price" class="text-center">
                            <span class="wine-card__price">{{ formattedPrice }}€</span> / bouteille
                        </v-col>
                    </v-row>
                    <v-row align="center" justify="center" justify-md="end" >
                         <v-col class="flex-grow-0">
                             <v-btn-toggle>
                                 <v-btn @click.native.stop="decrease" ref="decreaseButton">-</v-btn>
                                 <v-btn class="wine-thumbnail__button--disabled">{{ bottleCount }}</v-btn>
                                 <v-btn @click.native.stop="increase" ref="increaseButton">+</v-btn>
                             </v-btn-toggle>
                         </v-col>
                        <v-col cols="3">
                            <v-btn @click.native.stop="addToBasket(id, bottleCount)" rounded color="success" block><v-icon>mdi-basket</v-icon></v-btn>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-container>
    </v-card>
</template>
<script>
    import TrophyRow from './TrophyRow'
    import addToCart from "../mixins/addToCart";
    export default {
        name: 'wine-card',
        components: { TrophyRow },
        mixins: [addToCart],
        props: {
            id: {
                type: Number,
                required: true
            },
            imagePath: {
                type: String,
                required: false,
                default: 'redwine'
            },
            name: {
                type: String,
                required: true
            },
            description: {
                type: String,
                required: true
            },
            soft: {
                type: Number,
                required: false,
                default: 50
            },
            dry: {
                type: Number,
                required: false,
                default: 50
            },
            sweet: {
                type: Number,
                required: false,
                default: 50
            },
            price: {
                type: Number,
                required: false
            },
            alcohol: {
                type: Number,
                required: true
            },
            trophies: {
                type: Array,
                required: false,
                default: () => []
            },
            varieties: {
                type: Array,
                required: true
            },
            map: {
                type: String,
                required: true
            },
            locationName: {
                type: String,
                required: true
            }
        },
        methods: {
            increase: function () {
                ++this.bottleCount
            },
            decrease: function () {
                if (this.bottleCount === 0) {
                    return
                }
                --this.bottleCount
            }
        },
        computed: {
            formatVarieties: function () {
                return this.varieties.join(', ')
            },
        },
        data: function () {
            let formattedPrice = ""
            if (this.price) {
                formattedPrice = (Math.round(this.price * 100) / 100).toFixed(2);
            }
            return {
                cardHeight: '600px',
                imageHeight: '500px',
                formattedPrice: formattedPrice,
                bottleCount: 6
            }
        }
    }
</script>
<style lang="scss">
    .wine-card {
        &__price {
            font-size: 4em;
        }
    }
</style>
