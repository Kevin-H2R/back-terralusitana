<template>
    <v-form v-model="valid" v-on:submit.prevent="login" class="login-form">
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
                              type="password"
                />
            </v-row>
            <v-row v-if="error !== ''" class="login-form__error mb-4" justify="center">
                {{ error}}
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
                this.error = ''
                axios.post('/login', {email: this.email, password: this.password})
                .then(response => {
                    window.location.replace('/');
                    this.$store.commit("logIn")
                }).catch(error => {
                    console.log(error)
                    this.error = "Nous n'avons pas réussi à vous connecter. Veuillez vérifier votre email et votre mot de passe."
                    this.loading = false
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
                error: ''
            }
        }
    }
</script>
<style lang="scss">
    .login-form {
        &__error {
            color: red;
            text-align: center;
            font-style: italic;
            font-size: 0.8em;
        }
    }
</style>
