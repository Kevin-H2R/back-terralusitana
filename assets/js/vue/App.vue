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
            <v-dialog v-model="loginDialog" width="500">
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
        </v-app-bar>
        <v-main>
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
        data: () => ({
            loginDialog: false,
            login: true
        }),
    }
</script>

<style scoped>

</style>