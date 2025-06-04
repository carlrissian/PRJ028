<template>
    <fragment>
        <vehicle-history-tab-filter />

        <erp-ajax-table
            :url="routing.generate('vehicle.history.filter')"
            :columns="columns"
            :options="options"
            :parameter-default="{ vehicleId: vehicle.id }"
        />

        <!-- <vehicle-history-modal
            :row="this.detailsData"
            :license-plate="vehicle.licensePlate"
        ></vehicle-history-modal> -->
    </fragment>
</template>

<script>
import Formatter from "../../../../../SharedAssets/js/formatter";
import ErpAjaxTable from "../../../../../SharedAssets/vue/components/table/ErpAjaxTable.vue";
import VehicleHistoryTabFilter from "./VehicleHistoryTabFilter.vue";
// import VehicleHistoryModal from "./VehicleHistoryModal.vue";

export default {
    name: "VehicleHistoryTab",
    components: {
        ErpAjaxTable,
        VehicleHistoryTabFilter,
        // VehicleHistoryModal,
    },
    props: {
        vehicle: Object,
    },
    data() {
        return {
            columns: [
                {
                    field: "originStatus",
                    title: txtTrans.fields.originStatus,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "endStatus",
                    title: txtTrans.fields.endStatus,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "location",
                    title: txtTrans.fields.location,
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
                    field: "kilometers",
                    title: txtTrans.fields.kilometers,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "statusChangeDate",
                    title: txtTrans.fields.statusChangeDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDateTime(value),
                },
                {
                    field: "statusChangeUser",
                    title: txtTrans.fields.statusChangeUser,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                // {
                //     title: txtTrans.fields.actions,
                //     formatter: this.actionsFormatter,
                //     events: {
                //         "click .details": (e, value, row) =>
                //             this.openModal(row),
                //     },
                //     width: 160,
                // },
            ],
            options: {
                pagination: true,
                pageSize: 30,
                locale: "es-ES",
                scrollX: true,
            },

            detailsData: {},
        };
    },
    methods: {
        actionsFormatter() {
            return `<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md details" data-toggle="modal" data-target="#vehicle-history-modal" title="${txtTrans.form.viewDetails}"><i class="flaticon-eye"></i></button>`;
        },
        openModal(row) {
            this.detailsData = row;
            $("#vehicle-history-modal").modal("show");
        },
    },
};
</script>

<style scoped></style>
