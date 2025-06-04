<template>
    <fragment>
        <div class="kt-portlet kt-portlet--bordered">
            <div class="kt-portlet__body">
                <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded">
                    <erp-ajax-table :url="routing.generate('location.filter.external')" :columns="columns" :options="options" />
                </div>
            </div>
        </div>

        <external-location-details-modal :location-data="location" />
    </fragment>
</template>

<script>
import Formatter from "../../../../SharedAssets/js/formatter";
import ErpAjaxTable from "../../../../SharedAssets/vue/components/table/ErpAjaxTable";
import ExternalLocationDetailsModal from "../modals/ExternalLocationDetailsModal";

export default {
    name: "ExternalLocationList",
    components: {
        ErpAjaxTable,
        ExternalLocationDetailsModal,
    },
    data() {
        return {
            columns: [
                {
                    field: "provider.code",
                    title: txtTrans.fields.providerCode,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "provider",
                    title: txtTrans.fields.name,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "id",
                    title: txtTrans.fields.locationCode,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "name",
                    title: txtTrans.fields.locationName,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "country",
                    title: txtTrans.fields.country,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "state",
                    title: txtTrans.fields.state,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "city",
                    title: txtTrans.fields.city,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    title: txtTrans.form.actions,
                    formatter: this.actionsFormatter,
                    events: {
                        "click .eye": (e, value, row) => this.clickDetailsRow(row),
                    },
                    width: 100,
                },
            ],
            options: {
                pagination: true,
                locale: "es-ES",
                scrollX: true,
                scrollY: true,
                // showColumns: true,
            },
            location: null,
        };
    },
    methods: {
        actionsFormatter(value, row) {
            let actions = [
                '<a href="javascript:void(0)" style="display:inline" class="btn btn-sm btn-clean btn-icon btn-icon-md eye" title="Details"><i class="flaticon-eye"></i></a>',
            ];
            return actions.join("");
        },
        async clickDetailsRow(row) {
            this.location = row;
            $("#external-location-details-modal").modal("show");
        },
    },
};
</script>

<style scoped></style>
