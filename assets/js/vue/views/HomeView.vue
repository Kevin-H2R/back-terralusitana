<template>
    <span>
        <terra-app-bar :user-email="userEmail"/>
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
    import TerraAppBar from "../components/TerraAppBar";
    export default {
        name: "App.vue",
        components: {Home, LoginForm, RegisterForm, BasketList, LoginBasketBar, WineSnackbar, TerraAppBar},
        props: {
            userEmail: {
                type: String,
                required: false,
                default: ''
            }
        },
    }
</script>

<style scoped>

</style>