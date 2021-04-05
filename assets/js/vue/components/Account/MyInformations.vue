<template>
    <v-card class="pa-6">
        <v-card-title>Mes Informations</v-card-title>
        <v-card-text>
            <v-container>
                <v-row><v-col>Email: {{email}}</v-col></v-row>
                <v-row><v-col>Prénom: {{ oldFirstname }}</v-col></v-row>
                <v-row><v-col>Nom: {{ oldLastname }}</v-col></v-row>
                <v-row align="center">
                    <v-col cols="3">Mot de passe: •••••••••••••</v-col>
                    <v-col class="text-right"><v-btn small color="warning" @click="confirmationDialog = true">Reinitialiser</v-btn></v-col>
                    <v-dialog v-model="confirmationDialog" width="500">
                        <v-card>
                            <v-card-title>Réinitialiser votre mot de passe?</v-card-title>
                            <v-card-text>
                                Confirmez-vous vouloir réinitialiser votre mot de passe?<br>
                                Si oui, cliquez sur "Confirmer", vous recevrez un email vous permettant de le faire.
                            </v-card-text>
                            <v-card-actions>
                                <v-btn text color="primary" href="/reset-password">Confirmer</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-row>
            </v-container>
        </v-card-text>
        <v-card-actions>
            <v-row justify="center">
                <v-btn @click="changeInformationDialog = true">Modifier</v-btn>
                <v-dialog v-model="changeInformationDialog" width="500">
                    <v-card>
                        <v-card-title>Modifier mes informations</v-card-title>
                        <v-form v-model="valid" v-on:submit.prevent="modifyInformations" class="pa-6">
                            <v-row>
                                <v-col>
                                    <v-text-field v-model="newFirstname" label="Prénom" :rules="nameRules" required/>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field   v-model="newLastname" label="Nom" :rules="nameRules" required/>
                                </v-col>
                            </v-row>
                            <v-row v-if="error !== ''" class="mb-4" justify="center">
                                {{ error}}
                            </v-row>
                            <v-btn type="submit" :loading="changeInformationLoading"
                                   :disabled="!valid || (newFirstname === firstname && newLastname === lastname) ">
                                Confirmer
                            </v-btn>
                        </v-form>
                    </v-card>
                </v-dialog>
            </v-row>
        </v-card-actions>
    </v-card>
</template>

<script>
    import axios from "axios"
    export default {
        name: "MyInformations",
        props: {
            email: {
                type: String,
                required: true
            },
            firstname: {
                type: String,
                required: true
            },
            lastname: {
                type: String,
                required: true
            },
        },
        methods: {
            modifyInformations: function () {
                this.changeInformationLoading = true
                axios.post('/api/account/information',
                    {'firstname': this.newFirstname, 'lastname': this.newLastname})
                    .then(response => {
                        this.loading = false;
                        this.oldFirstname = this.newFirstname
                        this.oldLastname = this.newLastname
                        this.changeInformationDialog = false
                    })
                    .catch(error => {console.log(error)})
            }
        },
        data: function () {
            return {
                changeInformationDialog: false,
                password: '',
                confirmationDialog: false,
                oldFirstname: this.firstname,
                oldLastname: this.lastname,
                newFirstname: this.firstname,
                newLastname: this.lastname,
                valid: false,
                error: '',
                nameRules: [
                    v => !!v || 'Veuillez renseigner ce champ'
                ],
                changeInformationLoading : false
            }
        }
    }
</script>

<style scoped>

</style>