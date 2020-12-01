<template>
    <v-snackbar
            v-model="snackbar"
            transition="slide-y-reverse-transition"
            left
    >
        {{ text }}
    </v-snackbar>
</template>

<script>
    import {EventBus} from "../plugins/eventbus";
    export default {
        name: "WineSnackbar",
        created: function () {
            EventBus.$on("product-added-to-basket", (text) => {
                this.text = text
                this.snackbar = true
            })
        },
        data: function () {
            return {
                snackbar: false,
                text: ""
            }
        }
    }
</script>

<style scoped>

</style>