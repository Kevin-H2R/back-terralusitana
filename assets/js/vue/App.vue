<template>
    <v-app>
        <v-main class="mt-12">
            <terra-app-bar :user-email="userEmail" />
            <v-container fluid class="mt-1">
                <router-view />
                <wine-snackbar/>
            </v-container>
        </v-main>
        <footer style="background-color: grey; font-size: 12px" class="app-footer white--text pa-3">
            <v-container>
                <v-row justify="space-between">
                    <v-col>© {{ getYear }} TerraLusitana</v-col>
                    <v-col>
                        <v-btn small text to="/charte-vie-privee">
                            Charte Vie Privée
                        </v-btn></v-col>
                    <v-col>
                        <v-btn text small to="/mentions-et-cgv">
                            Mentions Légales & CGV
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>
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
