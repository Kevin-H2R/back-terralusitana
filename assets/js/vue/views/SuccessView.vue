<template>
    <v-main>
        <v-container fluid>
            <v-row align="center" style="height: 100vh">
                <v-col>
                    <v-row justify="center" >
                        <h1>Félicitations pour votre achat</h1>
                    </v-row>
                    <v-row justify="center">
                        <h4>
                            Vous allez recevoir très prochainement un email de confirmation
                        </h4>
                    </v-row>
                    <v-row justify="center" class="mt-5">
                        <v-btn href="/" color="primary">Retour à l'accueil</v-btn>
                    </v-row>
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</template>

<script>
    export default {
        name: "success-view"
    }
</script>

<style scoped>

</style>