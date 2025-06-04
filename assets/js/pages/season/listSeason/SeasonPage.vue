<template>
    <div>
        <season-filter :locations="locations" :car-groups="carGroups"/>
        <div class="kt-portlet kt-portlet--bordered">
            <div class="kt-portlet__body">
                <div class="kt-align-right">
                    <button type="button" id="btn-add" class="btn btn-dark kt-label-bg-color-4" @click="clickCreateSeason">
                        {{ translations.add }} </button>
                </div>
                <br>
                <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded" id="local_data" style="">
                    <erp-ajax-table :columns="columns" :options="options" :url="routing.generate('SeasonGet')" />
                </div>
            </div>
            <season-delete-modal :id="itemId" />
            <season-edit-modal :row="itemRow" :locations="locations" :car-groups="carGroups"/>
            <season-create-modal :locations="locations" :car-groups="carGroups"/>
        </div>
    </div>
</template>

<script>
    import ErpModal from "../../../components/modal/ErpModal";
    import SeasonFilter from "./SeasonFilter";
    import SeasonDeleteModal from "../Modals/SeasonDeleteModal";
    import SeasonEditModal from "../Modals/SeasonEditModal";
    import ErpAjaxTable from "../../../components/table/ErpAjaxTable";
    import SeasonCreateModal from "../Modals/SeasonCreateModal";

    export default {
        name: "SeasonPage",
        components: {SeasonCreateModal, ErpAjaxTable, SeasonEditModal, SeasonFilter, ErpModal, SeasonDeleteModal},
        props:{
            locations: Array,
            carGroups: Array
        },
        data () {
            let txt = txtTrans.txtPage;
            return {
                translations: {},
                itemId: 0,
                itemRow: null,
                fields: {},
                columns: [
                    { field: 'location', title: txt.location, sortable: true, formatter: this.format },
                    { field: 'startDate', title: txt.startDate, sortable: true, formatter: this.dateFormat},
                    { field: 'endDate', title: txt.endDate, sortable: true, formatter: this.dateFormat },
                    { field: 'carGroupsId', title: txt.groups, sortable: true, formatter: this.format  },
                    {
                        title: 'Acciones',
                        formatter: this.seasonFormatter,
                        events: {
                            'click .edit': (e, value, row) =>  this.clickEditRow(row),
                        }
                    }
                ],
                options: {
                    pagination: true,
                    locale: 'es-ES',
                }
            }
        },
        mounted() {
            this.translations = txtTrans.txtSeason;
        },
        methods: {
            seasonFormatter() {
                return [
                    '<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md edit" title="Editar"><i class="flaticon2-edit"></i></a>',
                ].join('');
            },
            clickCreateSeason(row) {
                $('#modal-confirm-create').modal('show');
            },
            clickEditRow(row) {
                row.startDate = this.dateFormat(row.startDate);
                row.endDate = this.dateFormat(row.endDate);
                row.location = row.location['id'];
                this.itemRow = row;
                $('#modal-confirm-edit').modal('show');
            },
            clickDeleteRow(row){
                this.itemId = row.id;
                $('#modal-confirm-delete').modal('show');
            },
            dateFormat(value, row, index) {
                return moment(value, "DD/MM/YYYY").format("DD/MM/YYYY");
            },
            format(value, row, index) {
                if (Array.isArray(value)) {
                    let names = value.map(val => {
                        return val.name;
                    })
                    return names.join(', ')
                } else {
                    return value.name
                }
            }
        },
    }
</script>

<style scoped>

</style>