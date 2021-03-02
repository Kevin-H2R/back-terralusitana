<template>
    <v-container fluid class="home">
        <v-row style="height: 100vh" id="welcome">
            <v-parallax src="https://terralusitana-bucket.s3.eu-west-3.amazonaws.com/images/douro2bw.jpg" style="width: 100%" :height="$vuetify.breakpoint.mdAndUp ? 600 : 500">
                <v-row justify="center"  class="home__title-container">
                    <v-col cols="12" sm="8" md="6">
                        <h1 class="text-center primary--text home__title">Terra Lusitana</h1>
                        <h2 class="home__subtitle">"Le caractère du terroir Portugais dans votre verre"</h2>
                    </v-col>
                </v-row>
            </v-parallax>

            <v-col cols="12" class="d-flex flex-column align-center">
                <h2>Suivez-nous:</h2>
                <div>
                    <social-media-links/>
                </div>
            </v-col>
        </v-row>

        <v-row justify="center" style="min-height: 100vh" id="nos-vins" class="pa-12">
            <wine-thumbnail class="ma-5" v-for="(wine, index) in getWinesThumbnail" :key="'wine-thumbnail_' + index"
                            v-bind="wine"/>
        </v-row>
        <v-row justify="center" style="min-height: 100vh" id="nous-contacter" class="pa-12">
            <v-col cols="12" md="6">
                <h2 class="text-center">Nous contacter:</h2>
                <v-form>
                    <v-container fluid>
                        <v-row justify="center" align="center">
                            <v-col>
                                <v-text-field outlined label="Sujet" v-model="mailSubject"></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row justify="center" align="center">
                            <v-col>
                                <v-textarea outlined label="Message" v-model="mailMessage"></v-textarea>
                            </v-col>
                        </v-row>
                        <v-row justify="center" align="center">
                            <v-col class="text-center">
                                <v-btn color="primary" v-if="$vuetify.breakpoint.smAndUp" :disabled="mailSubject === '' || mailMessage === ''"
                                       :href="'mailto:contact@terra-lusitana.com?subject=' + mailSubject + '&body=' + mailMessage">
                                    contact@terra-lusitana.com</v-btn>

                                <v-btn color="primary" v-else width="100%" :disabled="mailSubject === '' || mailMessage === ''"
                                       :href="'mailto:contact@terra-lusitana.com?subject=' + mailSubject + '&body=' + mailMessage">
                                    <v-icon>mdi-email-send</v-icon>
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-form>
            </v-col>
        </v-row>


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
    import SocialMediaLinks from "./SocialMediaLinks";
    export default {
        name: 'Home',
        components: {WineCard, WineThumbnail, SocialMediaLinks},
        created: function () {
            EventBus.$on('wine-clicked', name => {
                const wines = this.getWines
                const index = wines.indexOf(wines.filter(cur => cur.name === name)[0])
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
                carouselModel: 0,
                carouselShown: false,
                mailSubject: '',
                mailMessage: '',
                mailName: ''
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
