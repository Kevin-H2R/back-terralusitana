<template>
    <v-app-bar flat color="white" fixed>
        <v-toolbar-title @click="homeButtonCliked()">
            <v-btn text v-if="$vuetify.breakpoint.smAndUp" >
                Terralusitana
            </v-btn>
            <v-btn icon @click="$vuetify.goTo('#welcome', {duration: 400})" v-else>
                <v-icon>mdi-home</v-icon>
            </v-btn>
        </v-toolbar-title>
        <v-toolbar-items v-if="onHomePage" id="bar-items">
            <v-btn text @click="$vuetify.goTo('#nos-vins', {duration: 400})"
                   v-if="$vuetify.breakpoint.smAndUp">Nos vins</v-btn>
            <v-btn icon @click="$vuetify.goTo('#nos-vins', {duration: 400})"
                   v-else><v-icon>mdi-glass-wine</v-icon></v-btn>

            <v-btn text @click="$vuetify.goTo('#nous-contacter', {duration: 400})"
                   v-if="$vuetify.breakpoint.smAndUp">Contact</v-btn>
            <v-btn icon @click="$vuetify.goTo('#nous-contacter', {duration: 400})"
                   v-else><v-icon>mdi-mail</v-icon></v-btn>
        </v-toolbar-items>
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
        },
        methods: {
            homeButtonCliked: function () {
                this.$router.currentRoute.path === "/" ?
                    this.$vuetify.goTo(0, {duration: 400}) :
                    this.$router.push('/')
            }
        },
        watch:{
            $route (to, from){
                this.onHomePage = to.path === '/'
            }
        },
        data: function () {
            return {
                onHomePage: this.$route.path === "/"
            }
        }
    }
</script>

<style lang="scss">
#bar-items {
    margin-left: 0%;
}
</style>