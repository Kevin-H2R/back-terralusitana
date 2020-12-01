<template>
    <span>
        <v-app-bar flat color="white" fixed>
            <v-toolbar-title @click="$vuetify.goTo('#welcome', {duration: 400})"
                             v-if="$vuetify.breakpoint.smAndUp" >
                Terralusitana
            </v-toolbar-title>
            <v-btn icon @click="$vuetify.goTo('#welcome', {duration: 400})" v-else><v-icon>mdi-home</v-icon></v-btn>
            <v-spacer />

            <v-btn text @click="$vuetify.goTo('#nos-vins', {duration: 400})" v-if="$vuetify.breakpoint.smAndUp">Nos vins</v-btn>
            <v-btn icon @click="$vuetify.goTo('#nos-vins', {duration: 400})" v-else><v-icon>mdi-glass-wine</v-icon></v-btn>

            <v-spacer />
            <login-basket-bar :user-email="userEmail"/>
        </v-app-bar>
        <v-main class="mt-12">
            <home/>
            <wine-snackbar/>
        </v-main>
    </span>
</template>

<script>
    import Home from "../components/Home";
    import LoginForm from "../components/LoginForm"
    import RegisterForm from "../components/RegisterForm"
    import BasketList from "../components/BasketList";
    import LoginBasketBar from "../components/LoginBasketBar";
    import WineSnackbar from "../components/WineSnackbar";
    export default {
        name: "App.vue",
        components: {Home, LoginForm, RegisterForm, BasketList, LoginBasketBar, WineSnackbar},
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