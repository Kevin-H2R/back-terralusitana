<template>
    <span>
        <terra-simpler-app-bar :user-email="userEmail"/>
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
                    console.log(response.data)
                })
                .catch(error => {
                    console.log(error)
                })
        },
        data: function () {
            return {
                loading: true
            }
        }
    }
</script>

<style scoped>

</style>