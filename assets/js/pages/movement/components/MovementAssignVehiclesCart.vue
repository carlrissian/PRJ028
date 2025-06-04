<template>
    <fragment>
        <div class="d-flex align-items-center justify-content-end gap w-100 mx-5">
            <button @click="showModal" class="btn btn-icon" :title="txt.titles.vehiclesToAssign">
                <i class="la la-car"></i>
                <span class="badge badge-pill badge-primary" v-text="items.length"></span>
            </button>
            <button @click="addVehicles" class="btn btn-primary" :disabled="!vehiclesSelected || limitReached">
                <i class="fas fa-plus"></i> {{ txt.form.add }}
            </button>
            <button @click="eventBus.$emit('assignVehicles')" class="btn btn-primary" :disabled="!hasItems || limitReached">
                <i class="fas fa-check"></i> {{ txt.form.assign }}
            </button>
        </div>

        <erp-modal @onCloseModal="closeModal" id="vehiclesToAssignModal" :title="txt.titles.vehiclesToAssign" centered>
            <template #body>
                <p v-show="!hasItems" v-text="txt.form.noVehiclesToAssign"></p>
                <div v-show="hasItems">
                    <bootstrap-table
                        ref="table"
                        id="vehiclesCartTable"
                        @onCheck="checkItem($event, true)"
                        @onUncheck="checkItem($event, false)"
                        @onCheckAll="checkAllItems(true)"
                        @onUncheckAll="checkAllItems(false)"
                        :columns="columns"
                        :options="options"
                        :data="items"
                    />
                </div>
            </template>

            <template #footer>
                <div v-show="vehicleChecked" class="kt-align-right">
                    <button @click="removeVehicles" type="button" class="btn btn-dark kt-label-bg-color-4">
                        <i class="fas fa-trash"></i>
                        {{ txt.form.remove }}
                    </button>
                </div>
            </template>
        </erp-modal>
    </fragment>
</template>

<script>
import Vue from "vue";

import Formatter from "../../../../SharedAssets/js/formatter.js";
import CheckBox from "../../../../SharedAssets/vue/components/base/inputs/CheckBox.vue";
import ErpModal from "../../../../SharedAssets/vue/components/modal/ErpModal.vue";

export default {
    name: "MovementAssignVehiclesCart",
    components: {
        CheckBox,
        ErpModal,
    },
    data() {
        return {
            txt: txtTrans,
            items: [],
            selectedItems: [],
            limitReached: false,

            tableRef: null,
            columns: [
                {
                    field: "checked",
                    checkbox: true,
                    width: 50,
                },
                {
                    field: "licensePlate",
                    title: txtTrans.fields.licensePlate,
                    sortable: false,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "vin",
                    title: txtTrans.fields.vin,
                    sortable: false,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "brand",
                    title: txtTrans.fields.brand,
                    sortable: false,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "model",
                    title: txtTrans.fields.model,
                    sortable: false,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "carGroup",
                    title: txtTrans.fields.carGroup,
                    sortable: false,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "vehicleStatus",
                    title: txtTrans.fields.vehicleStatus,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "actions",
                    title: txtTrans.form.actions,
                    formatter: (value, row) => this.actionsFormatter(row),
                    events: {
                        "click .remove": (e, value, row) => this.removeVehicle(row),
                    },
                    width: 100,
                },
            ],
            options: {
                pagination: false,
                locale: "es-ES",
                scrollX: true,
                scrollY: true,
                height: 400,
            },
        };
    },
    mounted() {
        this.tableRef = this.$refs.table;

        this.eventBus.$on("selectItems", (items) => {
            this.selectedItems = items;
            this.eventBus.$emit("showFooter", this.vehiclesSelected || this.hasItems);
        });
        this.eventBus.$on("limitReached", (limit) => {
            this.limitReached = limit;
        });
    },
    computed: {
        vehiclesSelected() {
            return this.selectedItems.length > 0;
        },
        hasItems() {
            return this.items.length > 0;
        },
        allVehiclesChecked() {
            return this.items.every((item) => item.checked === true);
        },
        vehicleChecked() {
            return this.items.some((item) => item.checked === true);
        },
    },
    methods: {
        actionsFormatter(row) {
            const actions = [
                `<a href="javascript:void(0)" class="btn btn-icon remove" title="${txtTrans.form.remove}" disabled="${row.checked}"><i class="fa fa-times btn-outline-hover-danger"></i></a>`,
            ];
            return actions.join("");
        },
        refreshTable() {
            this.tableRef?.refresh({ silent: true });
        },
        showModal() {
            this.eventBus.$emit("stickyFooter", false);
            this.$nextTick(() => {
                $("#vehiclesToAssignModal").modal("show");
            });
        },
        closeModal() {
            this.eventBus.$emit("stickyFooter", true);
            this.items.map((item) => (item.checked = false));
        },
        checkItem(row, checked) {
            const index = this.items.findIndex((item) => item.id === row.id);
            // this.items[index].checked = checked;
            Vue.set(this.items[index], "checked", checked); // Vue.set() fuerza la reactividad en propiedades anidadas de un objeto.
            this.items = [...this.items]; // Nueva referencia = Vue lo detecta y actualiza la vista
            this.refreshTable();
        },
        checkAllItems(checked) {
            this.items.map((item) => (item.checked = checked));
            this.items = [...this.items];
            this.refreshTable();
        },
        addVehicles() {
            this.items = this.items.concat(this.selectedItems).filter((item, index, self) => {
                return index === self.findIndex((t) => t.id === item.id);
            });
            this.items.map((item) => (item.checked = false));
            this.selectedItems = [];
            this.eventBus.$emit("itemsAdded");
        },
        removeVehicles() {
            this.items = this.items.filter((item) => item.checked !== true);
            this.refreshTable();
            this.eventBus.$emit("itemsRemoved");
        },
        removeVehicle(row) {
            const index = this.items.findIndex((item) => item.id === row.id);
            this.items.splice(index, 1);
            this.refreshTable();
            this.eventBus.$emit("itemsRemoved");
        },
    },
    watch: {
        items: {
            handler() {
                this.tableRef?.load(this.items);
                this.refreshTable();
                this.eventBus.$emit("itemsUpdated", this.items);
            },
            deep: true,
        },
    },
};
</script>

<style scoped>
.gap {
    gap: 1rem;
}

ul#itemList {
    list-style: none;
    margin: 0;
    padding: 0;
}
</style>
