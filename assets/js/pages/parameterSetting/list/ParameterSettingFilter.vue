<template>
    <erp-filter>
        <erp-multiple-select-filter
            @changeSelectMultiple="updateAcrissFilter('acrissIds')"
            name="carGroupIds"
            id="carGroupIds"
            class-number="3"
            :label="txt.fields.parameterGroup"
            :data-for-ajax="carGroupList"
        />

        <erp-multiple-select-filter
            @changeSelectMultiple="updateCarGroupFilter('carGroupIds')"
            name="acrissIds"
            id="acrissIds"
            class-number="3"
            :label="txt.fields.parameterAcriss"
            :data-for-ajax="acrissList"
        />

        <erp-multiple-select-filter
            @changeSelectMultiple="updateAcrissFilter('substitutionAcrissIds')"
            name="substitutionCarGroupIds"
            id="substitutionCarGroupIds"
            class-number="3"
            :label="txt.fields.substitutionGroup"
            :data-for-ajax="carGroupList"
        />

        <erp-multiple-select-filter
            @changeSelectMultiple="updateCarGroupFilter('substitutionCarGroupIds')"
            name="substitutionAcrissIds"
            id="substitutionAcrissIds"
            class-number="3"
            :label="txt.fields.substitutionAcriss"
            :data-for-ajax="acrissList"
        />

        <!--  -->

        <!-- <erp-multiple-select-filter
            name="regionIds"
            id="regionIds"
            class-number="3"
            :label="txt.fields.region"
            :data-for-ajax="regionList"
        /> -->

        <!-- <erp-multiple-select-filter name="areaIds" id="areaIds" class-number="3" :label="txt.fields.area" :data-for-ajax="areaaList" /> -->

        <erp-multiple-select-filter
            name="branchIds"
            id="branchIds"
            class-number="3"
            :label="txt.fields.branch"
            :data-for-ajax="branchList"
        />

        <erp-select-filter
            name="parameterSettingTypeId"
            id="parameterSettingTypeId"
            class-number="3"
            :label="txt.fields.parameterType"
            :options="parameterSettingTypeList"
        />

        <erp-date-picker-filter
            @updateDatePicker="changedPicker('startDate', 'endDate', $event)"
            name="startDate"
            id="startDate"
            class-number="col-md-3"
            :label="txt.fields.startDate"
            :start-date="startDate"
            :end-date="endDate"
            :limit-end-day="dates.endDate"
        />
        <erp-date-picker-filter
            class-number="col-md-3"
            @updateDatePicker="changedPicker('startDate', 'endDate', $event)"
            name="endDate"
            id="endDate"
            :label="txt.fields.endDate"
            :start-date="startDate"
            :end-date="endDate"
            :limit-start-day="dates.startDate"
        />

        <!--  -->

        <erp-date-picker-filter
            class-number="col-md-3"
            @updateDatePicker="changedPicker('creationDateFrom', 'creationDateTo', $event)"
            name="creationDateFrom"
            id="creationDateFrom"
            :label="txt.fields.creationDateFrom"
            :start-date="creationDateFrom"
            :end-date="creationDateTo"
            :limit-end-day="dates.creationDateTo"
            v-model="dates.creationDateFrom"
        />
        <erp-time-picker-static-filter
            name="creationTimeFrom"
            id="creationTimeFrom"
            class-number="3"
            :label="txt.fields.creationTimeFrom"
            :disabled="dates.creationDateFrom === null"
            empty-default
        />

        <erp-date-picker-filter
            class-number="col-md-3"
            @updateDatePicker="changedPicker('creationDateFrom', 'creationDateTo', $event)"
            name="creationDateTo"
            id="creationDateTo"
            :label="txt.fields.creationDateTo"
            :start-date="creationDateFrom"
            :end-date="creationDateTo"
            :limit-start-day="dates.creationDateFrom"
            v-model="dates.creationDateTo"
        />
        <erp-time-picker-static-filter
            name="creationTimeTo"
            id="creationTimeTo"
            class-number="3"
            :label="txt.fields.creationTimeTo"
            :disabled="dates.creationDateTo === null"
            empty-default
        />

        <!--  -->

        <!-- TODO: CONNECTED VEHICLE NO MVP disabled = true -->
        <erp-select-filter
            name="connectedVehicle"
            id="connectedVehicle"
            class-number="3"
            :label="txt.fields.connectedVehicle"
            :options="connectedVehicleList"
            disabled
        />
    </erp-filter>
</template>

<script>
import ErpFilter from "../../../components/filter/ErpFilter.vue";
import ErpDatePickerFilter from "../../../components/filter/form/ErpDatePickerFilter.vue";
import ErpMultipleSelectFilter from "../../../components/filter/form/ErpMultipleSelectFilter.vue";
import ErpSelectFilter from "../../../components/filter/form/ErpSelectFilter.vue";
import ErpTimePickerStaticFilter from "../../../components/filterStatic/form/ErpTimePickerStaticFilter.vue";

export default {
    name: "ParameterSettingFilter",
    components: {
        ErpFilter,
        ErpDatePickerFilter,
        ErpMultipleSelectFilter,
        ErpSelectFilter,
        ErpTimePickerStaticFilter,
    },
    data() {
        return {
            txt: {},

            startDate: moment,
            endDate: moment,
            creationDateFrom: moment,
            creationDateTo: moment,
            creationTimeFrom: moment,
            creationTimeTo: moment,

            dates: {
                endDate: null,
                startDate: null,
                creationDateFrom: null,
                creationDateTo: null,
            },

            carGroupList: [],
            acrissList: [],
            regionList: [],
            areaaList: [],
            branchList: [],
            parameterSettingTypeList: [],
            connectedVehicleList: [],

            carGroupSelected: [],
            acrissSelected: [],
            substitutionCarGroupSelected: [],
            substitutionAcrissSelected: [],
        };
    },
    created() {
        this.txt = txtTrans;
    },
    async mounted() {
        this.getFilters();

        // this.startDate = moment().startOf("hour");
        // this.endDate = moment()
        //     .startOf("hour")
        //     .add(32, "hour");
        // this.creationDateFrom = moment().startOf("hour");
        // this.creationDateTo = moment()
        //     .startOf("hour")
        //     .add(32, "hour");
    },
    methods: {
        getFilters: async function() {
            this.axios
                .get(this.routing.generate("parameterSettings.list.filters"))
                .then((response) => {
                    this.regionList = response.data.regions;
                    this.areaaList = response.data.areas;
                    this.branchList = response.data.delegations;
                    this.connectedVehicleList = response.data.connectedVehicleList;
                    this.parameterSettingTypeList = response.data.parameterSettingTypeList;
                    //this.carGroupList = response.data.carGroupList;
                    //this.acrissList = response.data.acrissList;
                    // los siguientes this. mostraran select ordenados alfabeticamente
                    this.acrissList = response.data.acrissList.sort((a, b) => {
                      var nameA = a.name || ""; // Si no tiene 'name', usa string vacío
                      var nameB = b.name || "";
                      return nameA.localeCompare(nameB);
                    });
                    this.carGroupList = response.data.carGroupList.sort((a, b) => {
                      var nameA = a.name || ""; // Si no tiene 'name', usa string vacío
                      var nameB = b.name || "";
                      return nameA.localeCompare(nameB);
                    });
                })
                .catch((error) => {
                    console.error(error.response);
                });
        },
        changedPicker(dateFrom, dateTo, e) {
            let { name, value } = e.target;
            if (value) {
                switch (name) {
                    case "creationDateFrom":
                        this.dates.creationDateFrom = value;
                        break;
                    case "creationDateTo":
                        this.dates.creationDateTo = value;
                        break;
                    case dateTo:
                        this.dates[dateTo] = value;
                        break;
                    case dateFrom:
                        this.dates[dateFrom] = value;
                        break;
                }
            } else {
                switch (name) {
                    case "creationDateTo":
                        this.dates.creationDateTo = null;
                        break;
                    case dateTo:
                        this.dates[dateTo] = null;
                        break;
                }
            }
        },
        updateAcrissFilter(name) {
            let acrissInput = $("#" + name);

            console.log("Update acriss " + name);
            switch (name) {
                case "acrissIds":
                    this.carGroupSelected = $("#carGroupIds").val();

                    this.carGroupSelected = this.carGroupSelected.map(function(item) {
                        return parseInt(item, 10);
                    });
                    this.acrissSelected = [];

                    for (let acriss of this.acrissList) {
                        if (!acriss.carGroupId) {
                            continue;
                        }
                        if (this.carGroupSelected.includes(acriss.carGroupId)) {
                            this.acrissSelected.push(acriss.id);
                        }
                    }

                    acrissInput.val(this.acrissSelected);

                    break;
                case "substitutionAcrissIds":
                    this.substitutionCarGroupSelected = $("#substitutionCarGroupIds").val();
                    this.substitutionCarGroupSelected = this.substitutionCarGroupSelected.map(function(item) {
                        return parseInt(item, 10);
                    });

                    this.substitutionAcrissSelected = [];

                    for (let acriss of this.acrissList) {
                        if (!acriss.carGroupId) {
                            continue;
                        }
                        if (this.substitutionCarGroupSelected.includes(acriss.carGroupId)) {
                            this.substitutionAcrissSelected.push(acriss.id);
                        }
                    }

                    acrissInput.val(this.substitutionAcrissSelected);

                    break;
            }

            this.$nextTick(function() {
                acrissInput.selectpicker("refresh");
            });
        },
        updateCarGroupFilter(name) {
            console.log("Update cargroup " + name);

            let carGroupInput = $("#" + name);

            switch (name) {
                case "carGroupIds":
                    this.acrissSelected = $("#acrissIds").val();
                    this.carGroupSelected = [];

                    for (let acriss of this.acrissList) {
                        if (!acriss.carGroupId) {
                            continue;
                        }
                        if (this.acrissSelected.includes(acriss.id.toString())) {
                            this.carGroupSelected.push(acriss.carGroupId.toString());
                        }
                    }
                    carGroupInput.val(this.carGroupSelected);

                    break;
                case "substitutionCarGroupIds":
                    this.acrissSelected = $("#substitutionAcrissIds").val();
                    this.substitutionCarGroupSelected = [];

                    for (let acriss of this.acrissList) {
                        if (!acriss.carGroupId) {
                            continue;
                        }
                        if (this.acrissSelected.includes(acriss.id.toString())) {
                            this.substitutionCarGroupSelected.push(acriss.carGroupId.toString());
                        }
                    }
                    carGroupInput.val(this.substitutionCarGroupSelected);

                    break;
            }

            this.$nextTick(function() {
                carGroupInput.selectpicker("refresh");
            });
        },
    },
};
</script>

<style scoped></style>
