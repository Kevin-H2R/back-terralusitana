<template>
    <span>
        <v-app-bar flat color="white" fixed>
            <v-spacer />
            <v-btn text @click="$vuetify.goTo('#welcome', {duration: 400})" v-if="$vuetify.breakpoint.smAndUp">Accueil</v-btn>
            <v-btn icon @click="$vuetify.goTo('#welcome', {duration: 400})" v-else><v-icon>mdi-home</v-icon></v-btn>

            <v-spacer />
            <v-icon color="primary" x-large>mdi-glass-wine</v-icon>
            <v-spacer />

            <v-btn text @click="$vuetify.goTo('#nos-vins', {duration: 400})" v-if="$vuetify.breakpoint.smAndUp">Nos vins</v-btn>
            <v-btn icon @click="$vuetify.goTo('#nos-vins', {duration: 400})" v-else><v-icon>mdi-glass-wine</v-icon></v-btn>

            <v-spacer />
            <login-basket-bar :user-email="userEmail"/>
        </v-app-bar>
        <v-main class="mt-12">
            <home/>
        </v-main>
    </span>
</template>

<script>
    import Home from "../components/Home";
    import LoginForm from "../components/LoginForm"
    import RegisterForm from "../components/RegisterForm"
    import BasketList from "../components/BasketList";
    import LoginBasketBar from "../components/LoginBasketBar";

    export default {
        name: "App.vue",
        components: {Home, LoginForm, RegisterForm, BasketList, LoginBasketBar},
        props: {
            userEmail: {
                type: String,
                required: false
            }
        },
    }
</script>

<style scoped>

</style>