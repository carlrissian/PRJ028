<template>
    <movement-assigned-vehicles
        v-if="movementId"
        @onTableItemsLoaded="
            itemsLoaded = true;
            vehiclesTotal = $event;
        "
        @onTableCheck="check($event)"
        ref="assignedVehicles"
        id="tableUnload"
        :movement-id="movementId"
        :columns="columns"
        containerClass=""
        selectable
        :check-validation="checkIsUnloaded"
    >
        <template #action-buttons-foot>
            <div v-show="itemsLoaded" id="info" class="mt-3">
                <p v-text="`${txt.form.selectedTotal}: ${vehiclesSelected} ${txt.form.of} ${vehiclesTotal}`"></p>
                <p v-text="`${txt.form.unloadedTotal}: ${vehiclesUnloaded} ${txt.form.of} ${vehiclesTotal}`"></p>
            </div>

            <alert v-if="showAlert" type="warning" :closable="false">
                <template #text>
                    <p v-show="cannotUnloadWithoutLoad" v-text="txt.form.cannotUnloadWithoutLoad" style="margin: 0"></p>
                    <p
                        v-show="cannotUnloadIfUnloadDateIsLess"
                        v-text="txt.form.cannotUnloadIfUnloadDateIsLess"
                        style="margin: 0"
                    ></p>
                    <p v-show="cannotUnloadIfDifferentDates" v-text="txt.form.cannotUnloadDifferentDates" style="margin: 0"></p>
                </template>
            </alert>

            <date-picker
                @updatedDatePicker="actualUnloadDate = $event"
                ref="actualUnloadDate"
                name="actualUnloadDate"
                id="actualUnloadDateId"
                divClass="row col-md-3 my-5"
                :label="txt.fields.actualUnloadDate"
                :placeholder="txt.form.selectDate"
                :value="actualUnloadDate"
                :limit-end-day="new Date()"
                required
            />

            <button
                @click.prevent="validateUnloads"
                class="btn btn-dark kt-label-bg-color-4"
                v-text="txt.titles.unloadValidation"
                :disabled="showAlert"
            ></button>
        </template>
    </movement-assigned-vehicles>
</template>

<script>
import Formatter from "../../../../../../SharedAssets/js/formatter";
import Alert from "../../../../../../SharedAssets/vue/components/Alert";
import DatePicker from "../../../../../../SharedAssets/vue/components/base/inputs/DatePicker";

import MovementAssignedVehicles from "../../MovementAssignedVehicles.vue";

export default {
    components: {
        Alert,
        DatePicker,
        MovementAssignedVehicles,
    },
    name: "TableUnload",
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
            vehiclesUnloaded: 0,
            vehiclesTotal: 0,
            // actualUnloadDate: moment(new Date(), "DD/MM/YYYY").format("DD/MM/YYYY"),
            actualUnloadDate: new Intl.DateTimeFormat("en-GB").format(new Date(Date.now())),
            columns: [
                {
                    field: "licensePlate",
                    title: txtTrans.fields.licensePlate,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                    cellStyle: this.hasBeenUnloaded,
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
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "actualUnloadDate",
                    title: txtTrans.fields.actualUnloadDate,
                    sortable: true,
                    formatter: (value) => {
                        if (!["", null, undefined].includes(value)) this.vehiclesUnloaded++;
                        return Formatter.formatDate(value);
                    },
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
        vehicleDates() {
            return this.items.map((item) => item.actualLoadDate);
        },
        vehicleFirstDate() {
            return Math.min(...this.vehicleDates.map((date) => moment(date, "DD/MM/YYYY").toDate()));
        },
        vehicleLastDate() {
            return Math.max(...this.vehicleDates.map((date) => moment(date, "DD/MM/YYYY").toDate()));
        },
        cannotUnloadWithoutLoad() {
            return this.items.some((item) => item.actualLoadDate === null);
        },
        cannotUnloadIfUnloadDateIsLess() {
            if (this.isVehicleChecked) {
                const difference = new Set(this.vehicleDates).size !== 1;
                return !difference && moment(this.actualUnloadDate, "DD/MM/YYYY").toDate() < new Date(this.vehicleFirstDate);
            }
            return false;
        },
        cannotUnloadIfDifferentDates() {
            if (this.isVehicleChecked) {
                const difference = new Set(this.vehicleDates).size !== 1;
                return difference && moment(this.actualUnloadDate, "DD/MM/YYYY").toDate() < new Date(this.vehicleLastDate);
            }
            return false;
        },
        showAlert() {
            return this.cannotUnloadWithoutLoad || this.cannotUnloadIfUnloadDateIsLess || this.cannotUnloadIfDifferentDates;
        },
    },
    methods: {
        clear() {
            this.items = [];
            this.itemsLoaded = false;
            this.vehiclesUnloaded = 0;
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
        checkIsUnloaded(value, row) {
            return {
                disabled: row.actualUnloadDate !== null,
                checked: false,
            };
        },
        hasBeenUnloaded(value, row) {
            return {
                classes: row.actualUnloadDate !== null ? "unloaded" : "",
            };
        },
        validateUnloads() {
            if (this.ids.length === 0) {
                this.$notify({
                    type: "warn",
                    text: this.txt.form.pleaseSelectAVehicle,
                });
                return;
            }

            if (["", null, undefined].includes(this.actualUnloadDate)) {
                this.$notify({
                    type: "warn",
                    text: this.txt.form.pleaseSelectADate,
                });
                this.$refs.actualUnloadDate.$refs.input.focus();
                return;
            }

            this.$emit("validate", null, this.actualUnloadDate, this.ids, "unload");
        },
    },
};
</script>

<style>
#tableUnload tbody tr:has(td.unloaded) {
    background-color: #d5d5d5;
}
#tableUnload tbody tr:has(td.unloaded):hover {
    background-color: #d5d5d5 !important;
}
#tableUnload tbody tr:hover {
    background-color: transparent !important;
}
</style>
