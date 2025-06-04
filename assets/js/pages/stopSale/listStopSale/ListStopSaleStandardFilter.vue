<template>
    <erp-filter>
        <!-- Fecha inicio / fecha fin -->
        <erp-date-picker-filter
            @updatedDatePicker="stopSaleInitDate = $event"
            name="stopSaleInitDate"
            id="stopSaleInitDate"
            divClass="col-md-4 mb-3"
            :label="txt.fields.initDate"
            :limit-end-day="stopSaleEndDate"
        />
        <erp-date-picker-filter
            @updatedDatePicker="stopSaleEndDate = $event"
            name="stopSaleEndDate"
            id="stopSaleEndDate"
            divClass="col-md-4 mb-3"
            :label="txt.fields.endDate"
            :limit-start-day="stopSaleInitDate"
        />
        <!--  -->

        <!-- Department -->
        <erp-multiple-select-picker-filter
            name="departmentsId"
            id="departmentsId"
            divClass="col-md-4 mb-3"
            :label="txt.fields.department"
            :options="selectList.departmentList"
        />
        <!--  -->

        <!-- Fecha creación desde / fecha creación hasta -->
        <erp-date-picker-filter
            @updatedDatePicker="creationDateFrom = $event"
            name="creationDateFrom"
            id="creationDateFrom"
            divClass="col-md-4 mb-3"
            :label="txt.fields.creationDateFrom"
            :limit-end-day="creationDateTo"
            orientation="bottom left"
        />

        <erp-date-picker-filter
            @updatedDatePicker="creationDateTo = $event"
            name="creationDateTo"
            id="creationDateTo"
            divClass="col-md-4 mb-3"
            :label="txt.fields.creationDateTo"
            :limit-start-day="creationDateFrom"
            orientation="bottom left"
        />
        <!--  -->

        <!-- Stop Sale Type -->
        <erp-multiple-select-picker-filter
            name="stopSaleTypeId"
            id="stopSaleTypeId"
            divClass="col-md-4 mb-3"
            :label="txt.fields.stopSaleType"
            :options="stopSaleTypeList"
        />
        <!--  -->

        <!-- Car Group -->
        <erp-multiple-select-picker-filter
            @updatedMultipleSelectPicker="onChangeCarGroup($event)"
            name="carGroupsId"
            id="carGroupsId"
            divClass="col-md-4 mb-3"
            :label="txt.fields.carGroups"
            :options="selectList.carGroupList"
            :value="carGroupSelected"
        />
        <!--  -->

        <!-- ACRISS -->
        <erp-multiple-select-picker-filter
            @updatedMultipleSelectPicker="onChangeAcriss($event)"
            name="acrissId"
            id="acrissId"
            divClass="col-md-4 mb-3"
            :label="txt.fields.acriss"
            :options="selectList.acrissList"
            :value="acrissSelected"
        />
        <!--  -->

        <!-- Region -->
        <!-- <erp-multiple-select-picker-filter
            name="regionPickUpId"
            id="regionPickUpId"
            divClass="col-md-4 mb-3"
            :label="txt.fields.regions"
            :options="selectList.regionList"
        /> -->
        <!--  -->

        <!-- Area -->
        <!-- <erp-multiple-select-picker-filter
            name="areaPickUpId"
            id="areaPickUpId"
            divClass="col-md-4 mb-3"
            :label="txt.fields.areas"
            :options="selectList.areaList"
        /> -->
        <!--  -->
        <!-- Branch -->
        <erp-multiple-select-picker-filter
            name="branchesPickUpId"
            id="branchesPickUpId"
            divClass="col-md-4 mb-3"
            :label="txt.fields.branches"
            :options="selectList.branchList"
        />
        <!--  -->
        

        <!-- Partner -->
        <erp-multiple-select-picker-filter
            name="partnersId"
            id="partnersId"
            divClass="col-md-4 mb-3"
            :label="txt.fields.partners"
            :options="selectList.partnerList"
        />
        <!--  -->

        <!-- SellCode -->
        <erp-multiple-select-picker-filter
            name="sellCodesId"
            id="sellCodesId"
            divClass="col-md-4 mb-3"
            :label="txt.fields.sellCodes"
            :options="selectList.sellCodeList"
        />
        <!--  -->

        <!-- Product -->
        <erp-multiple-select-picker-filter
            name="productsId"
            id="productsId"
            divClass="col-md-4 mb-3"
            :label="txt.fields.products"
            :options="selectList.productList"
        />
        <!--  -->
        
        <!-- Status -->
        <erp-single-select-picker-filter
            name="stopSaleStatusId"
            id="stopSaleStatusId"
            divClass="col-md-4 mb-3"
            :label="txt.fields.status"
            :options="selectList.stopSaleStatusList"
        />
        <!--  -->

        <!-- Connected vehicle -->
        <erp-single-select-picker-filter
            name="connectedVehicle"
            id="connectedVehicle"
            divClass="col-md-4 mb-3"
            :label="txt.fields.connectedVehicle"
            :options="selectList.connectedVehicleList"
            :value="null"
            disabled
        />
        <!--  -->
    </erp-filter>
</template>

<script>
import ErpFilter from "../../../components/filter/ErpFilter";
// import ErpFilter from "../../../../SharedAssets/vue/components/filter/ErpFilter";
import ErpDatePickerFilter from "../../../../SharedAssets/vue/components/filter/form/ErpDatePickerFilter2";
import ErpMultipleSelectPickerFilter from "../../../../SharedAssets/vue/components/filter/form/ErpMultipleSelectPickerFilter";
import ErpSingleSelectPickerFilter from "../../../../SharedAssets/vue/components/filter/form/ErpSingleSelectPickerFilter";

export default {
    name: "ListStopSaleStandardFilter",
    components: {
        ErpFilter,
        ErpDatePickerFilter,
        ErpMultipleSelectPickerFilter,
        ErpSingleSelectPickerFilter,
    },
    props: {
        selectList: Object,
        stopSaleCategoryId: Number,
    },
    data() {
        return {
            txt: {},

            stopSaleTypeList: [],

            stopSaleInitDate: null,
            stopSaleEndDate: null,
            creationDateFrom: null,
            creationDateTo: null,
            acrissSelected: [],
            carGroupSelected: [],
        };
    },
    created() {
        this.txt = txtTrans;
    },
    mounted() {
        //No mostrar tipo CHECKIN_CHECKOUT
        this.stopSaleTypeList = this.selectList.stopSaleTypeList;
        this.stopSaleTypeList = this.stopSaleTypeList.filter((item) => item.id !== constants.type.checkin_checkout);
    },
    methods: {
        onChangeCarGroup(selection) {
            this.acrissSelected = this.selectList.acrissList
                .filter((acriss) => selection.includes(acriss.carGroupId))
                .map((acriss) => acriss.id);
        },
        onChangeAcriss(selection) {
            this.carGroupSelected = this.selectList.acrissList
                .filter((acriss) => selection.includes(acriss.id))
                .map((acriss) => acriss.carGroupId);
        },
    },
};
</script>

<style scoped></style>
