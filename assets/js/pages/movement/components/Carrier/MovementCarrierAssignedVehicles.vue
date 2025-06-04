<template>
    <movement-assigned-vehicles
        @onTableCheck="$emit('onTableCheck', $event)"
        ref="movementAssignedVehicles"
        :movement-id="movementId"
        :assigned-license-plate-units="assignedLicensePlateUnits"
        :title="title"
        :title-class="titleClass"
        :columns="columns"
        :selectable="selectable"
    >
        <template #action-buttons-head>
            <slot name="action-buttons-head"></slot>
        </template>
        <template #action-buttons-foot>
            <slot name="action-buttons-foot"></slot>
        </template>
    </movement-assigned-vehicles>
</template>

<script>
import Formatter from "../../../../../SharedAssets/js/formatter";

import MovementAssignedVehicles from "../MovementAssignedVehicles.vue";

export default {
    name: "MovementCarrierAssignedVehicles",
    components: {
        MovementAssignedVehicles,
    },
    props: {
        movementId: Number,
        assignedLicensePlateUnits: {
            type: Object,
            default: null,
        },
        title: {
            type: String,
            default: null,
        },
        titleClass: {
            type: String,
            default: "kt-portlet__head-title",
        },
        selectable: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            txt: txtTrans,
            columns: [
                {
                    field: "licensePlate",
                    title: txtTrans.fields.licensePlate,
                    sortable: true,
                    // formatter: (value) => Formatter.formatField(value),
                    formatter: this.formatterFilters,
                },
                {
                    field: "vin",
                    title: txtTrans.fields.vin,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "brand",
                    title: txtTrans.fields.brand,
                    sortable: true,
                    // formatter: (value) => Formatter.formatField(value),
                    formatter: this.formatterFilters,
                },
                {
                    field: "model",
                    title: txtTrans.fields.model,
                    sortable: true,
                    // formatter: (value) => Formatter.formatField(value),
                    formatter: this.formatterFilters,
                },
                {
                    field: "carGroup",
                    title: txtTrans.fields.carGroup,
                    sortable: true,
                    // formatter: (value) => Formatter.formatField(value),
                    formatter: this.formatterFilters,
                },
                {
                    field: "kilometers",
                    title: txtTrans.fields.kilometers,
                    sortable: true,
                    // formatter: (value) => Formatter.formatField(value),
                    formatter: this.formatterFilters,
                },
                {
                    field: "rentingEndDate",
                    title: txtTrans.fields.rentingEndDate,
                    sortable: true,
                    // formatter: (value) => Formatter.formatField(value),
                    formatter: this.formatterFilters,
                },
                {
                    field: "saleMethod",
                    title: txtTrans.fields.saleMethod,
                    sortable: true,
                    // formatter: (value) => Formatter.formatField(value),
                    formatter: this.formatterFilters,
                },
                {
                    field: "connectedVehicle",
                    title: txtTrans.fields.connectedVehicle,
                    sortable: true,
                    formatter: this.formatterFilterConnectedVehicle,
                },
                {
                    field: "vehicleStatus",
                    title: txtTrans.fields.vehicleStatus,
                    sortable: true,
                    // formatter: (value) => Formatter.formatField(value),
                    formatter: this.formatterFilters,
                },
                {
                    field: "checkInDueDate",
                    title: txtTrans.fields.checkInDueDate,
                    sortable: true,
                    // formatter: (value) => Formatter.formatField(value),
                    formatter: this.formatterFilters,
                },
                {
                    field: "actualLoadDate",
                    title: txtTrans.fields.actualLoadDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "actualUnloadDate",
                    title: txtTrans.fields.actualUnloadDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "initBlockDate",
                    title: txtTrans.fields.initBlockDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "endBlockDate",
                    title: txtTrans.fields.endBlockDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "vehicleMaintenanceEndDate",
                    title: txtTrans.fields.maintenanceExpectedEndDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
            ],
            options: {
                pagination: true,
                locale: "es-ES",
                scrollX: true,
            },
        };
    },
    methods: {
        formatterFilters(value, row) {
            let color = ["", null, undefined].includes(row.actualLoadDate) && value?.error ? "red" : "black";
            return `<b style="color:${color}">${Formatter.formatField(value)}</b>`;
        },
        formatterFilterConnectedVehicle(value, row) {
            let formattedValue = Formatter.formatBoolean(value);
            let color = ["", null, undefined].includes(row.actualLoadDate) && value?.error ? "red" : "black";
            return `<b style="color:${color}">${formattedValue != "-" ? txtTrans.form[formattedValue] : formattedValue}</b>`;
        },
    },
};
</script>

<style></style>
