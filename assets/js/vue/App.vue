<template>
    <v-app>
        <router-view />
        <footer style="background-color: grey; font-size: 12px" class="white--text pa-3">© {{ getYear }} TerraLusitana</footer>
    </v-app>
</template>

<script>

    export default {
        name: "App.vue",
        computed: {
            getYear: function () {
                return new Date().getFullYear()
            }
        }
    }
</script>
