<template>
    <v-app-bar flat color="white" fixed>
        <v-btn text to="/" v-if="$vuetify.breakpoint.smAndUp" >
            Terralusitana
        </v-btn>
        <v-btn icon to="/" v-else>
            <v-icon>mdi-glass-wine</v-icon>
        </v-btn>

        <v-spacer />
        <login-basket-bar :user-email="userEmail"/>
    </v-app-bar>
</template>

<script>
    import LoginBasketBar from "./LoginBasketBar";
    export default {
        name: "TerraSimplerAppBar",
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