<template>
    <erp-filter-vehicle
        @filtersSubmitted="$emit('filtersSubmitted')"
        @filtersCleared="$emit('filtersCleared')"
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
        />

        <multiple-select-picker
            @updatedMultipleSelectPicker="filterModelList($event)"
            name="brandId[]"
            id="brandId"
            div-class="col-md-3 form-group"
            :label="txt.fields.brand"
            :options="selectList.brandList"
            :value="brandIds"
        />

        <multiple-select-picker
            name="modelId[]"
            id="modelId"
            div-class="col-md-3 form-group"
            :label="txt.fields.model"
            :options="modelListFiltered"
            :value="modelIds"
        />

        <multiple-select-picker
            name="carGroupId[]"
            id="carGroupId"
            div-class="col-md-3 form-group"
            :label="txt.fields.carGroup"
            :options="selectList.carGroupList"
            :value="carGroupIds"
        />

        <input-number
            @updatedInputNumber="vehicleFilters.kmFrom = $event"
            name="kmFrom"
            id="kmFrom"
            div-class="col-md-3 form-group"
            :label="txt.fields.kmFrom"
            :value="vehicleFilters.kmFrom"
            :max="parseInt(vehicleFilters.kmTo)"
            :disabled="cannotEditKmFrom"
        />

        <input-number
            @updatedInputNumber="vehicleFilters.kmTo = $event"
            name="kmTo"
            id="kmTo"
            div-class="col-md-3 form-group"
            :label="txt.fields.kmTo"
            :value="vehicleFilters.kmTo"
            :min="parseInt(vehicleFilters.kmFrom)"
            :disabled="cannotEditKmTo"
        />

        <date-picker
            @updatedDatePicker="vehicleFilters.rentingEndDateFrom = $event"
            name="rentingEndDateFrom"
            id="rentingEndDateFrom"
            div-class="col-md-3 form-group"
            :limit-end-day="vehicleFilters.rentingEndDateTo"
            :label="txt.fields.rentingEndDateFrom"
            :value="vehicleFilters.rentingEndDateFrom"
            :disabled="cannotEditRentingEndDateFrom"
        />

        <date-picker
            @updatedDatePicker="vehicleFilters.rentingEndDateTo = $event"
            name="rentingEndDateTo"
            id="rentingEndDateTo"
            div-class="col-md-3 form-group"
            :limit-start-day="vehicleFilters.rentingEndDateFrom"
            :label="txt.fields.rentingEndDateTo"
            :value="vehicleFilters.rentingEndDateTo"
            :disabled="cannotEditRentingEndDateTo"
        />

        <date-picker
            name="checkInDateFrom"
            id="checkInDateFrom"
            div-class="col-md-3 form-group"
            :label="txt.fields.checkInDateFrom"
            :value="vehicleFilters.checkInDateFrom"
            :disabled="!!vehicleFilters.checkInDateFrom"
        />

        <multiple-select-picker
            name="saleMethodId[]"
            id="saleMethodId"
            div-class="col-md-3 form-group"
            :label="txt.fields.saleMethod"
            :options="selectList.saleMethodList"
            :value="saleMethodIds"
            :disabled="!!saleMethodId"
        />

        <multiple-select-picker
            name="vehicleStatusId[]"
            id="vehicleStatusId"
            div-class="col-md-3 form-group"
            :label="txt.fields.vehicleStatus"
            :options="selectList.vehicleStatusList"
            :value="vehicleStatusIds"
        />

        <single-select-picker
            name="connectedVehicle"
            id="connectedVehicle"
            div-class="col-md-3 form-group"
            :label="txt.fields.connectedVehicle"
            :options="selectList.connectedVehicleList"
            :value="vehicleFilters.connectedVehicle"
        />

        <template #more-actions>
            <button
                @click="goToEdit"
                type="button"
                id="edit-movement-filters"
                class="btn btn-record"
                v-text="txt.form.editFilters"
            ></button>
        </template>
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
        saleMethodId: {
            type: Number,
            default: null,
        },
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

            vehicleFilters: {
                vehicleType: [],
                brand: [],
                model: [],
                carGroup: [],
                kmFrom: null,
                kmTo: null,
                rentingEndDateFrom: null,
                rentingEndDateTo: null,
                checkInDate: null,
                saleMethod: [],
                vehicleStatus: [],
            },

            vehicleTypeIds: [],
            brandIds: [],
            modelIds: [],
            carGroupIds: [],
            saleMethodIds: [],
            vehicleStatusIds: [],

            cannotEditKmFrom: false,
            cannotEditKmTo: false,
            cannotEditRentingEndDateFrom: false,
            cannotEditRentingEndDateTo: false,
        };
    },
    created() {
        this.txt = txtTrans;

        this.vehicleFilters.vehicleType = this.filters?.vehicleTypeIdIn;
        this.vehicleFilters.brand = this.filters?.brandIdIn;
        this.vehicleFilters.model = this.filters?.modelIdIn;
        this.vehicleFilters.carGroup = this.filters?.carGroupIdIn;
        this.vehicleFilters.kmFrom = this.filters?.kilometersFrom;
        this.vehicleFilters.kmTo = this.filters?.kilometersTo;
        this.vehicleFilters.rentingEndDateFrom = this.filters?.rentingEndDateFrom;
        this.vehicleFilters.rentingEndDateTo = this.filters?.rentingEndDateTo;
        this.vehicleFilters.checkInDate = this.filters?.checkInDateFrom;
        this.vehicleFilters.saleMethod = this.filters?.saleMethodIdIn;
        this.vehicleFilters.vehicleStatus = this.filters?.vehicleStatusIdIn;
        this.vehicleFilters.connectedVehicle = this.filters?.connectedVehicleList;

        if (!["", null, undefined].includes(this.vehicleFilters.connectedVehicle)) {
            this.connectedVehicleList = [
                {
                    id: this.vehicleFilters.connectedVehicle,
                    name: this.vehicleFilters.connectedVehicle ? this.txt.form.yes : this.txt.form.no,
                },
            ];
        }

        this.cannotEditKmFrom = !!this.vehicleFilters.kmFrom;
        this.cannotEditKmTo = !!this.vehicleFilters.kmTo;
        this.cannotEditRentingEndDateFrom = !!this.vehicleFilters.rentingEndDateFrom;
        this.cannotEditRentingEndDateTo = !!this.vehicleFilters.rentingEndDateTo;
    },
    mounted() {
        this.getIdsForArray(this.vehicleFilters.vehicleType, this.vehicleTypeIds);
        this.getIdsForArray(this.vehicleFilters.brand, this.brandIds);
        this.getIdsForArray(this.vehicleFilters.model, this.modelIds);
        this.getIdsForArray(this.vehicleFilters.carGroup, this.carGroupIds);
        this.getIdsForArray(this.vehicleFilters.saleMethod, this.saleMethodIds);
        this.getIdsForArray(this.vehicleFilters.vehicleStatus, this.vehicleStatusIds);

        this.filterModelList(this.brandIds);

        // Para ejecutar automáticamente la llamada con filtros al cargar la página
        this.$nextTick(function() {
            this.$refs.filters.search();
        });
    },
    methods: {
        goToEdit() {
            window.location.href = this.routing.generate("movement.edit", { id: this.movementId });
        },
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
