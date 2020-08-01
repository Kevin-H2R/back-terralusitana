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
                              type="password"
                />
            </v-row>
            <v-row>
                <v-text-field type="password"
                              :rules="[v => v === this.password || 'Les mots de passes doivent correspondre']"
                              label="Confirmer le mot de passe"
                />
            </v-row>
            <v-row>
                <v-checkbox v-model="checkbox"
                            :rules="[v => !!v || 'Vous devez confirmer avoir plus de 18 ans']"
                            label="Je confirme avoir plus de 18 ans"
                            required
                >

                </v-checkbox>
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
        name: 'register-form',
        methods: {
            login: function () {
                this.loading = true
                axios.post('http://localhost:8000/register', {email: this.email, password: this.password})
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
                checkbox: false,
            }
        }
    }
</script>
<style lang="scss">
</style>
