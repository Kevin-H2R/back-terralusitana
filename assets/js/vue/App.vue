<template>
    <v-app>
        <v-app-bar flat color="white" fixed>
            <v-spacer />
            <v-spacer />
            <v-btn text @click="$vuetify.goTo('#welcome', {duration: 400})">Acceuil</v-btn>
            <v-btn text @click="$vuetify.goTo('#nos-vins', {duration: 400})">Nos vins</v-btn>
            <v-spacer />
            <v-spacer />
            <v-icon color="primary" x-large>mdi-glass-wine</v-icon>
            <v-spacer />
            <v-spacer />
            <v-btn text @click="$vuetify.goTo('#notre-histoire', {duration: 400})">Notre histoire</v-btn>
            <v-btn text>Contact</v-btn>
            <v-spacer />
            <v-dialog v-model="loginDialog" width="500" v-if="userEmail === ''">
                <template v-slot:activator="{on}">
                    <v-btn text icon v-on="on"><v-icon>mdi-account</v-icon></v-btn>
                </template>
                <v-card class="pa-5">
                    <v-container>
                        <login-form v-if="login"/>
                        <register-form v-else/>
                        <v-row justify="center" class="mt-8">
                            <v-btn text v-if="login" @click="login = !login" color="primary">Créer un compte</v-btn>
                            <v-btn text v-else @click="login = !login" color="primary">Se connecter</v-btn>
                        </v-row>
                    </v-container>
                </v-card>
            </v-dialog>
            <span v-else>
                <v-btn icon color="primary"><v-icon>mdi-basket</v-icon></v-btn>
<!--                <v-btn text icon color="primary"><v-icon>mdi-account</v-icon></v-btn>-->
                <v-menu
                        transition="slide-y-transition"
                        bottom
                        open-on-hover
                        offset-y
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                                icon
                                color="primary"
                                v-bind="attrs"
                                v-on="on"
                        >
                            <v-icon>mdi-account</v-icon>
                        </v-btn>
                    </template>
                    <v-list>
                        <v-list-item dense href="/logout">
                            <v-list-item-icon><v-icon>mdi-logout</v-icon></v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Se déconnecter</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </span>
        </v-app-bar>
        <v-main class="mt-12">
            <home/>
        </v-main>
    </v-app>
</template>

<script>
    import Home from "./components/Home";
    import LoginForm from "./components/LoginForm"
    import RegisterForm from "./components/RegisterForm"
    export default {
        name: "App.vue",
        components: {Home, LoginForm, RegisterForm},
        props: {
            userEmail: {
                type: String,
                required: false
            }
        },
        data: () => ({
            loginDialog: false,
            login: true
        }),
    }
</script>

<style scoped>

</style>