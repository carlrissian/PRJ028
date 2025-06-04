<template>
    <movement-assigned-vehicles
        v-if="movementId"
        @onTableItemsLoaded="
            itemsLoaded = true;
            vehiclesTotal = $event;
        "
        @onTableCheck="check($event)"
        ref="assignedVehicles"
        id="tableLoad"
        :movement-id="movementId"
        :columns="columns"
        containerClass=""
        selectable
        :check-validation="checkIsLoaded"
    >
        <template #action-buttons-foot>
            <div v-show="itemsLoaded" id="info" class="mt-3">
                <p v-text="`${txt.form.selectedTotal}: ${vehiclesSelected} ${txt.form.of} ${vehiclesTotal}`"></p>
                <p v-text="`${txt.form.loadedTotal}: ${vehiclesLoaded} ${txt.form.of} ${vehiclesTotal}`"></p>
            </div>

            <date-picker
                @updatedDatePicker="actualLoadDate = $event"
                ref="actualLoadDate"
                name="actualLoadDate"
                id="actualLoadDateId"
                divClass="row col-md-3 my-5"
                :label="txt.fields.actualLoadDate"
                :placeholder="txt.form.selectDate"
                :value="actualLoadDate"
                :limit-end-day="new Date()"
                required
            />

            <button
                @click.prevent="validateLoads"
                class="btn btn-dark kt-label-bg-color-4"
                v-text="txt.titles.loadValidation"
            ></button>
            <!-- :disabled="!isVehicleChecked" -->
        </template>
    </movement-assigned-vehicles>
</template>

<script>
import Formatter from "../../../../../../SharedAssets/js/formatter";
import DatePicker from "../../../../../../SharedAssets/vue/components/base/inputs/DatePicker";

import MovementAssignedVehicles from "../../MovementAssignedVehicles.vue";

export default {
    components: {
        DatePicker,
        MovementAssignedVehicles,
    },
    name: "TableLoad",
    props: {
        movementId: {
            type: Number,
            default: null,
        },
    },
    data() {
        return {
            txt: {},
            items: [],
            itemsLoaded: false,
            vehiclesLoaded: 0,
            vehiclesTotal: 0,
            // actualLoadDate: moment(new Date(), "DD/MM/YYYY").format("DD/MM/YYYY"),
            actualLoadDate: new Intl.DateTimeFormat("en-GB").format(new Date(Date.now())),
            columns: [
                {
                    field: "licensePlate",
                    title: txtTrans.fields.licensePlate,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                    cellStyle: this.hasBeenLoaded,
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
                    field: "vehicleStatus",
                    title: txtTrans.fields.vehicleStatus,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "rentingEndDate",
                    title: txtTrans.fields.rentingEndDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(Formatter.formatField(value)),
                },
                {
                    field: "actualLoadDate",
                    title: txtTrans.fields.actualLoadDate,
                    sortable: true,
                    formatter: (value) => {
                        if (!["", null, undefined].includes(value)) this.vehiclesLoaded++;
                        return Formatter.formatDate(value);
                    },
                },
                {
                    field: "actualUnloadDate",
                    title: txtTrans.fields.actualUnloadDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
            ],
            options: {
                pagination: false,
                locale: "es-ES",
                scrollX: true,
            },
        };
    },
    created() {
        this.txt = txtTrans;
    },
    computed: {
        isVehicleChecked() {
            return this.items.length > 0;
        },
        vehiclesSelected() {
            return this.items.length;
        },
        ids() {
            return this.items.map((item) => item.id);
        },
    },
    methods: {
        clear() {
            this.items = [];
            this.itemsLoaded = false;
            this.vehiclesLoaded = 0;
            this.vehiclesTotal = 0;
        },
        check(table) {
            this.items = table.getAllSelections();
        },
        /**
         * Si el vehículo tiene fecha de carga real se deshabilita la posibilidad de ser seleccionados.
         *
         * @param {*} value
         * @param {*} row
         */
        checkIsLoaded(value, row) {
            return {
                disabled: row.actualLoadDate !== null,
                checked: false,
            };
        },
        hasBeenLoaded(value, row) {
            return {
                classes: row.actualLoadDate !== null ? "loaded" : "",
            };
        },
        validateLoads() {
            if (this.ids.length === 0) {
                this.$notify({
                    type: "warn",
                    text: this.txt.form.pleaseSelectAVehicle,
                });
                return;
            }

            if (["", null, undefined].includes(this.actualLoadDate)) {
                this.$notify({
                    type: "warn",
                    text: this.txt.form.pleaseSelectADate,
                });
                this.$refs.actualLoadDate.$refs.input.focus();
                return;
            }

            this.$emit("validate", this.actualLoadDate, null, this.ids, "load");
        },
    },
};
</script>

<style>
#tableLoad tbody tr:has(td.loaded) {
    background-color: #d5d5d5;
}
#tableLoad tbody tr:has(td.loaded):hover {
    background-color: #d5d5d5 !important;
}
#tableLoad tbody tr:hover {
    background-color: transparent !important;
}
</style>
