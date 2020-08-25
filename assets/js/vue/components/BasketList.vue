<template>
    <v-list>
        <v-list-item v-for="(item, index) in items" :v-key="'basket_item_' + index">
            <v-list-item-content>
                <v-list-item-title>{{ item.name }}</v-list-item-title>
                <v-list-item-subtitle>{{ item.price }}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
    </v-list>
</template>

<script>
    export default {
        name: "basket-list",
        props: {
            addedWines: {
                type: Array,
                required: true
            }
        },
        data: function () {
            return {
                items: this.addedWines,
            }
        }
    }
</script>

<style scoped>

</style>