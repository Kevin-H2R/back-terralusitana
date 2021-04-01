<template>
    <span>
        <terra-simpler-app-bar :user-email="userEmail"/>
    </span>
</template>

<script>
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
        }
    }
</script>

<style scoped>

</style>