<template>
    <erp-filter-planning  @items="getItemsTable">
        <erp-multiple-select-filter :label="txt.brand" name="brandId" id="brandId" :data-for-ajax="brandList"/>
        <erp-multiple-select-filter :label="txt.model" name="modelId" id="modelId" :data-for-ajax="modelList"/>
        <erp-multiple-select-filter :label="txt.purchaseMethod" name="purchaseMethodId" id="purchaseMethodId" :data-for-ajax="purchaseMethodList"/>
        <erp-multiple-select-filter :label="txt.purchaseType" name="purchaseTypeId" id="purchaseTypeId" :data-for-ajax="purchaseTypeList"/>
        <erp-multiple-select-filter :label="txt.gearBox" name="gearBoxId" id="gearBoxId" :data-for-ajax="gearBoxList"/>
        <erp-multiple-select-filter :label="txt.motorizationType" name="motorizationTypeId" id="motorizationTypeId" :data-for-ajax="motorizationTypeList"/>
        <erp-multiple-select-filter :label="txt.acriss" name="acrissId" id="acrissId" :data-for-ajax="acrissList"/>
        <erp-multiple-select-filter :label="txt.carGroup" name="carGroupId" id="carGroupId" :data-for-ajax="carGroupList"/>
        <erp-multiple-select-filter :label="txt.carClass" name="carClassId" id="carClassId" :data-for-ajax="carClassList"/>
        <erp-multiple-select-filter :label="txt.commercialGroup" name="commercialGroupId" id="commercialGroupId" :data-for-ajax="commercialGroupList"/>
        <erp-multiple-select-filter :label="txt.connectedVehicle" name="connectedVehicleId" id="connectedVehicleId" :data-for-ajax="connectedVehicleList"/>
        <erp-multiple-select-filter :label="txt.pendingAssignments" name="pendingAssignmentsId" id="pendingAssignmentsId" :data-for-ajax="pendingAssignmentsList"/>
        <erp-multiple-select-filter :label="txt.fleetPlannerStatus" name="fleetPlannerStatusId" id="fleetPlannerStatusId" :data-for-ajax="fleetPlannerStatusList"/>
    </erp-filter-planning>
</template>

<script>
    import ErpFilterPlanning from "../../components/filter/ErpFilterPlanning";
    import ErpMultipleSelectFilter from "../../components/filter/form/ErpMultipleSelectFilter";
    export default {
        name: "ListPlanningFilter",
        components: {ErpFilterPlanning, ErpMultipleSelectFilter},
        props: {
            selectList: Object,
        },
        data() {
            return {
                txt: {},
                brandList: null,
                branchList: null,
                modelList: null,
                purchaseMethodList: null,
                purchaseTypeList: null,
                gearBoxList: null,
                motorizationTypeList: null,
                acrissList: null,
                carGroupList: null,
                commercialGroupList: null,
                carClassList: null,
                connectedVehicleList: null,
                pendingAssignmentsList: null,
                fleetPlannerStatusList: null
            }
        },
        methods: {
            getItemsTable(ok) {
                this.$emit('request', ok);
            },
        },
        mounted() {
            this.txt = txtTrans.txtForm;
            this.brandList = this.selectList.brandList;
            this.branchList = this.selectList.branchList;
            this.modelList = this.selectList.modelList;
            this.purchaseMethodList = this.selectList.purchaseMethodList;
            this.purchaseTypeList = this.selectList.purchaseTypeList;
            this.gearBoxList = this.selectList.gearBoxList;
            this.motorizationTypeList = this.selectList.motorizationTypeList;
            this.acrissList = this.selectList.acrissList;
            this.carGroupList = this.selectList.carGroupList;
            this.commercialGroupList = this.selectList.commercialGroupList;
            this.carClassList = this.selectList.carClassList;
            this.connectedVehicleList = this.selectList.connectedVehicleList;
            this.pendingAssignmentsList = this.selectList.pendingAssignmentsList;
            this.connectedVehicleList = this.selectList.connectedVehicleList;
            this.fleetPlannerStatusList = this.selectList.fleetPlannerStatusList;
        }
    }
</script>

<style scoped>

</style>
