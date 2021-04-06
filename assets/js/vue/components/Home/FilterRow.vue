<template>
    <v-row align="center" justify="center">
        <v-col cols="12" md="1">
            <v-checkbox label="rouge" v-model="redWineCheckbox" class="mx-2"/>
        </v-col>
        <v-col cols="12" md="1">
            <v-checkbox label="blanc" v-model="whiteWineCheckbox" class="mx-2"/>
        </v-col>
        <v-col cols="12" md="2">
            <v-text-field v-model="nameFilter"
                          @input="updateFilter()"
                          dense rounded label="Nom" outlined
                          hide-details class="mx-2"/>
        </v-col>
        <v-col cols="12" md="1">
            <v-menu
                    transition="slide-y-transition"
                    offset-x
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                            color="primary"
                            outlined
                            v-bind="attrs"
                            v-on="on"
                    >
                        Region
                        <v-icon right>
                            mdi-menu-down
                        </v-icon>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item
                    >
                        <v-list-item-title>Coucou</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: "FilterRow",
        methods: {
            updateFilter: function () {
                if (this.timer) {
                    clearTimeout(this.timer);
                    this.timer = null;
                }
                this.timer = setTimeout(() => {
                    this.$store.commit('filterWines', {name: this.nameFilter})
                }, 500);
            }
        },
        data: function () {
            return {
                redWineCheckbox: true,
                whiteWineCheckbox: true,
                nameFilter: '',
                timer: null
            }
        }
    }
</script>

<style scoped>

</style>