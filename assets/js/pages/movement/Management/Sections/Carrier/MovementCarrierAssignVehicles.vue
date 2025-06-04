<template>
    <div class="kt-portlet kt-portlet--bordered">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <button @click="back" type="button" class="btn btn-lg btn-icon" :title="txt.form.back">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <h3 id="title" class="kt-section__title" style="margin-bottom: unset;" v-text="txt.titles.assignVehicles"></h3>
            </div>
        </div>

        <div class="kt-portlet__body">
            <alert v-show="canAssignMoreVehicles" class="mb-5" type="warning" :closable="false">
                <template #text>
                    <p v-text="txt.form.warnCannotAssignMoreVehicles" style="margin: 0"></p>
                </template>
            </alert>

            <assign-vehicles-filter
                @filtersSubmitted="searchLicensePlate(null, $event, $refs.vehiclesTable.initCall)"
                @filtersCleared="searchLicensePlate(null, $event, $refs.vehiclesTable.initCall)"
                :selectList="selectList"
                :filters="movement.vehicleFilter"
                :movementId="movement.id"
                :sale-method-id="getSaleMethodOfBusinessUnitArticle(movement.businessUnitArticleId)"
            />
            
            <div class="kt-align-right mb-2">
                <button id="search-licenseplate" class="btn btn-icon btn-dark">
                    <i class="fas fa-search" :title="`${txt.form.searchBy} ${String(txt.fields.licensePlate).toLowerCase()}`"></i>
                </button>

                <button
                    @click.prevent="downloadExcel"
                    type="button"
                    class="btn btn-dark kt-label-bg-color-4"
                    v-text="txt.form.downloadExcel"
                ></button>
            </div>

            <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded">
                <erp-ajax-table
                    @check="check($event)"
                    @items="onChangeItems($event)"
                    ref="vehiclesTable"
                    id="vehiclesTable"
                    :url="
                        routing.generate('movement.vehicleLine.assign.filter', {
                            movementId: this.movement.id,
                            movementTypeId: this.movement.movementTypeId,
                            locationId: this.movement.originLocationId,
                        })
                    "
                    :columns="columns"
                    :options="options"
                    :firstCall="false"
                />

                <!-- <div id="info" class="mt-3">
                    <p v-text="txt.form.selectedTotal + vehiclesSelected + txt.form.of + $store.getters['filter/count']"></p>
                </div> -->
            </div>
        </div>
    </div>
</template>

<script>
import Loading from "../../../../../../assets/js/utilities";
import Formatter from "../../../../../../SharedAssets/js/formatter";
import Alert from "../../../../../../SharedAssets/vue/components/Alert.vue";
import ErpAjaxTable from "../../../../../components/table/ErpAjaxTable.vue";
/**
 * FIXME cuando se utiliza ErpAjaxTable de Shared, no funciona correctamnete las llamadas externas vía código.
 */
// import ErpAjaxTable from "../../../../../../SharedAssets/vue/components/table/ErpAjaxTable.vue";
import AssignVehiclesFilter from "./MovementCarrierAssignVehiclesFilter.vue";
import MovementAssignVehiclesCart from "../../../components/MovementAssignVehiclesCart.vue";

export default {
    name: "MovementCarrierAssignVehicles",
    components: {
        Alert,
        ErpAjaxTable,
        AssignVehiclesFilter,
    },
    props: {
        selectList: Object,
        movement: Object,
    },
    data() {
        const paginationLimitOptions = [100, 250, 500];

        return {
            getSaleMethodOfBusinessUnitArticle,
            txt: txtTrans,

            columns: [
                {
                    field: "checked",
                    sortable: false,
                    checkbox: true,
                    formatter: this.checkIsSelected,
                },
                {
                    field: "licensePlate",
                    title: txtTrans.fields.licensePlate,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                    cellStyle: this.hasBeenSelected,
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
                    field: "kilometers",
                    title: txtTrans.fields.kilometers,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "rentingEndDate",
                    title: txtTrans.fields.rentingEndDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
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
                    formatter: (value) => (value === false ? "No" : "Si"),
                },
                {
                    field: "vehicleStatus",
                    title: txtTrans.fields.vehicleStatus,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "raDropOffDate",
                    title: txtTrans.fields.raDropOffDate,
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
                pageList: paginationLimitOptions,
                pageSize: paginationLimitOptions[0],
                locale: "es-ES",
                scrollX: true,
                fixedScroll: true,
                height: 600,
            },

            items: [],
            selectedItems: [],
            totalRows: null,
            lpFilter: "",
        };
    },
    mounted() {
        this.eventBus.$emit("setFooterComponent", MovementAssignVehiclesCart);
        this.eventBus.$emit("stickyFooter", true);

        this.eventBus.$on("itemsAdded", () => {
            this.$refs.vehiclesTable.$refs.table.uncheckAll();
            this.$refs.vehiclesTable.$refs.table.refresh({ silent: true });
        });
        this.eventBus.$on("itemsRemoved", () => {
            this.$refs.vehiclesTable.$refs.table.refresh({ silent: true });
        });
        this.eventBus.$on("itemsUpdated", (items) => {
            this.selectedItems = items;
        });
        this.eventBus.$on("assignVehicles", () => {
            this.assignVehicles();
        });

        this.createPopoverFilter("search-licenseplate");
    },
    computed: {
        vehiclesSelected() {
            return this.selectedItems.length;
        },
        canAssignMoreVehicles() {
            let maxVehicles = null;
            if (this.movement.assignedLicensePlateUnits.total > 0) {
                maxVehicles = constants.transportMethodRoadMaxVehicles - this.movement.assignedLicensePlateUnits.total;
            } else {
                maxVehicles = constants.transportMethodRoadMaxVehicles;
            }

            return this.movement.transportMethodId === constants.transportMethod.road && this.vehiclesSelected > maxVehicles;
        },
    },
    methods: {
        back() {
            location.href = this.routing.generate("movement.vehicleLine.assigned.list", { id: this.movement.id });
        },
        downloadExcel() {
            location.href = this.routing.generate("movement.vehicleLine.assign.excel", {
                movementId: this.movement.id,
                movementTypeId: this.movement.movementTypeId,
            });
        },
        checkIsSelected(value, row) {
            return {
                disabled: this.selectedItems.some((item) => item.id === row.id),
                checked: false,
            };
        },
        hasBeenSelected(value, row) {
            return {
                classes: this.selectedItems.some((item) => item.id === row.id) ? "selected" : "",
            };
        },
        check(table) {
            this.eventBus.$emit("selectItems", table.getAllSelections());
        },
        onChangeItems(data) {
            this.items = data.rows;
            this.totalRows = data.total;
        },
        createPopoverFilter(id) {
            $(`#${id}`)
                .popover({
                    // placement: "bottom",
                    // trigger: "focus",
                    content: " ", // INFO necesario para que se muestre el popover
                })
                .on("inserted.bs.popover", () => {
                    const div = document.createElement("div");
                    div.classList.add("d-inline-flex", "justify-content-between", "align-items-center");

                    const input = document.createElement("input");
                    input.type = "text";
                    input.id = `${id}-input`;
                    input.classList.add("form-control", "mr-3");
                    input.placeholder = `${this.txt.form.searchBy} ${String(this.txt.fields.licensePlate).toLowerCase()}`;
                    input.value = this.lpFilter;

                    const a = document.createElement("a");
                    a.href = "javascript:void(0)";
                    a.classList.add("btn", "btn-sm", "btn-clean", "btn-icon", "btn-icon-md", "close-search");
                    a.title = this.txt.form.close;
                    a.innerHTML = `<i class="la la-close"></i>`;

                    div.appendChild(input);
                    div.appendChild(a);
                    document.querySelector(".popover > .popover-body").appendChild(div);

                    document.querySelector(`#${id}-input`).addEventListener("input", (event) => {
                        event.target.value = event.target.value.toUpperCase();
                        this.lpFilter = event.target.value;
                        this.searchLicensePlate(this.lpFilter);
                    });
                    document.querySelector(`#${id}-input`).focus();
                    document.querySelector("a.close-search").addEventListener("click", (event) => {
                        $(`#${id}`).popover("hide");
                    });

                    // INFO alternativa a trigger: focus
                    document.addEventListener("click", (event) => {
                        const popover = document.querySelector(".popover");
                        if (popover && !popover.contains(event.target) && !event.target.closest(`#${id}`)) {
                            $(`#${id}`).popover("hide");
                        }
                    });
                });
        },
        searchLicensePlate(value, tableRefresh = true, firstCall = false) {
            if (!firstCall) {
                console.log("searchLicensePlate: ", value, tableRefresh, firstCall);

                const licensePlateChip = document.querySelector("#filter-chips > #licenseplate-chip");
                const formattedValue = `${this.txt.fields.licensePlate}: ${value} <i id="delete-licenseplate-chip" class="fa fa-times-circle fa-lg ml-2"></i>`;

                if (![null, undefined, ""].includes(value)) {
                    this.$refs.vehiclesTable.$refs.table.load(
                        this.items.filter((row) => {
                            return String(row.licensePlate)
                                .toUpperCase()
                                .includes(String(value).toUpperCase());
                        })
                    );

                    if (licensePlateChip) {
                        licensePlateChip.innerHTML = formattedValue;
                    } else {
                        const button = document.createElement("button");
                        button.id = "licenseplate-chip";
                        button.type = "button";
                        button.classList.add("btn", "btn-sm", "btn-light", "btn-pill", "mr-1", "mb-2");
                        button.dataset.target = this.txt.fields.licensePlate;
                        button.innerHTML = formattedValue;
                        document.querySelector("#filter-chips").appendChild(button);
                    }

                    document.querySelector("#delete-licenseplate-chip").addEventListener("click", (event) => {
                        if (this.vehiclesSelected === 0 && tableRefresh) {
                            this.$refs.vehiclesTable.$refs.table.refresh();
                        }
                        this.lpFilter = "";
                        this.searchLicensePlate(this.lpFilter, tableRefresh);
                    });
                } else {
                    this.lpFilter = "";
                    licensePlateChip?.remove();
                    if (this.vehiclesSelected === 0 && tableRefresh) {
                        $("#search-licenseplate").popover("hide");
                        this.$refs.vehiclesTable.$refs.table.refresh();
                    } else {
                        this.$refs.vehiclesTable.$refs.table.load(this.items);
                    }
                }
            }
        },
        async assignVehicles() {
            let arrayVehicles = [];
            this.selectedItems.forEach((vehicle) => {
                arrayVehicles.push({
                    id: vehicle.id,
                    licensePlate: vehicle.licensePlate,
                    vin: vehicle.vin,
                    vehicleStatusId: vehicle.vehicleStatus.id,
                    actualKms: vehicle.kilometers,
                    actualBattery: vehicle.actualBattery,
                    actualOctaves: vehicle.actualOctaves,
                });
            });

            let selectedVehiclesList = `<div class="d-flex justify-content-center"><ul align="justify">`;
            this.selectedItems.forEach((vehicle) => {
                selectedVehiclesList += `<li>${vehicle.brand} ${vehicle.model} (${vehicle.licensePlate})</li>`;
            });
            selectedVehiclesList += `</ul></div>`;

            window.swal
                .fire({
                    title: this.txt.form.assignVehiclesQuestion,
                    html: `
                        ${selectedVehiclesList}
                        ${this.txt.form.toAssignUnits}: ${this.vehiclesSelected}<br>${this.txt.form.expectedUnits}: ${this.movement.vehicleUnits}
                    `,
                    type: "warning",
                    confirmButtonText: this.txt.form.continue,
                    confirmButtonColor: "#5867dd",
                    showCancelButton: true,
                    cancelButtonText: this.txt.form.cancel,
                    cancelButtonColor: "#d33",
                })
                .then((result) => {
                    if (result.value) {
                        Loading.starLoading();
                        let url = this.routing.generate("movement.vehicleLine.assign", {
                            movementId: this.movement.id,
                            vehicleLinesId: arrayVehicles,
                            vehiclesUnits: this.vehiclesSelected,
                        });

                        this.axios
                            .post(url)
                            .then((response) => {
                                Loading.endLoading();
                                // console.log("Movement Assign Vehicles: ", response);

                                if (response.data.assigned) {
                                    this.$notify({
                                        type: "success",
                                        text: this.txt.form.vehicleLinesAssignedSuccessNotification,
                                    });

                                    setTimeout(() => {
                                        window.location.href = this.routing.generate("movement.vehicleLine.assigned.list", {
                                            id: this.movement.id,
                                        });
                                    }, 2000);
                                } else {
                                    this.$notify({
                                        type: "error",
                                        text: response.data.message,
                                    });
                                }
                            })
                            .catch((error) => {
                                console.log(error.response);
                                Loading.endLoading();

                                let errorMessage = this.txt.form.errorAssigningVehicleLinesNotification;
                                if ([400, 460].includes(error.response.status)) {
                                    errorMessage += error.response.data.message;
                                }

                                this.$notify({
                                    type: "error",
                                    text: errorMessage,
                                });
                            });
                    }
                });
        },
    },
    watch: {
        canAssignMoreVehicles: {
            handler() {
                this.eventBus.$emit("limitReached", this.canAssignMoreVehicles);
            },
        },
    },
};
</script>

<style>
#vehiclesTable tbody tr:has(td.selected) {
    background-color: #d5d5d5;
}
#vehiclesTable tbody tr:has(td.selected):hover {
    background-color: #d5d5d5 !important;
}
/* #vehiclesTable tbody tr:hover {
    background-color: transparent !important;
} */
</style>
