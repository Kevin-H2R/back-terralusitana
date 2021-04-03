<template>
    <v-row justify="center" align="center">
        <v-col  v-if="loading" class="d-flex justify-center">
            <v-progress-circular
                    :size="100"
                    color="primary"
                    indeterminate
            ></v-progress-circular>
        </v-col>
        <v-col cols="12" sm="6" v-else>
            <v-row>
                <v-col>
                    <my-informations :email="email" :firstname="firstname" :lastname="lastname"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <order-history />
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</template>

<script>
    import axios from "axios";
    import OrderHistory from "../components/Order/OrderHistory";
    import MyInformations from "../components/Account/MyInformations";
    export default {
        name: "MyAccountView",
        components: {OrderHistory, MyInformations},
        created: function () {
            axios.get("/api/account/information")
                .then(response => {
                    const data = response.data
                    this.email = data.email
                    this.firstname = data.firstname
                    this.lastname = data.lastname
                    this.loading = false
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