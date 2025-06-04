<template>
    <fragment>
        <div class="kt-portlet kt-portlet--bordered">
            <div class="kt-portlet__body">
                <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded">
                    <erp-ajax-table :url="routing.generate('location.filter.internal')" :columns="columns" :options="options" />
                </div>
            </div>
        </div>
        <internal-location-details-modal :location-data="location" />
    </fragment>
</template>

<script>
import Formatter from "../../../../SharedAssets/js/formatter";
import ErpAjaxTable from "../../../../SharedAssets/vue/components/table/ErpAjaxTable";
import InternalLocationDetailsModal from "../modals/InternalLocationDetailsModal";

export default {
    name: "InternalLocationList",
    components: {
        ErpAjaxTable,
        InternalLocationDetailsModal,
    },
    data() {
        return {
            columns: [
                {
                    field: "country",
                    title: txtTrans.fields.country,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "region",
                    title: txtTrans.fields.region,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "area",
                    title: txtTrans.fields.area,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "branch",
                    title: txtTrans.fields.branch,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "branchGroup",
                    title: txtTrans.fields.branchGroup,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "name",
                    title: txtTrans.fields.location,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    title: txtTrans.form.actions,
                    formatter: this.actionsFormatter,
                    events: {
                        "click .details": (e, value, row) => this.clickDetailsRow(row),
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
            transitions: {},
        };
    },
    methods: {
        actionsFormatter() {
            let actions = [
                ` <button class="btn btn-sm btn-clean btn-icon btn-icon-md details" title="${txtTrans.form.viewDetails}"><i class="flaticon-eye"></i></button>`,
            ];
            return actions.join("");
        },
        clickDetailsRow(row) {
            this.location = row;
            $("#internal-location-details-modal").modal("show");
        },
    },
};
</script>
<style scoped></style>
