<template>
    <v-row class="trophy-row">
        <v-icon :color="medal" class="mx-1">mdi-medal</v-icon>
        <h4 class="mx-1">{{ year }}</h4>
        <div class="mx-1">{{ name }}</div>
    </v-row>
</template>
<script>
    export default {
        name: 'trophy-row',
        props: {
            medal: {
                type: String,
                required: true
            },
            year: {
                type: String,
                required: true
            },
            name: {
                type: String,
                required: true
            }
        },
    }
</script>
<style lang="scss">
</style>
