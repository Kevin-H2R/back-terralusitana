<template>
    <v-app>
        <terra-app-bar :user-email="userEmail" />
        <v-main class="mt-12">
            <v-container fluid class="mt-5">
                <router-view />
                <wine-snackbar/>
            </v-container>
        </v-main>
        <footer style="background-color: grey; font-size: 12px" class="app-footer white--text pa-3 d-flex">
            <span class="d-flex align-center">
                © {{ getYear }} TerraLusitana
            </span>
            <v-spacer></v-spacer>
            <span>
                <v-btn small text to="/charte-vie-privee">
                    Charte Vie Privée
                </v-btn>
             </span>
            <v-spacer></v-spacer>
            <span>
                <v-btn text small to="/mentions-et-cgv">
                    Mentions Légales & CGV
                </v-btn>
            </span>
            <v-spacer></v-spacer>
        </footer>
    </v-app>
</template>
<script>
    import TerraAppBar from "./components/TerraAppBar";
    import WineSnackbar from "./components/WineSnackbar";
    export default {
        name: "App.vue",
        components: {TerraAppBar, WineSnackbar},
        props: {
            userEmail: {
                type: String,
                required: false,
                default: ''
            }
        },
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
