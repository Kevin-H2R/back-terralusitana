<template>
    <v-row align="center" justify="center">
        <v-col cols="12" md="3">
            <v-row align="center" justify="center">
                <v-checkbox label="Rouge" v-model="redWineCheckbox" class="mx-2"/>
                <v-checkbox label="Rosé" v-model="roseWineCheckbox" class="mx-2"/>
                <v-checkbox label="Blanc" v-model="whiteWineCheckbox" class="mx-2"/>
                <v-checkbox label="Pétillant" v-model="sparklingWineCheckbox" class="mx-2"/>
            </v-row>
        </v-col>
        <v-col cols="12" md="2">
            <v-text-field v-model="nameFilter"
                          @input="updateFilter()" clearable
                          dense rounded label="Nom" outlined
                          hide-details class="mx-2"/>
        </v-col>
        <v-col cols="12" md="1">
            <v-menu
                    transition="slide-y-transition"
                    offset-x
                    :close-on-content-click="false"
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
                    <v-list-item-group v-model="selectedRegions" multiple @change="updateFilter">
                        <v-list-item v-for="(region, index) in this.$store.getters.regions"
                                     :key="'region_' + index"
                        >
                            <template v-slot:default="{ active, }">
                                <v-list-item-action>
                                    <v-checkbox
                                            :input-value="active"
                                            color="primary"
                                    ></v-checkbox>
                                </v-list-item-action>

                                <v-list-item-content>
                                    <v-list-item-title>{{ region }}</v-list-item-title>
                                </v-list-item-content>
                            </template>
                        </v-list-item>
                    </v-list-item-group>
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
                    const storeRegions = this.$store.getters.regions
                    const filteredRegions = this.selectedRegions.reduce((acc, cur) => {
                        if (storeRegions[cur] !== undefined) {
                            acc.push(storeRegions[cur])
                        }
                        return acc
                    }, [])
                    this.$store.commit('filterWines', {name: this.nameFilter, regions: filteredRegions})
                }, 500);
            }
        },
        data: function () {
            return {
                redWineCheckbox: true,
                roseWineCheckbox: true,
                whiteWineCheckbox: true,
                sparklingWineCheckbox: true,
                nameFilter: '',
                timer: null,
                regions: [],
                selectedRegions: [0, 1,2,3,4,5,6,7,8,9]
            }
        }
    }
</script>

<style scoped>

</style>