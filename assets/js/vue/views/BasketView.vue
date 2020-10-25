<template>
    <span>
        <v-app-bar flat color="white" fixed>
            <v-btn text to="/">Retour à Acceuil</v-btn>
            <v-spacer />
            <v-icon color="primary" x-large>mdi-glass-wine</v-icon>
            <v-spacer />
            <login-basket-bar :user-email="userEmail"/>
        </v-app-bar>
        <v-main class="mt-12">
            <basket-page />
        </v-main>
    </span>
</template>

<script>
    import LoginBasketBar from "../components/LoginBasketBar";
    import BasketPage from "../components/BasketPage";
    export default {
        name: "BasketView.vue",
        components: {LoginBasketBar, BasketPage},
        props: {
            userEmail: {
                type: String,
                required: false,
                default: ""
            }
        }
    }
</script>

<style scoped>

</style>