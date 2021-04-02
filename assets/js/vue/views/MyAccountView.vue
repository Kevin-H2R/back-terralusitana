<template>
    <span>
        <terra-simpler-app-bar :user-email="userEmail"/>
        <v-main>
            <v-container fluid>
                <v-row style="height: 100vh">
                    <v-card height="300" :loading="loading">
                        <v-card-title>Mes informations</v-card-title>
                        <v-card-text>
                            <div>email: {{email}}</div>
                            <div>firstname: {{ firstname }}</div>
                            <div>lastname: {{lastname}}</div>
                        </v-card-text>
                    </v-card>
                </v-row>
            </v-container>
        </v-main>
    </span>
</template>

<script>
    import axios from "axios";
    import TerraSimplerAppBar from "../components/TerraSimplerAppBar";
    export default {
        name: "MyAccountView",
        components: {TerraSimplerAppBar},
        props: {
            userEmail: {
                type: String,
                required: false,
                default: ''
            }
        },
        created: function () {
            axios.get("/information")
                .then(response => {
                    const data = response.data
                    this.email = data.email
                    this.firstname = data.firstname
                    this.lastname = data.lastname
                })
                .catch(error => {
                    console.log(error)
                })
        },
        data: function () {
            return {
                loading: true,
                email: '',
                firstname: '',
                lastname: ''
            }
        }
    }
</script>

<style scoped>

</style>