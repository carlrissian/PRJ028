<template>
    <div :class="containerClass">
        <div v-if="title != null" class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 :class="titleClass" v-text="title"></h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <slot name="action-buttons-head"></slot>

            <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded">
                <erp-ajax-table
                    @mostrar="$emit('onTableItemsLoaded', $event)"
                    @check="$emit('onTableCheck', $event)"
                    ref="vehiclesTable"
                    reference="table"
                    :url="routing.generate('movement.vehicleLine.assigned.filter', { movementId: movementId })"
                    :columns="cols"
                    :options="options"
                />
            </div>

            <div
                v-if="![null, undefined].includes(assignedLicensePlateUnits)"
                class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded"
            >
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th v-text="txt.fields.assignedLicensePlate"></th>
                            <th v-text="txt.fields.loadedLicensePlate"></th>
                            <th v-text="txt.fields.unloadedLicensePlate"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td v-text="assignedLicensePlateUnits.total"></td>
                            <td v-text="`${assignedLicensePlateUnits.load} / ${assignedLicensePlateUnits.total}`"></td>
                            <td v-text="`${assignedLicensePlateUnits.unload} / ${assignedLicensePlateUnits.total}`"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <slot name="action-buttons-foot"></slot>
        </div>
    </div>
</template>

<script>
import ErpAjaxTable from "../../../../SharedAssets/vue/components/table/ErpAjaxTable.vue";

export default {
    name: "MovementAssignedVehicles",
    components: {
        ErpAjaxTable,
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
        containerClass: {
            type: String,
            default: "kt-portlet kt-portlet--bordered",
        },
        tableId: {
            type: String,
            default: "assignedVehicles",
        },
        selectable: {
            type: Boolean,
            default: false,
        },
        columns: {
            type: Array,
            required: true,
        },
        checkValidation: {
            type: Function,
            default: undefined,
        },
    },
    data() {
        let cols = [];

        if (this.selectable) {
            cols.push({
                field: "checked",
                sortable: false,
                checkbox: true,
                // formatter: this.checkIsValidation,
            });

            if (this.checkValidation) cols[0].formatter = this.checkValidation;
        }
        cols.push(...this.columns);

        return {
            txt: txtTrans,
            cols,
            options: {
                pagination: true,
                locale: "es-ES",
                scrollX: true,
            },
        };
    },
    mounted() {
        this.eventBus.$on("refreshAssignedVehiclesTable", () => {
            this.$refs.vehiclesTable.$refs.table.refresh();
        });
    },
};
</script>

<style></style>
