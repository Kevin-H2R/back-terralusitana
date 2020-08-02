<template>
    <v-form v-model="valid" v-on:submit.prevent="register" class="register-form">
        <v-container>
            <v-row>
                <v-text-field v-model="email"
                              :rules="emailRules"
                              label="Email *"
                              required
                />
            </v-row>
            <v-row>
                <v-text-field v-model="firstname"
                              :rules="nameRules"
                              label="Prénom *"
                              required
                />
            </v-row>
            <v-row>
                <v-text-field v-model="lastname"
                              :rules="nameRules"
                              label="Nom *"
                              required
                />
            </v-row>
            <v-row>
                <v-text-field v-model="password"
                              :rules="passwordRules"
                              label="Mot de passe *"
                              required
                              type="password"
                />
            </v-row>
            <v-row>
                <v-text-field type="password"
                              :rules="[v => v === this.password || 'Les mots de passes doivent correspondre']"
                              label="Confirmer le mot de passe *"
                />
            </v-row>
            <v-row>
                <v-checkbox v-model="checkbox"
                            :rules="[v => !!v || 'Vous devez confirmer avoir plus de 18 ans']"
                            label="Je confirme avoir plus de 18 ans *"
                            required
                >

                </v-checkbox>
            </v-row>
            <v-row v-if="error !== ''" class="register-form__error mb-4" justify="center">
                {{ error}}
            </v-row>
            <v-row justify="center">
                <v-btn color="primary" :disabled="!valid" :loading="loading" type="submit">
                    Créer mon compte
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
            register: function () {
                this.error = ''
                this.loading = true
                axios.post(
                        '/register',
                        {email: this.email, password: this.password, firstname: this.firstname, lastname: this.lastname}
                    )
                    .then(response => {
                        window.location.replace('/');
                    }).catch(error => {
                        this.error = 'Cette adresse email est déjà utilisée. Veuillez en choisir une autre.'
                        this.loading = false
                })
            }
        },
        data: function () {
            return {
                valid: false,
                email: '',
                password: '',
                firstname: '',
                lastname: '',
                emailRules: [
                    v => !!v || 'Veuillez renseigner votre email',
                    v => /.+@.+/.test(v) || "L'email n'est pas valide",
                ],
                nameRules: [
                    v => !!v || 'Veuillez renseigner ce champ'
                ],
                passwordRules: [
                    v => !!v || 'Mot de passe requis'
                ],
                loading: false,
                checkbox: false,
                error: ''
            }
        }
    }
</script>
<style lang="scss">
    .register-form {
        &__error {
            color: red;
            text-align: center;
            font-style: italic;
            font-size: 0.8em;
        }
    }
</style>
