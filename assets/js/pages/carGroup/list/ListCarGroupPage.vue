<template>
    <div>
        <notifications  position="top center" width="80%" />
        <div class="kt-container">
            <div class="kt-portlet kt-portlet--bordered">
                <div class="kt-portlet__body">

                    <car-group-list-filter />

                    <div class="kt-align-right mb-2">
                        <button @click="createCarGroupPage" type="button" class="btn btn-dark kt-label-bg-color-4 mb-5">{{txt.createCarGroup}}</button>
                    </div>
                    <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded">
                        <erp-ajax-table id="dataTable" :url="routing.generate('cargroup.filter')" :columns="columns" :options="options"  />
                    </div>

                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import ErpAjaxTable from "../../../components/table/ErpAjaxTable";
    import CarGroupListFilter from "./CarGroupListFilter"

    export default {
        name: "ListCarGroupPage",
        components: {  ErpAjaxTable, CarGroupListFilter },
        data() {
            return {
                txt: {},
                columns: [
                    { field: 'name', title: txtTrans.txtList.carGroup, sortable: true },
                    { field: 'acrissName', title: txtTrans.txtList.acriss, sortable: true },
                    { field: 'status', title: txtTrans.txtList.status, sortable: true, formatter: this.formatterStatus },
                    {
                        title: 'Opciones',
                        formatter: this.actionsFormatter,
                        events: {
                            'click .show': (e, value, row) =>  this.clickShowRow(row),
                        },
                        width: 160
                    }
                ],
                options: {
                    pagination: true,
                    locale: 'es-ES',
                    scrollX: true
                },
            }
        },
        methods: {
            createCarGroupPage(){
                location.href = this.routing.generate('cargroup.create');
            },
            formatterStatus(value){

                if(value == true){
                    return this.txt.activate;
                }else if(value == false){
                    return this.txt.deactivate;
                }
            },
            formatterCommercialGroup(value){
                if(!Array.isArray(value)){
                    return '-';
                }else if(value.lengh===0){
                    return '-';
                }
                var response = '';
                for (let name of value) {
                    response+=name+", ";
                }
                return response.slice(0, -2);

            },
            actionsFormatter() {
                let actions = [
                    '<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md show" title="Show"><em class="flaticon-eye"></em></a>',
                ];
                return actions.join('');
            },
            clickShowRow(row){
                location.href = this.routing.generate('cargroup.show', {  id: row.id });
            }
        },
        mounted() {
            this.txt = txtTrans.txtList;
        }

    }
</script>

<style scoped>

</style>
