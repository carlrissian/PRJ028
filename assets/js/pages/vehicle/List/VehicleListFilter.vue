<template>
    <erp-filter-vehicle-column @sendSearch="sendSearch" show-filters :auto-submit="false">
        <!-- <single-select-picker
            name="regionId"
            id="regionId"
            div-class="col-md-3 form-group"
            :label="txt.fields.region"
            :options="selectList.regionList"
        /> -->

        <!-- <single-select-picker
            name="area"
            id="area"
            div-class="col-md-3 form-group"
            :label="txt.fields.area"
            :options="selectList.areaList"
        /> -->

        <single-select-picker
            name="branchId"
            id="branchId"
            div-class="col-md-3 form-group"
            :label="txt.fields.branch"
            :options="selectList.branchList"
        />

        <single-select-picker
            name="locationId"
            id="locationId"
            div-class="col-md-3 form-group"
            :label="txt.fields.location"
            :options="selectList.locationList"
        />

        <single-select-picker
            name="brandId"
            id="brandId"
            div-class="col-md-3 form-group"
            :label="txt.fields.brand"
            :options="selectList.brandList"
        />

        <single-select-picker
            name="modelId"
            id="modelId"
            div-class="col-md-3 form-group"
            :label="txt.fields.model"
            :options="selectList.modelList"
        />

        <single-select-picker
            name="trimId"
            id="trimId"
            div-class="col-md-3 form-group"
            :label="txt.fields.trim"
            :options="selectList.trimList"
        />

        <multiple-select-picker
            name="providerId"
            id="providerId"
            div-class="col-md-3 form-group"
            :label="txt.fields.provider"
            :options="selectList.providerList"
        />

        <single-select-picker
            name="purchaseMethod"
            id="purchaseMethod"
            div-class="col-md-3 form-group"
            :label="txt.fields.purchaseMethod"
            :options="selectList.purchaseMethodList"
        />

        <single-select-picker
            name="saleMethodId"
            id="saleMethodId"
            div-class="col-md-3 form-group"
            :label="txt.fields.saleMethod"
            :options="selectList.saleMethodList"
        />

        <multiple-select-picker
            name="carClassId"
            id="carClassId"
            div-class="col-md-3 form-group"
            :label="txt.fields.carClass"
            :options="selectList.carClassList"
        />

        <multiple-select-picker
            name="carGroupId"
            id="carGroupId"
            div-class="col-md-3 form-group"
            :label="txt.fields.carGroup"
            :options="selectList.carGroupList"
        />

        <multiple-select-picker
            name="acrissId"
            id="acrissId"
            div-class="col-md-3 form-group"
            :label="txt.fields.acriss"
            :options="selectList.acrissList"
        />

        <multiple-select-picker
            name="motorizationTypeId"
            id="motorizationTypeId"
            div-class="col-md-3 form-group"
            :label="txt.fields.motorizationType"
            :options="selectList.motorizationTypeList"
        />

        <multiple-select-picker
            name="gearBoxId"
            id="gearBoxId"
            div-class="col-md-3 form-group"
            :label="txt.fields.gearBox"
            :options="selectList.gearBoxList"
        />

        <multiple-select-picker
            name="vehicleStatusId"
            id="vehicleStatusId"
            div-class="col-md-3 form-group"
            :label="txt.fields.status"
            :options="selectList.vehicleStatusList"
        />

        <!-- KM desde/hasta -->
        <input-number
            @updatedInputNumber="vehicleFilters.kmFrom = $event"
            name="kmFrom"
            id="kmFrom"
            div-class="col-md-3 form-group"
            :label="txt.fields.kmFrom"
            :value="vehicleFilters.kmFrom"
            :max="vehicleFilters.kmTo ? parseInt(vehicleFilters.kmTo) : undefined"
        />
        <input-number
            @updatedInputNumber="vehicleFilters.kmTo = $event"
            name="kmTo"
            id="kmTo"
            div-class="col-md-3 form-group"
            :label="txt.fields.kmTo"
            :value="vehicleFilters.kmTo"
            :min="vehicleFilters.kmFrom ? parseInt(vehicleFilters.kmFrom) : undefined"
        />
        <!--  -->

        <!-- Fecha recepción desde/hasta -->
        <date-picker
            @updatedDatePicker="vehicleFilters.deliveryDateFrom = $event"
            name="deliveryDateFrom"
            id="deliveryDateFrom"
            div-class="col-md-3 form-group"
            :limit-end-day="vehicleFilters.deliveryDateTo"
            :label="txt.fields.deliveryDateFrom"
            :value="vehicleFilters.deliveryDateFrom"
        />

        <date-picker
            @updatedDatePicker="vehicleFilters.deliveryDateTo = $event"
            name="deliveryDateTo"
            id="deliveryDateTo"
            div-class="col-md-3 form-group"
            :limit-start-day="vehicleFilters.deliveryDateFrom"
            :label="txt.fields.deliveryDateTo"
            :value="vehicleFilters.deliveryDateTo"
        />
        <!--  -->

        <!-- Fecha inicio alquiler desde/hasta -->
        <date-picker
            @updatedDatePicker="vehicleFilters.firstRentDateFrom = $event"
            name="firstRentDateFrom"
            id="firstRentDateFrom"
            div-class="col-md-3 form-group"
            :limit-end-day="vehicleFilters.firstRentDateTo"
            :label="txt.fields.firstRentDateFrom"
            :value="vehicleFilters.firstRentDateFrom"
        />

        <date-picker
            @updatedDatePicker="vehicleFilters.firstRentDateTo = $event"
            name="firstRentDateTo"
            id="firstRentDateTo"
            div-class="col-md-3 form-group"
            :limit-start-day="vehicleFilters.firstRentDateFrom"
            :label="txt.fields.firstRentDateTo"
            :value="vehicleFilters.firstRentDateTo"
        />
        <!--  -->

        <!-- Fecha fin alquiler desde/hasta -->
        <date-picker
            @updatedDatePicker="vehicleFilters.rentingEndDateFrom = $event"
            name="rentingEndDateFrom"
            id="rentingEndDateFrom"
            div-class="col-md-3 form-group"
            :limit-end-day="vehicleFilters.rentingEndDateTo"
            :label="txt.fields.rentingEndDateFrom"
            :value="vehicleFilters.rentingEndDateFrom"
        />

        <date-picker
            @updatedDatePicker="vehicleFilters.rentingEndDateTo = $event"
            name="rentingEndDateTo"
            id="rentingEndDateTo"
            div-class="col-md-3 form-group"
            :limit-start-day="vehicleFilters.rentingEndDateFrom"
            :label="txt.fields.rentingEndDateTo"
            :value="vehicleFilters.rentingEndDateTo"
        />
        <!--  -->

        <!-- Fecha salida instalaciones desde/hasta -->
        <date-picker
            @updatedDatePicker="vehicleFilters.byeByeDateFrom = $event"
            name="byeByeDateFrom"
            id="byeByeDateFrom"
            div-class="col-md-3 form-group"
            :limit-end-day="vehicleFilters.byeByeDateTo"
            :label="txt.fields.byeByeDateFrom"
            :value="vehicleFilters.byeByeDateFrom"
        />

        <date-picker
            @updatedDatePicker="vehicleFilters.byeByeDateTo = $event"
            name="byeByeDateTo"
            id="byeByeDateTo"
            div-class="col-md-3 form-group"
            :limit-start-day="vehicleFilters.byeByeDateFrom"
            :label="txt.fields.byeByeDateTo"
            :value="vehicleFilters.byeByeDateTo"
        />
        <!--  -->

        <!-- TODO filtros para v2.0 -->
        <!-- title="Transporte devolución vehículos" -->
        <!-- <single-select-picker
            name="logistic"
            id="logistic"
            div-class="col-md-3 form-group"
            :label="txt.fields.logistic"
            :options="selectList.logisticList"
        /> -->
        <!-- title="Coste del transporte asumidos por" -->
        <!-- <single-select-picker
            name="assumedCostBy"
            id="assumedCostBy"
            div-class="col-md-3 form-group"
            :label="txt.fields.assumedCostBy"
            :options="selectList.assumedCostByList"
        /> -->
        <!--  -->

        <!-- Fecha devolución desde/hasta -->
        <date-picker
            @updatedDatePicker="vehicleFilters.returnDateFrom = $event"
            name="returnDateFrom"
            id="returnDateFrom"
            div-class="col-md-3 form-group"
            :limit-end-day="vehicleFilters.returnDateTo"
            :label="txt.fields.returnDateFrom"
            :value="vehicleFilters.returnDateFrom"
        />

        <date-picker
            @updatedDatePicker="vehicleFilters.returnDateTo = $event"
            name="returnDateTo"
            id="returnDateTo"
            div-class="col-md-3 form-group"
            :limit-start-day="vehicleFilters.returnDateFrom"
            :label="txt.fields.returnDateTo"
            :value="vehicleFilters.returnDateTo"
        />
        <!--  -->

        <!-- Fecha de primera matriculación desde/hasta -->
        <!-- <date-picker
            @updatedDatePicker="vehicleFilters.firstRegistrationDateFrom = $event"
            name="firstRegistrationDateFrom"
            id="firstRegistrationDateFrom"
            div-class="col-md-3 form-group"
            :limit-end-day="vehicleFilters.firstRegistrationDateTo"
            :label="txt.fields.firstRegistrationDateFrom"
            :value="vehicleFilters.firstRegistrationDateFrom"
        /> -->

        <!-- <date-picker
            @updatedDatePicker="vehicleFilters.firstRegistrationDateTo = $event"
            name="firstRegistrationDateTo"
            id="firstRegistrationDateTo"
            div-class="col-md-3 form-group"
            :limit-start-day="vehicleFilters.firstRegistrationDateFrom"
            :label="txt.fields.firstRegistrationDateTo"
            :value="vehicleFilters.firstRegistrationDateTo"
        /> -->
        <!--  -->

        <!-- Fecha matriculación desde/hasta -->
        <date-picker
            @updatedDatePicker="vehicleFilters.registrationDateFrom = $event"
            name="registrationDateFrom"
            id="registrationDateFrom"
            div-class="col-md-3 form-group"
            :limit-end-day="vehicleFilters.registrationDateTo"
            :label="txt.fields.registrationDateFrom"
            :value="vehicleFilters.registrationDateFrom"
        />

        <date-picker
            @updatedDatePicker="vehicleFilters.registrationDateTo = $event"
            name="registrationDateTo"
            id="registrationDateTo"
            div-class="col-md-3 form-group"
            :limit-start-day="vehicleFilters.registrationDateFrom"
            :label="txt.fields.registrationDateTo"
            :value="vehicleFilters.registrationDateTo"
        />
        <!--  -->

        <!-- Fecha inicio bloqueo desde/hasta -->
        <date-picker
            @updatedDatePicker="vehicleFilters.startBlockageDateFrom = $event"
            name="startBlockageDateFrom"
            id="startBlockageDateFrom"
            div-class="col-md-3 form-group"
            :limit-end-day="vehicleFilters.startBlockageDateTo"
            :label="txt.fields.startBlockageDateFrom"
            :value="vehicleFilters.startBlockageDateFrom"
        />

        <date-picker
            @updatedDatePicker="vehicleFilters.startBlockageDateTo = $event"
            name="startBlockageDateTo"
            id="startBlockageDateTo"
            div-class="col-md-3 form-group"
            :limit-start-day="vehicleFilters.startBlockageDateFrom"
            :label="txt.fields.startBlockageDateTo"
            :value="vehicleFilters.startBlockageDateTo"
        />
        <!--  -->

        <!-- Fecha fin bloqueo desde/hasta -->
        <date-picker
            @updatedDatePicker="vehicleFilters.endBlockageDateFrom = $event"
            name="endBlockageDateFrom"
            id="endBlockageDateFrom"
            div-class="col-md-3 form-group"
            :limit-end-day="vehicleFilters.endBlockageDateTo"
            :label="txt.fields.endBlockageDateFrom"
            :value="vehicleFilters.endBlockageDateFrom"
        />

        <date-picker
            @updatedDatePicker="vehicleFilters.endBlockageDateTo = $event"
            name="endBlockageDateTo"
            id="endBlockageDateTo"
            div-class="col-md-3 form-group"
            :limit-start-day="vehicleFilters.endBlockageDateFrom"
            :label="txt.fields.endBlockageDateTo"
            :value="vehicleFilters.endBlockageDateTo"
        />
        <!--  -->

        <!-- Fecha de carga real desde/hasta -->
        <!-- <date-picker
            @updatedDatePicker="vehicleFilters.actualLoadDateFrom = $event"
            name="actualLoadDateFrom"
            id="actualLoadDateFrom"
            div-class="col-md-3 form-group"
            :limit-end-day="vehicleFilters.actualLoadDateTo"
            :label="txt.fields.actualLoadDateFrom"
            :value="vehicleFilters.actualLoadDateFrom"
        /> -->

        <!-- <date-picker
            @updatedDatePicker="vehicleFilters.actualLoadDateTo = $event"
            name="actualLoadDateTo"
            id="actualLoadDateTo"
            div-class="col-md-3 form-group"
            :limit-start-day="vehicleFilters.actualLoadDateFrom"
            :label="txt.fields.actualLoadDateTo"
            :value="vehicleFilters.actualLoadDateTo"
        /> -->
        <!--  -->

        <!-- Fecha de descarga real desde/hasta -->
        <!-- <date-picker
            @updatedDatePicker="vehicleFilters.actualUnloadDateFrom = $event"
            name="actualUnloadDateFrom"
            id="actualUnloadDateFrom"
            div-class="col-md-3 form-group"
            :limit-end-day="vehicleFilters.actualUnloadDateTo"
            :label="txt.fields.actualUnloadDateFrom"
            :value="vehicleFilters.actualUnloadDateFrom"
        /> -->

        <!-- <date-picker
            @updatedDatePicker="vehicleFilters.actualUnloadDateTo = $event"
            name="actualUnloadDateTo"
            id="actualUnloadDateTo"
            div-class="col-md-3 form-group"
            :limit-start-day="vehicleFilters.actualUnloadDateFrom"
            :label="txt.fields.actualUnloadDateTo"
            :value="vehicleFilters.actualUnloadDateTo"
        /> -->
        <!--  -->

        <multiple-select-picker
            name="vehicleTypeId"
            id="vehicleTypeId"
            div-class="col-md-3 form-group"
            :label="txt.fields.vehicleType"
            :options="selectList.vehicleTypeList"
        />

        <!-- <multiple-select-picker
            name="connectedVehicle"
            id="connectedVehicle"
            div-class="col-md-3 form-group"
            :label="txt.fields.connectedVehicle"
            :options="selectList.connectedVehicleList"
        /> -->

        <multiple-select-picker
            name="columns[]"
            id="columns"
            div-class="col-md-6 form-group"
            :label="txt.fields.cols"
            :options="selectList.columnList"
            :value="vehicleFilters.columns"
            disabled-options
        />
    </erp-filter-vehicle-column>
</template>

<script>
import Loading from "../../../../assets/js/utilities";
import ErpFilterVehicleColumn from "./ErpFilterVehicleColumn.vue";
import DatePicker from "../../../../SharedAssets/vue/components/base/inputs/DatePicker.vue";
import InputNumber from "../../../../SharedAssets/vue/components/base/inputs/InputNumber.vue";
import MultipleSelectPicker from "../../../../SharedAssets/vue/components/base/inputs/MultipleSelectPicker.vue";
import SingleSelectPicker from "../../../../SharedAssets/vue/components/base/inputs/SingleSelectPicker.vue";

export default {
    name: "VehicleFilter",
    components: {
        ErpFilterVehicleColumn,
        DatePicker,
        InputNumber,
        MultipleSelectPicker,
        SingleSelectPicker,
    },
    data() {
        return {
            txt: {},
            selectList: {},
            vehicleFilters: {
                kmFrom: null,
                kmTo: null,
                deliveryDateFrom: null,
                deliveryDateTo: null,
                firstRentDateFrom: null,
                firstRentDateTo: null,
                rentingEndDateFrom: null,
                rentingEndDateTo: null,
                byeByeDateFrom: null,
                byeByeDateTo: null,
                returnDateFrom: null,
                returnDateTo: null,
                firstRegistrationDateFrom: null,
                firstRegistrationDateTo: null,
                registrationDateFrom: null,
                registrationDateTo: null,
                startBlockageDateFrom: null,
                startBlockageDateTo: null,
                endBlockageDateFrom: null,
                endBlockageDateTo: null,
                actualLoadDateFrom: null,
                actualLoadDateTo: null,
                actualUnloadDateFrom: null,
                actualUnloadDateTo: null,
                columns: null,
            },
        };
    },
    created() {
        this.txt = txtTrans;
    },
    async mounted() {
        this.getSelectors();
    },
    methods: {
        async getSelectors() {
            Loading.starLoading();
            try {
                let resp = await this.axios.get(this.routing.generate("vehicle.getSelectors"));
                this.selectList = resp.data;
                this.vehicleFilters.columns = this.selectList?.columnList
                    .filter((column) => column?.disabled)
                    .map((column) => column.id);
                Loading.endLoading();
            } catch (error) {
                console.error(error.response);
                Loading.endLoading();
            }
        },
        sendSearch() {
            this.$emit("sendSearch");
        },
    },
};
</script>

<style scoped></style>
