<template>
    <erp-filter-vehicle
        @filtersSubmitted="$emit('filtersSubmitted', $event)"
        @filtersCleared="$emit('filtersCleared', $event)"
        ref="filters"
        :auto-submit="false"
    >
        <multiple-select-picker
            name="vehicleTypeId[]"
            id="vehicleTypeId"
            div-class="col-md-3 form-group"
            :label="txt.fields.vehicleType"
            :options="selectList.vehicleTypeList"
            :value="vehicleTypeIds"
            :disabled="vehicleTypeIds.length > 0"
        />

        <multiple-select-picker
            @updatedMultipleSelectPicker="filterModelList($event)"
            name="brandId[]"
            id="brandId"
            div-class="col-md-3 form-group"
            :label="txt.fields.brand"
            :options="selectList.brandList"
        />

        <multiple-select-picker
            name="modelId[]"
            id="modelId"
            div-class="col-md-3 form-group"
            :label="txt.fields.model"
            :options="modelListFiltered"
        />

        <multiple-select-picker
            name="carGroupId[]"
            id="carGroupId"
            div-class="col-md-3 form-group"
            :label="txt.fields.carGroup"
            :options="selectList.carGroupList"
        />

        <input-number
            @updatedInputNumber="vehicleFilters.kmFrom = $event"
            ref="kmFrom"
            name="kmFrom"
            id="kmFrom"
            div-class="col-md-3 form-group"
            :label="txt.fields.kmFrom"
            :max="parseInt(vehicleFilters.kmTo)"
        />

        <input-number
            @updatedInputNumber="vehicleFilters.kmTo = $event"
            ref="kmTo"
            name="kmTo"
            id="kmTo"
            div-class="col-md-3 form-group"
            :label="txt.fields.kmTo"
            :min="parseInt(vehicleFilters.kmFrom)"
        />

        <date-picker
            @updatedDatePicker="vehicleFilters.rentingEndDateFrom = $event"
            ref="rentingEndDateFrom"
            name="rentingEndDateFrom"
            id="rentingEndDateFrom"
            div-class="col-md-3 form-group"
            :limit-end-day="vehicleFilters.rentingEndDateTo"
            :label="txt.fields.rentingEndDateFrom"
        />

        <date-picker
            @updatedDatePicker="vehicleFilters.rentingEndDateTo = $event"
            ref="rentingEndDateTo"
            name="rentingEndDateTo"
            id="rentingEndDateTo"
            div-class="col-md-3 form-group"
            :limit-start-day="vehicleFilters.rentingEndDateFrom"
            :label="txt.fields.rentingEndDateTo"
        />

        <date-picker
            name="checkInDateFrom"
            id="checkInDateFrom"
            div-class="col-md-3 form-group"
            :label="txt.fields.checkInDateFrom"
        />

        <multiple-select-picker
            v-show="false"
            name="saleMethodId[]"
            id="saleMethodId"
            div-class="col-md-3 form-group"
            :label="txt.fields.saleMethod"
            :options="selectList.saleMethodList"
            :value="saleMethodIds"
            :disabled="saleMethodIds.length > 0"
        />

        <multiple-select-picker
            name="vehicleStatusId[]"
            id="vehicleStatusId"
            div-class="col-md-3 form-group"
            :label="txt.fields.vehicleStatus"
            :options="selectList.vehicleStatusList"
        />

        <single-select-picker
            name="connectedVehicle"
            id="connectedVehicle"
            div-class="col-md-3 form-group"
            :label="txt.fields.connectedVehicle"
            :value="vehicleFilters.connectedVehicle"
            :options="selectList.connectedVehicleList"
        />
    </erp-filter-vehicle>
</template>

<script>
import ErpFilterVehicle from "../../../../../components/filter/ErpFilterVehicle.vue";
import DatePicker from "../../../../../../SharedAssets/vue/components/base/inputs/DatePicker.vue";
import InputNumber from "../../../../../../SharedAssets/vue/components/base/inputs/InputNumber.vue";
import SingleSelectPicker from "../../../../../../SharedAssets/vue/components/base/inputs/SingleSelectPicker.vue";
import MultipleSelectPicker from "../../../../../../SharedAssets/vue/components/base/inputs/MultipleSelectPicker.vue";

export default {
    name: "MovementCarrierAssignVehiclesFilter",
    props: {
        selectList: Object,
        filters: Object,
        movementId: Number,
    },
    components: {
        ErpFilterVehicle,
        DatePicker,
        InputNumber,
        SingleSelectPicker,
        MultipleSelectPicker,
    },
    data() {
        return {
            txt: {},

            modelListFiltered: [],

            vehicleTypeIds: [],
            saleMethodIds: [],

            vehicleFilters: {
                vehicleType: [],
                kmFrom: null,
                kmTo: null,
                rentingEndDateFrom: null,
                rentingEndDateTo: null,
                saleMethod: [],
                connectedVehicle: null,
            },
        };
    },
    created() {
        this.txt = txtTrans;

        this.vehicleFilters.vehicleType = this.filters?.vehicleTypeIdIn;
        this.vehicleFilters.saleMethod = this.filters?.saleMethodIdIn;
    },
    mounted() {
        this.getIdsForArray(this.vehicleFilters.vehicleType, this.vehicleTypeIds);
        this.getIdsForArray(this.vehicleFilters.saleMethod, this.saleMethodIds);

        // Para ejecutar automáticamente la llamada con filtros al cargar la página
        this.$nextTick(function() {
            this.$refs.filters.search();
        });
    },
    methods: {
        getIdsForArray(array, property) {
            if (Array.isArray(array) && array.length > 0) {
                array.map((obj) => {
                    property.push(obj.id);
                });
            }
        },
        filterModelList(brandId = null) {
            if (brandId !== null && brandId.length > 0) {
                this.modelListFiltered = this.selectList.modelList.filter((model) => brandId.includes(model.brandId));
                if (this.modelListFiltered.length == 0) {
                    this.$notify({
                        type: "error",
                        text: this.txt.form.noModelsBrand,
                    });
                }
            } else {
                this.modelListFiltered = this.selectList.modelList;
            }
        },
    },
};
</script>

<style scoped></style>
