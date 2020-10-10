<template>
    <v-app-bar flat color="white" fixed>
        <v-btn text to="/">Retour à Acceuil</v-btn>
        <v-spacer />
        <v-icon color="primary" x-large>mdi-glass-wine</v-icon>
        <v-spacer />
        <login-basket-bar :user-email="userEmail"/>
    </v-app-bar>
</template>

<script>
    import LoginBasketBar from "../components/LoginBasketBar";
    export default {
        name: "BasketView.vue",
        components: {LoginBasketBar},
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