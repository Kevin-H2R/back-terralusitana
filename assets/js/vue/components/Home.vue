<template>
    <v-container fluid class="home">
        <v-row style="height: 100vh" align="center" id="welcome">
            <v-parallax :src="douro2Image" style="width: 100%" :height="$vuetify.breakpoint.mdAndUp ? 600 : 500">
                <v-row justify="center"  class="home__title-container">
                    <v-col cols="12" sm="8" md="6">
                        <h1 class="text-center primary--text home__title">Terra Lusitana</h1>
                        <h2 class="home__subtitle">"Le caractère du terroir Portugais dans votre verre"</h2>
                    </v-col>
                </v-row>
            </v-parallax>
        </v-row>

        <div style="min-height: 100vh" class="pa-12" id="nos-vins">
            <v-row justify="center">
                <wine-thumbnail class="ma-5" v-for="(wine, index) in getWinesThumbnail" :key="'wine-thumbnail_' + index"
                                v-bind="wine"/>
            </v-row>
        </div>

        <v-dialog :value="carouselShown" max-width="1200" @input="v => v || (carouselShown = false)">
            <v-carousel light v-model="carouselModel" hide-delimiters hide-delimiter-background height="auto">
                <v-carousel-item v-for="(wine, index) in getWines" :key="'carousel_item_' + index">
                    <wine-card v-bind="wine"/>
                </v-carousel-item>
            </v-carousel>
        </v-dialog>
    </v-container>
</template>

<script>
    import WineCard from "./WineCard";
    import WineThumbnail from "./WineThumbnail"
    import { EventBus } from '../plugins/eventbus.js';
    import axios from "axios"
    export default {
        name: 'Home',
        components: {WineCard, WineThumbnail},
        created: function () {
            EventBus.$on('wine-clicked', name => {
                const index = this.getWines.indexOf(this.getWines.filter(cur => cur.name === name)[0])
                this.carouselShown = true;
                this.carouselModel = index;
            })
            axios.get('/wine/load')
                .then(response => {
                    const wineList = JSON.parse(response.data)
                    this.$store.commit('initWines', wineList)
                })
                .catch(error => {
                    console.log(error)
                })
        },
        computed: {
            getWinesThumbnail: function () {
                return this.$store.getters.winesThumbnail
            },
            getWines : function () {
                return this.$store.getters.wines
            }
        },
        data: function () {
            return {
                douro2Image: require('../../../images/douro2bw.jpg'),
                carouselModel: 0,
                carouselShown: false,
            }
        }
    }
</script>
<style lang="scss">
    .home {
        padding: 0;
        &__title-container {
            height: 50vh;
        }
        &__title {
            font-size: 6em;
            font-family: Georgia, Cambria, Cochin,  Times, 'Times New Roman', serif;
            font-weight: 200;
        }
        &__subtitle {
            -webkit-text-stroke: 1px black;
            color: white;
            text-align: center;
        }
        &__subtitle--small {
            font-size: 2em;
        }
    }
</style>
