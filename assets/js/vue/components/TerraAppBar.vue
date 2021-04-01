<template>
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
</template>

<script>
    import LoginBasketBar from "./LoginBasketBar";
    export default {
        name: "TerraAppBar",
        components: {LoginBasketBar},
        props: {
            userEmail: {
                type: String,
                required: true
            }
        }
    }
</script>

<style scoped>

</style>