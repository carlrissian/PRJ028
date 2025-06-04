<template>
    <fragment>
        <supplier-list-filter />
        <div class="kt-portlet kt-portlet--bordered">
            <div class="kt-portlet__body">
                <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded" id="local_data">
                    <erp-ajax-table :columns="columns" :options="options" :url="routing.generate('supplier.filter')" />
                </div>
            </div>
        </div>

        <supplier-contacts-modal :code="id" />
    </fragment>
</template>

<script>
import SupplierListFilter from "./SupplierListFilter";
import ErpAjaxTable from "../../components/table/ErpAjaxTable";
import SupplierContactsModal from "./SupplierContactsModal";

export default {
    name: "SupplierListPage",
    components: {
        ErpAjaxTable,
        SupplierListFilter,
        SupplierContactsModal,
    },
    data() {
        let translations = txtTrans;

        return {
            columns: [
                {
                    field: "id",
                    title: translations.fields.code,
                    sortable: true
                },
                {
                    field: "name",
                    title: translations.fields.name,
                    sortable: true
                },
                {
                    field: "vatNumber",
                    title: translations.fields.cif,
                    sortable: true
                },
                {
                    field: "state",
                    title: translations.fields.state,
                    sortable: true,
                    formatter: (value) => value?.name,
                },
                {
                    field: "city",
                    title: translations.fields.city,
                    sortable: true
                },
                {
                    title: translations.form.actions,
                    formatter: this.actionsFormatter,
                    events: {
                        "click .contacts": (e, value, row) =>
                            this.viewContacts(row),
                    },
                },
            ],
            options: {
                pagination: true,
                locale: "es-ES",
            },
            id: Number,
            code: String,
            showModal: false,
        };
    },
    methods: {
        actionsFormatter() {
            return ` <button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md contacts" data-toggle="modal" data-target="#supplier-contacts-modal" title="${txtTrans.form.consult}"><i class="flaticon-info"></i></button>`;
        },
        viewContacts(row) {
            this.id = row.id;
            // $("#supplier-contacts-modal").modal("show");
        },
    },
};
</script>

<style scoped>
.kt-portlet /deep/ .fixed-table-container {
    padding-bottom: 0px;
    width: 100%;
    height: 55vh;
}

.kt-portlet /deep/ thead tr {
    background: white;
    position: sticky;
    top: 0;
}

#dataTable /deep/ tr td a {
    display: table-cell;
    padding-right: 5px;
}
</style>
