<template>
    <v-container fluid class="home">
        <v-row style="height: 100vh" align="center" id="welcome">
            <v-parallax :src="douro2Image" style="width: 100%" :height="$vuetify.breakpoint.mdAndUp ? 600 : 500">
                <v-row justify="center"  class="home__title-container">
                    <v-col cols="12" sm="8" md="6">
                        <h1 class="text-center primary--text home__title">Terra Lusitana</h1>
                        <h2 class="text-center black--text">"Le caractère du terroir Portugais dans votre verre"</h2>
<!--                        <v-btn @click="login">login</v-btn>-->
                    </v-col>
                </v-row>
            </v-parallax>
        </v-row>

        <div style="min-height: 100vh" class="pa-12" id="nos-vins">
            <v-row justify="center">
                <wine-thumbnail class="ma-5" v-for="(wine, index) in wines" :key="'wine-thumbnail_' + index"
                                v-bind="wine"/>
            </v-row>
        </div>

        <v-dialog :value="selectedWine" @input="v => v || clearSelectedWine()" max-width="1200">
            <wine-card v-bind="selectedWine" v-if="selectedWine"/>
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
                const wine = this.wines.filter(cur => cur.name === name)[0]
                this.selectedWine = wine
            })
        },
        methods: {
            clearSelectedWine: function () {
                this.selectedWine = null
            },
            login: function () {
                axios.post('http://localhost:3000/login', {email: "h2r@test.com"})
                    .then(response => {
                        console.log(response)
                    })
            }
        },
        data: function () {
            return {
                selectedWine: null,
                douro2Image: require('../../../images/douro2bw.jpg'),
                wines: [
                    {name: 'Azulejo Rouge', description: 'Arômes intenses de cerises et de baies. Long, agréable et persitant en bouche.',
                        soft: 75, dry: 30, sweet: 50, price: 3.85, imageName: 'azulejo-lisboa-vt-750ml', 'percentage': 13, varieties: ['Castelão', 'Tinta Roriz', 'Pinot Noir'],
                        trophies: [{medal: '#FFDD8E', year: '2019', name: 'China Wine & Spirit Awards Best Value - Double Or'},
                            {medal: '#FFDD8E', year: '2019', name: 'Syndney International Wine Competition - Or'},
                            {medal: '#BABCC1', year: '2019', name: 'Austrian Wine Challenge - Argent'}],
                        map: 'lisbonne', locationName: 'Vin Régional Lisbonne'
                    },
                    {name: 'Azulejo Rosé', description: 'Un rosé léger très frais et savoureux, avec des notes de fruits rouges, fraises et framboises. Excellente fin en bouche.',
                        soft: 50, dry: 50, sweet: 50, price: 3.35, imageName: 'azulejo-lisboa-vr-leve', 'percentage': 9.5, varieties: ['Camarates', 'Cabernet Sauvignon'],
                        trophies: [{medal: '#BABCC1', year: '2017', name: 'Wine Masters Challenge - Argent'},
                            {medal: '#BABCC1', year: '2017', name: 'Concurso de Vinhos Leves de Lisboa - Argent'}],
                        map: 'lisbonne', locationName: 'Vin Régional Lisbonne'},
                    {name: 'Azulejo Blanc', description: "Extrêmement frais et aromatique. Notes d'agrumes et de fruits tropicaux. Vin léger disposant d'une acidité rafraichissante. Partenaire idéal pour plats simple et saints.",
                        soft: 45, dry: 20, sweet: 30, price: 3.35, imageName: 'azulejo-lisboa-vb-leve-750ml', 'percentage': 9.5, varieties: ['Fernão Pires', 'Arinto', 'Vital', 'Moscatel'],
                        trophies: [{medal: '#BABCC1', year: '2017', name: 'Wine Masters Challenge - Argent'},
                            {medal: '#BABCC1', year: '2017', name: 'Concurso Vinhos Leves Lisboa - Argent'}],
                        map: 'lisbonne', locationName: 'Vin Régional Lisbonne'},

                    {name: 'Colossal Reserve Rouge', description: "Couleur rubis intense, ce vin propose des arômes extrêmement riches en nez avec des notes prédominantes de fruits rouges, de mûres et de fleurs. En bouche sa grande complexité sera vous surprendre avec ses notes de mûres et de prunes. Fin en bouche riche et élégante.",
                        soft: 85, dry: 15, sweet: 50, price: 5.80, imageName: 'colossal-vt', 'percentage': 14,
                        varieties: ['Syrah', 'Touriga Nacional', 'Alicante Bouschet', 'Tinta Roriz'], trophies: [
                            {medal: '#FFDD8E', year: '2019', name: 'Sydney International Wine Competition - Or'},
                            {medal: '#FFDD8E', year: '2018', name: 'Gilbert & Gaillard International Challenge - Or'},
                            {medal: '#FFDD8E', year: '2018', name: 'Concours Mondial de Bruxelles - Or'},
                            {medal: '#FFDD8E', year: '2018', name: 'Austrian Wine Challenge - Or'},
                            {medal: '#FFDD8E', year: '2018', name: 'Mundus Vini (spring tasting) - Or'},
                            {medal: '#FFDD8E', year: '2018', name: 'China Wine & Spirit Awards Best Value - Or'},
                        ],
                        map: 'lisbonne', locationName: 'Vin Régional Lisbonne'},
                    {name: 'Colossal Reserve Rosé', description: 'Belle couleur saumon, ce vin est très aromatique et frais, notes de fraises et de baies. En bouche on retrouve les notes de fraises ainsi que de framboises bien mariées à une excellente acidité et la minéralité typique de la région viticole de Lisbonne.',
                        soft: 50, dry: 50, sweet: 50, price: 4.99, imageName: 'colossal-reserva-rose-2018', 'percentage': 0, varieties: ['Cabernet Sauvignon', 'Castelão'],
                        map: 'lisbonne', locationName: 'Vin Régional Lisbonne'},
                    {name: 'Colossal Reserve Blanc', description: "Vin extrêmement rafraîchissant riche en arômes de fruits exotiques, de notes florales et d'une acidité vibrante. Équilibré en bouche, il propose une combinaison optimale d'agrumes et de bois, résultant d'une étape en fûts de chêne. Ce vin présente une grande intensité et une minéralité typique de la région de Lisbonne.",
                        soft: 35, dry: 10, sweet: 60, price: 5.45, imageName: 'colossal-reserva-lisboa-vb-2017', 'percentage': 0,
                        varieties: ['Cabernet Sauvignon', 'Castelão'],
                        map: 'lisbonne', locationName: 'Vin Régional Lisbonne'},

                    {name: 'Montes Das Promessas Rouge', description: "Teinte violette profonde. Bonne concentration dans le nez, riches en arômes de fruits noirs combinés avec des notes florales. En bouche, il se présente très fruité avec une bonne structure indiquant un excellent équilibre entre tanins et acidité. Fin longue et élégante.",
                        soft: 75, dry: 30, sweet: 50, price: 4.50, imageName: 'csl_monte_das_promessas_alentejo_2014_tinto_trat', 'percentage': 14,
                        varieties: ['Syrah', 'Touriga Nacional', 'Alicante Bouschet', 'Petit Verdot'], trophies: [
                            {medal: '#FFDD8E', year: '2019', name: 'Wine Master Challenge - Or'},
                            {medal: '#FFDD8E', year: '2018', name: 'Vinalies Internationales - Or'},
                            {medal: '#FFDD8E', year: '2017', name: 'Sélections Mondiales des Vins - Or'},
                            {medal: '#FFDD8E', year: '2017', name: 'Concours Mondial Bruxelles - Or'},
                        ],
                        map: 'alentejo', locationName: 'Vin Régional Alentejo'},
                    {name: 'Bruto de Portugal Vinho Verde', description: "Couleur agrûmes. Arômes de tilleuls, d'oranger et de fleurs. Saveur fruitée et acidité équilibrée. Complexe et élégant en bouche.",
                        soft: 75, dry: 30, sweet: 50, price: 6.20, imageName: 'bruto-de-pt-espumante-vinho-verde', 'percentage': 11.5, varieties: ['Loureiro'],
                        map: 'vinhoverde', locationName: 'DOC Vinho Verde'},
                ]
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
            font-size: 3em;
        }
        &__subtitle--small {
            font-size: 2em;
        }
    }
</style>
