<template>
    <erp-filter>
        <erp-date-picker-filter
                @updateDatePicker="changedPicker('startDate', 'endDate', $event)"
                name="stopSaleInitDate"
                id="stopSaleInitDate"
                :label="txt.stopSaleInitDate"
                :limit-end-day="dates.endDate"
        />
        <erp-date-picker-filter
                @updateDatePicker="changedPicker('startDate', 'endDate', $event)"
                name="stopSaleEndDate"
                id="stopSaleEndDate"
                :label="txt.stopSaleEndDate"
                :limit-start-day="dates.startDate"
        />

        <erp-multiple-select-filter :label="txt.regionPick" name="regionPickId" id="regionPickId" :data-for-ajax="regionList"/>
        <erp-multiple-select-filter :label="txt.areaPick" name="areaPickId" id="areaPickId" :data-for-ajax="areaList"/>
        <erp-multiple-select-filter :label="txt.branchPick" name="branchPickId" id="branchPickId" :data-for-ajax="branchList"/>

        <erp-multiple-select-filter :label="txt.regionDrop" name="regionDropId" id="regionDropId" :data-for-ajax="regionList"/>
        <erp-multiple-select-filter :label="txt.areaDrop" name="areaDropId" id="areaDropId" :data-for-ajax="areaList"/>
        <erp-multiple-select-filter :label="txt.branchDrop" name="branchDropId" id="branchDropId" :data-for-ajax="branchList"/>

        <erp-multiple-select-filter @changeSelectMultiple="onChangeCarGroup" :label="txt.carGroups" name="carGroupsId" id="carGroupsId" :data-for-ajax="carGroupList"/>
        <erp-multiple-select-filter @changeSelectMultiple="onChangeAcriss" :label="txt.acriss" name="acrissId" id="acrissId"
                                    :data-for-ajax="acrissList"/>

        <erp-select-filter name="connectedVehicle" id="connectedVehicle" :label="txt.connectedVehicle">
            <option v-for="item in connectedVehicleList" :key="item.id" :value="item.id" v-text="item.name"></option>
        </erp-select-filter>

        <erp-select-filter name="stopSaleStatusId" id="stopSaleStatusId" :label="txt.stopSaleStatus">
            <option v-for="item in stopSellStatusList" :key="item.id" :value="item.id" v-text="item.name"></option>
        </erp-select-filter>

        <erp-date-picker-filter
                @updateDatePicker="changedPicker('startDate', 'endDate', $event)"
                name="creationDateFrom"
                id="creationDateFromId"
                :label="txt.creationDateFrom"
                :start-date="startDate"
                :end-date="endDate"
        />
        <erp-date-picker-filter
                @updateDatePicker="changedPicker('startDate', 'endDate', $event)"
                name="creationDateTo"
                id="creationDateToId"
                :label="txt.creationDateTo"
                :start-date="startDate"
                :end-date="endDate"
        />

    </erp-filter>
</template>

<script>
    import ErpFilter from "../../../components/filter/ErpFilter";
    import ErpDatePickerFilter from "../../../components/filter/form/ErpDatePickerFilter";
    import ErpMultipleSelectFilter from "../../../components/filter/form/ErpMultipleSelectFilter";
    import ErpSelectFilter from "../../../components/filter/form/ErpSelectFilter";
    export default {
        name: "ListStopSaleOnewayFilter",
        components: {ErpSelectFilter, ErpMultipleSelectFilter, ErpDatePickerFilter, ErpFilter},
        props: {
            selectList: Object,
            stopSaleCategoryId: Number
        },
        data() {
            return {
                startDate: moment,
                endDate: moment,
                regionList: [],
                areaList: [],
                txt:{},
                branchList: [],
                acrissList: [],
                carGroupList: [],
                partnerList: [],
                connectedVehicleList:[],
                stopSellStatusList: [],
                stopSellTypeList: [],
                dates: {
                    endDate: null,
                    startDate: null
                }
            }
        },
        mounted() {
            this.regionList = this.selectList.regionList;
            this.areaList = this.selectList.areaList;
            this.branchList = this.selectList.branchList;
            this.acrissList = this.selectList.acrissList;
            this.carGroupList = this.selectList.carGroupList;
            this.partnerList = this.selectList.partnerList;
            this.stopSellStatusList = this.selectList.stopSaleStatusList;
            this.stopSellTypeList = this.selectList.stopSaleTypeList;
            this.connectedVehicleList = this.selectList.connectedVehicleList;
            this.txt = txtTrans.txtForm;

            // this.dates.startDate = moment(new Date(), "DD/MM/YYYY").format("DD/MM/YYYY");
        },
        methods: {
            onChangeCarGroup(){
                this.carGroupSelected=$("#carGroupsId").val();
                this.acrissSelected = [];

                for (let acriss of this.acrissList) {
                    if(!acriss.carGroupId){
                        continue;
                    }
                    if(this.carGroupSelected.includes(acriss.carGroupId.toString())){
                        this.acrissSelected.push(acriss.id);
                    }
                }
                $('#acrissId').val(this.acrissSelected);
                $('#acrissId').selectpicker("refresh");

            },
            onChangeAcriss(){

                this.acrissSelected = $("#acrissId").val();
                this.carGroupSelected = [];

                for (let acriss of this.acrissList) {
                    if(!acriss.carGroupId){
                        continue;
                    }
                    if(this.acrissSelected.includes(acriss.id.toString())){
                        this.carGroupSelected.push(acriss.carGroupId.toString());
                    }
                }

                $('#carGroupsId').val(this.carGroupSelected);
                $('#carGroupsId').selectpicker("refresh");

            },
            changedPicker(dateFrom, dateTo, e) {
                let {name, value} = e.target;
                if (value) {
                    switch (name) {
                        case dateTo:
                            this.dates[dateTo] = value;
                            break;
                        case dateFrom:
                            this.dates[dateFrom] = value;
                            break;
                    }
                } else {
                    if (name === dateTo) {
                        this.dates[dateTo] = null;
                    }
                }
            },
        }
    }
</script>

<style scoped>

</style>