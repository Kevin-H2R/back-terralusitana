<template>
    <v-card class="pa-6">
        <v-card-title>Mes Informations</v-card-title>
        <v-card-text>
            <v-container>
                <v-row><v-col>email: {{email}}</v-col></v-row>
                <v-row><v-col>firstname: {{ firstname }}</v-col></v-row>
                <v-row><v-col>lastname: {{lastname}}</v-col></v-row>
                <v-row align="center">
                    <v-col cols="3">password: •••••••••••••</v-col>
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
                <v-btn>Modifier</v-btn>
            </v-row>
        </v-card-actions>
    </v-card>
</template>

<script>
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
        data: function () {
            return {
                password: '',
                confirmationDialog: false
            }
        }
    }
</script>

<style scoped>

</style>