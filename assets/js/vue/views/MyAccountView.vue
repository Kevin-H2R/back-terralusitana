<template>
    <v-row style="height: 100vh" justify="center">
        <v-progress-circular
                :size="50"
                color="primary"
                indeterminate
                v-if="loading"
        ></v-progress-circular>
        <v-card height="300" :loading="loading" v-else>
            <v-card-title>Mes informations</v-card-title>
            <v-card-text>
                <div>email: {{email}}</div>
                <div>firstname: {{ firstname }}</div>
                <div>lastname: {{lastname}}</div>
            </v-card-text>
        </v-card>
    </v-row>
</template>

<script>
    import axios from "axios";
    export default {
        name: "MyAccountView",
        created: function () {
            axios.get("/api/account/information")
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