<template>
<!--    <div style="position: fixed; top: 50%; left: 2.5%">-->
<!--        <v-btn-->
<!--                color="pink"-->
<!--                fab-->
<!--                dark-->
<!--                small-->
<!--        >-->
<!--            <v-icon>mdi-plus</v-icon>-->
<!--        </v-btn>-->
<!--    </div>-->
    <div class="social-media-links">
        <v-btn fab icon color="error" href="https://www.instagram.com/terralusitana/" target="_blank">
            <v-icon>mdi-instagram</v-icon>
        </v-btn>
        <v-btn fab icon color="primary" href="https://www.facebook.com/terralusitana/" target="_blank">
            <v-icon>mdi-facebook</v-icon>
        </v-btn>
    </div>
</template>

<script>
    export default {
        name: "social-media-links"
    }
</script>

<style scoped>

</style>