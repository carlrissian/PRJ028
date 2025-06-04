<template>
    <div>
        <notifications  position="top center" width="80%" />
        <div class="kt-container">
            <div class="kt-portlet kt-portlet--bordered">
                <div class="kt-portlet__body">
                    <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded">
                        <erp-ajax-table id="dataTable" :url="routing.generate('acriss.associate.filter')" :columns="columns" :options="options"  />
                    </div>

                </div>
            </div>
            <associate-fleet-classification-modal :row="rowAssociate"/>
            <cancel-associate-fleet-classification-modal :row="rowCancel" />
        </div>
    </div>
</template>

<script>
    import ErpAjaxTable from "../../../components/table/ErpAjaxTable";
    import AssociateFleetClassificationModal from "./modal/AssociateFleetClassificationModal";
    import CancelAssociateFleetClassificationModal from "./modal/CancelAssociateFleetClassificationModal";

    export default {
        name: "AssociateFleetClassificationPage",
        components: {  AssociateFleetClassificationModal, CancelAssociateFleetClassificationModal, ErpAjaxTable },
        data() {
            return {
                txt: {},
                columns: [
                    { field: 'acrissName', title: txtTrans.txtAssociate.acrissParent, sortable: true, formatter: this.formatter },
                    { field: 'acrissChildList', title: txtTrans.txtAssociate.acrissChild, sortable: true, formatter: this.formatterChild },
                    {
                        title: 'Opciones',
                        formatter: this.actionsFormatter,
                        events: {
                            'click .associate': (e, value, row) =>  this.clickAssociateRow(row),
                            'click .cancel': (e, value, row) => this.clickCancelRow(row),
                        },
                        width: 160
                    }
                ],
                options: {
                    pagination: true,
                    locale: 'es-ES',
                    scrollX: true
                },
                rowAssociate: {},
                rowCancel: {},
            }
        },
        methods: {
            formatter(value){
                if(!value){
                    return '-';
                }else{
                    return value;
                }
            },
            formatterChild(value){
                if(value.length === 0){
                    return '-';
                }else{
                    let name = '';
                    for(let i = 0; i < value.length; i++){
                        name += value[i].name+ ", ";
                    }
                    name= name.slice(0, -2);
                    return name;
                }
            },
            actionsFormatter(value, row) {
                if(!row.acrissChildList || row.acrissChildList.length===0){
                    return '';
                }
                let actions = [
                    '<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md associate" title="Asociar"><em class="flaticon-edit"></em></a>',
                    '<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md cancel" title="Cancelar asociación"><em class="flaticon-cancel"></em></a>'
                ];

                return actions.join('');
            },
            clickAssociateRow(row){
                this.rowAssociate = row;
                $('#associateFleetClassificationModal').modal('show');
            },
            clickCancelRow(row){
                this.rowCancel = row;
                $('#cancelAssociateFleetClassificationModal').modal('show');
            }
        },
        mounted() {
            this.txt = txtTrans.txtList;
        }
    }
</script>

<style scoped>

</style>
