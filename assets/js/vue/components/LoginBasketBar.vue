<template>
    <span>
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
                <v-menu transition="slide-y-transition"
                        :close-on-content-click="false"
                        bottom
                        open-on-hover
                        offset-y
                        v-if="$store.getters.basketCount > 0"
                >
                    <template v-slot:activator="{on, attrs}">
                        <v-badge :content="$store.getters.basketCount.toString()"
                                 :offset-y="25" :offset-x="15"
                                 color="red"
                        >
                            <v-btn icon color="primary" v-bind="attrs" v-on="on"><v-icon>mdi-basket</v-icon></v-btn>
                        </v-badge>
                    </template>
                    <basket-list />
                </v-menu>
                <v-btn icon color="primary" v-else><v-icon>mdi-basket</v-icon></v-btn>

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
                        <v-list-item dense href="/logout" @click="logOut">
                            <v-list-item-icon><v-icon>mdi-logout</v-icon></v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Se déconnecter</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </span>
    </span>
</template>

<script>
    import LoginForm from "./LoginForm";
    import RegisterForm from "./RegisterForm";
    import BasketList from "./BasketList";
    import axios from "axios"

    export default {
        name: "login-basket-bar",
        components: {LoginForm, RegisterForm, BasketList},
        created: function () {
            if (this.$store.state.loggedIn) {
                axios.get('/basket/get')
                    .then(response => {
                        this.$store.commit('initBasket', response.data)
                    })
                    .catch(error => {console.log(error)})
            }
        },
        props: {
            userEmail: {
                type: String,
                required: false
            }
        },
        methods: {
            logOut: function () {
                this.$store.commit("logOut")
            },
        },
        computed: {
            getBasket: function () {
                return this.$store.state.basket
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