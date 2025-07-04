<template>
    <erp-filter-vehicle-column @sendSearch="sendSearch" show-filters :auto-submit="false">
        <!-- <single-select-picker
            name="regionId"
            id="regionId"
            div-class="col-md-3 form-group"
            :label="txt.fields.region"
            :options="selectList.regionList"
        /> -->

        <multiple-select-picker
            name="areasId"
            id="areasId"
            div-class="col-md-3 form-group"
            :label="txt.fields.area"
            :options="selectList.areaList"
        />

         <multiple-select-picker
            name="branchId"
            id="branchId"
            div-class="col-md-3 form-group"
            :label="txt.fields.branch"
            :options="selectList.branchList"
        />
         <multiple-select-picker
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

        <multiple-select-picker
            name="purchaseMethodId"
            id="purchaseMethodId"
            div-class="col-md-3 form-group"
            :label="txt.fields.purchaseMethod"
            :options="selectList.saleMethodList"
        />

        <multiple-select-picker
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
        <!-- <input-number
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
        /> -->
        <!-- KM desde/hasta -->
        <date-range-picker
            :nameFrom="vehicleFilters.actualKmsFrom"
            :nameTo="vehicleFilters.actualKmsTo"
            idFrom="actualKmsFrom"
            idTo="actualKmsTo"
            :valueFrom="vehicleFilters.actualKmsFrom"
            :valueTo="vehicleFilters.actualKmsTo"
            mode="number"
            :min="0"
            :max="999999"
            label="Kms actuales"
            div-class="col-md-3 form-group"
            @updatedForm="vehicleFilters.actualKmsFrom = $event"
            @updatedTo="vehicleFilters.actualKmsTo = $event"
        />


        <!--  -->


        <!-- Fecha entrega desde/hasta -->
        <date-range-picker
            :nameFrom="vehicleFilters.deliveryDateFrom"
            :nameTo="vehicleFilters.deliveryDateTo"
            idFrom="deliveryDateFrom"
            idTo="deliveryDateTo"
            :valueFrom="vehicleFilters.deliveryDateFrom"
            :valueTo="vehicleFilters.deliveryDateTo"
            mode="date"
            :limitEndDay="vehicleFilters.deliveryDateTo"
            :label="txt.fields.deliveryDateFrom"
            div-class="col-md-3 form-group"
            @updatedForm="vehicleFilters.deliveryDateFrom = $event"
            @updatedTo="vehicleFilters.deliveryDateTo = $event"
        />
        <!--  -->

        <!-- Fecha recepción desde/hasta -->
        <date-range-picker
            :nameFrom="vehicleFilters.intDeliveryDateFrom"
            :nameTo="vehicleFilters.intDeliveryDateTo"
            idFrom="intDeliveryDateFrom"
            idTo="intDeliveryDateTo"
            :valueFrom="vehicleFilters.intDeliveryDateFrom"
            :valueTo="vehicleFilters.intDeliveryDateTo"
            mode="date"
            :limitEndDay="vehicleFilters.intDeliveryDateTo"
            :label="txt.fields.intDeliveryDateFrom"
            div-class="col-md-3 form-group"
            @updatedForm="vehicleFilters.intDeliveryDateFrom = $event"
            @updatedTo="vehicleFilters.intDeliveryDateTo = $event"
        />
        <!--  -->

        <!-- Fecha inicio alquiler desde/hasta -->
        <date-range-picker
            :nameFrom="vehicleFilters.firstRentDateFrom"
            :nameTo="vehicleFilters.firstRentDateTo"
            idFrom="firstRentDateFrom"
            idTo="firstRentDateTo"
            :valueFrom="vehicleFilters.firstRentDateFrom"
            :valueTo="vehicleFilters.firstRentDateTo"
            mode="date"
            :limitEndDay="vehicleFilters.firstRentDateTo"
            :label="txt.fields.firstRentDateFrom"
            div-class="col-md-3 form-group"
            @updatedForm="vehicleFilters.firstRentDateFrom = $event"
            @updatedTo="vehicleFilters.firstRentDateTo = $event"
        />
        <!--  -->

      <!-- Fecha fin alquiler desde/hasta -->
        <date-range-picker
            :nameFrom="vehicleFilters.rentingEndDateFrom"
            :nameTo="vehicleFilters.rentingEndDateTo"
            idFrom="rentingEndDateFrom"
            idTo="rentingEndDateTo"
            :valueFrom="vehicleFilters.rentingEndDateFrom"
            :valueTo="vehicleFilters.rentingEndDateTo"
            mode="date"
            :limitEndDay="vehicleFilters.rentingEndDateTo"
            :label="txt.fields.rentingEndDateFrom"
            div-class="col-md-3 form-group"
            @updatedForm="vehicleFilters.rentingEndDateFrom = $event"
            @updatedTo="vehicleFilters.rentingEndDateTo = $event"
        />
      <!--  -->

        <!-- Fecha salida instalaciones desde/hasta -->
        <date-range-picker
            :nameFrom="vehicleFilters.byeByeDateFrom"
            :nameTo="vehicleFilters.byeByeDateTo"
            idFrom="byeByeDateFrom"
            idTo="byeByeDateTo"
            :valueFrom="vehicleFilters.byeByeDateFrom"
            :valueTo="vehicleFilters.byeByeDateTo"
            mode="date"
            :limitEndDay="vehicleFilters.byeByeDateTo"
            :label="txt.fields.byeByeDateFrom"
            div-class="col-md-3 form-group"
            @updatedForm="vehicleFilters.byeByeDateFrom = $event"
            @updatedTo="vehicleFilters.byeByeDateTo = $event"
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
        <date-range-picker
            :nameFrom="vehicleFilters.returnDateFrom"
            :nameTo="vehicleFilters.returnDateTo"
            idFrom="returnDateFrom"
            idTo="returnDateTo"
            :valueFrom="vehicleFilters.returnDateFrom"
            :valueTo="vehicleFilters.returnDateTo"
            mode="date"
            :limitEndDay="vehicleFilters.returnDateTo"
            :label="txt.fields.returnDateFrom"
            div-class="col-md-3 form-group"
            @updatedForm="vehicleFilters.returnDateFrom = $event"
            @updatedTo="vehicleFilters.returnDateTo = $event"
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
        <date-range-picker
            :nameFrom="vehicleFilters.registrationDateFrom"
            :nameTo="vehicleFilters.registrationDateTo"
            idFrom="registrationDateFrom"
            idTo="registrationDateTo"
            :valueFrom="vehicleFilters.registrationDateFrom"
            :valueTo="vehicleFilters.registrationDateTo"
            mode="date"
            :limitEndDay="vehicleFilters.registrationDateTo"
            :label="txt.fields.registrationDateFrom"
            div-class="col-md-3 form-group"
            @updatedForm="vehicleFilters.registrationDateFrom = $event"
            @updatedTo="vehicleFilters.registrationDateTo = $event"
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

        <single-select-picker
            name="cleanVehicle"
            id="cleanVehicle"
            div-class="col-md-3 form-group"
            :label="txt.fields.cleanVehicle"
            :options="[
                { id: '', name: 'Todos' },
                { id: '1', name: 'Sí' },
                { id: '0', name: 'No' }
            ]"
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
import DateRangePicker from "../../../../SharedAssets/vue/components/base/inputs/DateRangePicker.vue";
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
        DateRangePicker,
    },
    data() {
        return {
            txt: {},
            selectList: {},
            vehicleFilters: {
                branchs: null,
                locations:null,
                actualKmsFrom: null,
                actualKmsTo: null,
                deliveryDateFrom: null,
                deliveryDateTo: null,
                intDeliveryDateFrom: null,
                intDeliveryDateTo: null,
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
                actualLoadDateFrom: null,
                actualLoadDateTo: null,
                actualUnloadDateFrom: null,
                actualUnloadDateTo: null,
                cleanVehicle: 'all',
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
