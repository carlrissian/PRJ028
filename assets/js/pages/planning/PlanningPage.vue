<template>
    <div>
        <div class="kt-portlet kt-portlet--bordered">
            <div class="kt-portlet__body">
                <list-planning-filter  @request="getRequestTable" :select-list="selectList" v-if="showFilter"/>
                <div class="col-12 text-center btn-content">
                        <erp-year-filter class-number="col-md-6" :label="txt.year" :title="txt.year" name="year"  id="year" format="yyyy"  @updateDatePicker="changeSelect"/>
                        <button type="button"
                                :class="monthSelected === item.id ? 'btn btn-months btn-outline-primary' : 'btn btn-months btn-outline-secondary'"
                                v-for="(item, index) in months" v-text="item.name"
                                @click="changeMonth(item.id)"/>
                </div>
            </div>
        </div>
        <table-planning v-if="planning" :data-table="this.planning"
                         :orPlan="orPlan"
                         :select-list="selectList"
                         :month="this.monthSelected"
                         :show-table="showTable" />
    </div>
</template>

<script>
    import ErpAjaxTable from "../../components/table/ErpAjaxTable";
    import ErpYearFilter from "../../components/filter/form/ErpYearFilter";
    import ErpSelectFilterBasic from "../../components/filterStatic/form/ErpSelectFilterBasic";
    import TablePlanning from "./TablePlanning";
    import ListPlanningFilter from "./ListPlanningFilter";
    import Loading from "../../../assets/js/utilities";
    import Axios from "axios";

    export default {
        name: "PlanningPage",
        components: { ListPlanningFilter, TablePlanning,ErpAjaxTable,ErpSelectFilterBasic,ErpYearFilter},
        props:{
            selectList: Object
        },
        data() {
            return {
                planning: Object,
                showTable: false,
                txt: {},
                monthSelected: 0,
                months: null,
                orPlan: Object,
                showFilter: false
            }
        },
        mounted() {
            this.monthSelected = 1;//dejamos marcado enero
            this.year=0;
            this.txt = txtTrans.txtForm;
            this.months = this.selectList.monthList;
        },
        methods: {
            changeSelect(e){
                let year = e.target.value;
                if(year!=''){
                    this.getDataTable(year,this.monthSelected);//pasamos año y mes
                    this.showFilter = true;
                }
            },
            getRequestTable(ok) {
                this.$emit('request', ok);
                this.getDataTable(document.getElementById('year').value,this.monthSelected);//pasamos año y mes
            },
            async getDataTable(year,month) {
                this.showTable = false;

                try {
                    Loading.starLoading();
                    let objs = this.$store.getters['filter/items'];
                    let keys = Object.keys(objs);
                    let brandId,modelId,purchaseMethodId,purchaseTypeId,gearBoxId,motorizationTypeId,acrissId = '';
                    let carGroupId,commercialGroupId,carClassId,connectedVehicleId, pendingAssignmentsId, fleetPlannerStatusId = ''

                    if (keys.length > 0) {
                        for (let key of keys) {
                            if( key =='brandId'){ brandId = objs[key]; }
                            if( key =='modelId'){ modelId = objs[key]; }
                            if( key =='purchaseMethodId'){ purchaseMethodId = objs[key]; }
                            if( key =='purchaseTypeId'){ purchaseTypeId = objs[key]; }
                            if( key =='gearBoxId'){ gearBoxId = objs[keys[i]]; }
                            if( key =='motorizationTypeId'){ motorizationTypeId = objs[key]; }
                            if( key =='acrissId'){ acrissId = objs[key]; }
                            if( key =='carGroupId'){ carGroupId = objs[key]; }
                            if( key =='carClassId'){ carClassId = objs[key]; }
                            if( key =='commercialGroupId'){ commercialGroupId = objs[key]; }
                            if( key =='connectedVehicleId'){ connectedVehicleId = objs[key]; }
                            if( key =='pendingAssignmentsId'){ pendingAssignmentsId = objs[key]; }
                            if( key =='fleetPlannerStatusId'){ fleetPlannerStatusId = objs[key]; }
                        }
                    }

                    let resp = await Axios.post(this.routing.generate('planning.filter',
                        {
                            year: year ,
                            month: month ,
                            brandId: brandId,
                            modelId: modelId,
                            purchaseMethodId: purchaseMethodId,
                            purchaseTypeId: purchaseTypeId,
                            gearBoxId: gearBoxId,
                            motorizationTypeId: motorizationTypeId,
                            acrissId: acrissId,
                            carGroupId: carGroupId,
                            commercialGroupId: commercialGroupId,
                            carClassId: carClassId,
                            connectedVehicleId: connectedVehicleId,
                            pendingAssignmentsId: pendingAssignmentsId,
                            fleetPlannerStatusId: fleetPlannerStatusId
                        }));

                    console.log(resp.data);

                    this.planning = resp.data.planning;
                    this.orPlan = resp.data.orPlan;
                    this.showTable = resp.data.total > 0;
                    Loading.endLoading();

                } catch (e) {
                    Loading.endLoading();
                    console.log(e);
                }
            },
            changeMonth(month) {
                let year =  $('#year').val();
                if(confirm(this.txt.titleMonth)) {
                    if (month !== this.monthSelected) {
                        this.monthSelected = month;
                        this.getDataTable(year,month);
                    }
                }
            }
        }
    }
</script>

<style>

</style>
