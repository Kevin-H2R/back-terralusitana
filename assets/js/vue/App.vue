<template>
    <v-app>
        <router-view />
        <footer style="background-color: grey; font-size: 12px" class="app-footer white--text pa-3 d-flex">
            <span>
                © {{ getYear }} TerraLusitana
            </span>
            <v-spacer></v-spacer>
            <span><a href="/charte-vie-privee">Charte Vie Privée</a></span>
            <v-spacer></v-spacer>
            <span><a href="/mentions-et-cgv">Mentions Légales & CGV</a></span>
            <v-spacer></v-spacer>
        </footer>
    </v-app>
</template>
<script>
    export default {
        name: "App.vue",
        computed: {
            getYear: function () {
                return new Date().getFullYear()
            }
        }
    }
</script>
<style lang="scss">
    .app-footer a {
        text-decoration: none;
        color: white !important;
    }
</style>
