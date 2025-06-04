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
    name: "MovementOperationAssignedVehicles",
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
            columns: [
                {
                    field: "licensePlate",
                    title: txtTrans.fields.licensePlate,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
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
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "model",
                    title: txtTrans.fields.model,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "carGroup",
                    title: txtTrans.fields.carGroup,
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
                    field: "rentingEndDate",
                    title: txtTrans.fields.rentingEndDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "saleMethod",
                    title: txtTrans.fields.saleMethod,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "connectedVehicle",
                    title: txtTrans.fields.connectedVehicle,
                    sortable: true,
                    formatter: (value) => {
                        let formattedValue = Formatter.formatBoolean(value);
                        return formattedValue != "-" ? txtTrans.form[formattedValue] : formattedValue;
                    },
                },
                {
                    field: "vehicleStatus",
                    title: txtTrans.fields.vehicleStatus,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "checkInDueDate",
                    title: txtTrans.fields.checkInDueDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "actualLoadDate",
                    title: txtTrans.fields.actualLoadDate,
                    sortable: true,
                    // formatter: (value) => Formatter.formatField(value),
                    formatter: this.formatterDate,
                },
                {
                    field: "actualUnloadDate",
                    title: txtTrans.fields.actualUnloadDate,
                    sortable: true,
                    // formatter: (value) => Formatter.formatField(value),
                    formatter: this.formatterDate,
                },
                {
                    field: "initBlockDate",
                    title: txtTrans.fields.initBlockDate,
                    sortable: true,
                    // formatter: (value) => Formatter.formatField(value),
                    formatter: this.formatterDate,
                },
                {
                    field: "endBlockDate",
                    title: txtTrans.fields.endBlockDate,
                    sortable: true,
                    // formatter: (value) => Formatter.formatField(value),
                    formatter: this.formatterDate,
                },
                {
                    field: "vehicleMaintenanceEndDate",
                    title: txtTrans.fields.maintenanceExpectedEndDate,
                    sortable: true,
                    // formatter: (value) => Formatter.formatField(value),
                    formatter: this.formatterDate,
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
        formatterDate(date) {
            return ![null, undefined].includes(date) ? moment(date, "DD/MM/YYYY").format("DD/MM/YYYY") : "-";
        },
    },
};
</script>

<style></style>
