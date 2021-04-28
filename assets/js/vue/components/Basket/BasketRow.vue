<template>
    <v-card>
        <v-container>
            <v-row justify="center" align="center">
                <v-col>
                    <v-row justify="center">
                        <v-img :src="'https://terralusitana-bucket.s3.eu-west-3.amazonaws.com/images/wines/' + imagePath + '.png'"
                           height="64" contain></v-img>
                    </v-row>
                </v-col>
                <v-col><v-row justify="center">{{ name }}</v-row></v-col>
                <v-col><v-row justify="center">{{ price.toFixed(2) }}€</v-row></v-col>
                <v-col><v-row justify="center">x{{ quantity }}</v-row></v-col>
                <v-col><v-row justify="center" class="font-weight-bold">{{ totalPrice.toFixed(2) }}€</v-row></v-col>
            </v-row>
        </v-container>
    </v-card>
</template>

<script>
    export default {
        name: "BasketRow",
        props: {
            id: {
                type: Number,
                required: true
            },
            name: {
                type: String,
                required: true
            },
            price: {
                type: Number,
                required: true
            },
            quantity: {
                type: Number,
                required: true
            },
            imagePath: {
                type: String,
                required: true
            },
            totalPrice: {
                type: Number,
                required: true
            }
        }
    }
</script>

<style scoped>

</style>