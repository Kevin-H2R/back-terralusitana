<template>
    <v-form v-model="valid" v-on:submit.prevent="login">
        <v-container>
            <v-row>
                <v-text-field v-model="email"
                              :rules="emailRules"
                              label="Email"
                              required
                />
            </v-row>
            <v-row>
                <v-text-field v-model="password"
                              :rules="passwordRules"
                              label="Mot de passe"
                              required
                />
            </v-row>
            <v-row justify="center">
                <v-btn color="primary" :disabled="!valid" :loading="loading" type="submit">
                    Connexion
                </v-btn>
            </v-row>
        </v-container>
    </v-form>
</template>
<script>
    import axios from 'axios'
    export default {
        name: 'login-form',
        methods: {
            login: function () {
                this.loading = true
                axios.post('/login', {email: this.email, password: this.password})
                    .then(response => {
                        window.location.replace('/');
                    })
            }
        },
        data: function () {
            return {
                valid: false,
                email: '',
                password: '',
                emailRules: [
                    v => !!v || 'Veuillez renseigner votre email',
                    v => /.+@.+/.test(v) || "L'email n'est pas valide",
                ],
                passwordRules: [
                    v => !!v || 'Mot de passe requis'
                ],
                loading: false,
            }
        }
    }
</script>
<style lang="scss">
</style>
