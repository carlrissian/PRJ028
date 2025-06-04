<template>
    <fragment>
        <notifications position="top right"></notifications>

        <div class="kt-portlet kt-portlet--bordered">
            <div class="kt-portlet__body">
                <div class="kt-align-right mb-2">
                    <button
                        :disabled="exelExportDisabled"
                        @click="exportCSV"
                        type="button"
                        class="btn btn-dark kt-label-bg-color-4 mb-5"
                        v-text="txt.form.vehicleExcel"
                    ></button>
                </div>

                <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded">
                    <erp-ajax-table
                        ref="movementDriverTable"
                        id="dataTable"
                        @items="exelExportDisabled = $event.length === 0"
                        :url="routing.generate('movement.filter', { movementTypeId: movementTypeId })"
                        :columns="columns"
                        :options="options"
                    />
                </div>
            </div>
        </div>

        <modal-close-movement :movement-type-name="movementTypeName" :movement="movement" />

        <modal-cancel-movement
            :movementTypeId="movementTypeId"
            :movement-type-name="movementTypeName"
            :movement-id="movementId"
        />
    </fragment>
</template>

<script>
import Loading from "../../../../../../assets/js/utilities";
import Formatter from "../../../../../../SharedAssets/js/formatter.js";
import ErpAjaxTable from "../../../../../../SharedAssets/vue/components/table/ErpAjaxTable";

import ModalCloseMovement from "../../../components/modals/ModalCloseMovement";
import ModalCancelMovement from "../../../components/modals/ModalCancelMovement";

export default {
    name: "ListMovementDriver",
    components: {
        Formatter,
        ErpAjaxTable,
        ModalCloseMovement,
        ModalCancelMovement,
    },
    props: {
        selectList: Object,
        movementTypeId: Number,
        movementTypeName: String,
    },
    data() {
        return {
            txt: {},
            columns: [
                {
                    field: "id",
                    title: txtTrans.fields.movementNumber,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "orderNumber",
                    title: txtTrans.fields.orderNumber,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "driverTypeName",
                    title: txtTrans.fields.driverType,
                    sortable: true,
                    formatter: (value) => txtTrans.fields[value],
                },
                {
                    field: "supplierName",
                    title: txtTrans.fields.provider,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "driverName",
                    title: txtTrans.fields.driverName,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "vehicle.licensePlate",
                    title: txtTrans.fields.licensePlate,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "vehicle.brandName",
                    title: txtTrans.fields.brand,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "vehicle.modelName",
                    title: txtTrans.fields.model,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "",
                    title: txtTrans.fields.businessUnitsArticle,
                    sortable: true,
                    formatter: (value, row) => Formatter.concatFields(row.businessUnitName, row.businessUnitArticleName),
                },
                {
                    field: "originBranch",
                    title: txtTrans.fields.originBranch,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                // {
                //     field: "originLocation",
                //     title: txtTrans.fields.originLocation,
                //     sortable: true,
                //     formatter: (value) => Formatter.formatField(value),
                // },
                {
                    field: "",
                    title: txtTrans.fields.originLocation,
                    sortable: true,
                    formatter: this.formatterOriginLocation,
                },
                {
                    field: "destinationBranch",
                    title: txtTrans.fields.destinationBranch,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                // {
                //     field: "destinationLocation",
                //     title: txtTrans.fields.destinationLocation,
                //     sortable: true,
                //     formatter: (value) => Formatter.formatField(value),
                // },
                {
                    field: "",
                    title: txtTrans.fields.destinationLocation,
                    sortable: true,
                    formatter: this.formatterDestinationLocation,
                },
                {
                    field: "expectedUnloadDate",
                    title: txtTrans.fields.expectedUnloadDate,
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
                    field: "movementStatus",
                    title: txtTrans.fields.movementStatus,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "creationUser",
                    title: txtTrans.fields.creationUser,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "creationDate",
                    title: txtTrans.fields.creationDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "department",
                    title: txtTrans.fields.department,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    title: txtTrans.form.options,
                    formatter: this.actionsFormatterDriver,
                    events: {
                        "click .details": (e, value, row) => this.clickDetailsRow(row),
                        "click .edit": (e, value, row) => this.clickEditRow(row),
                        "click .close": (e, value, row) => this.clickCloseRow(row),
                        // "click .validation": (e, value, row) => this.clickValidationRow(row),
                        // "click .manage": (e, value, row) => this.clickManageRow(row),
                        // "click .history": (e, value, row) => this.clickHistoryRow(row),
                        "click .file": (e, value, row) => this.clickFileRow(row),
                        "click .cancel": (e, value, row) => this.clickCancelRow(row),
                    },
                    width: 160,
                },
            ],
            options: {
                pagination: true,
                locale: "es-ES",
                scrollX: true,
                scrollY: true,
            },
            row: {},
            movementId: null,
            movement: null,
            exelExportDisabled: false,
        };
    },
    created() {
        this.txt = txtTrans;
    },
    methods: {
        /**
         * Implementación temporal para obtener el tipo de motorización de un vehículo.
         * Pendiente de solicitar a WS en estructura TVehicleResponse de MovementRepository.
         * @param {*} vehicleId
         */
        getMotorizationType: async function(vehicleId) {
            Loading.starLoading();

            let url = this.routing.generate("vehicle.motorizationType", {
                vehicleId: vehicleId,
            });

            this.axios
                .get(url)
                .then((response) => {
                    console.log("Motorization Type: ", response);
                    Loading.endLoading();

                    this.movement.vehicle.motorizationType = response.data;
                    $("#modal-close-movement").modal("show");
                })
                .catch((error) => {
                    console.error(error.response);
                });
        },
        clickDetailsRow(row) {
            location.href = this.routing.generate("movement.show", { id: row.id });
        },
        clickEditRow(row) {
            location.href = this.routing.generate("movement.edit", { id: row.id });
        },
        clickFileRow(row) {
            location.href = this.routing.generate("movement.pdf", { id: row.id });
        },
        clickCloseRow(row) {
            this.movement = row;

            this.getMotorizationType(this.movement.vehicle.id);
        },
        clickCancelRow(row) {
            this.movementId = row.id;
            $("#modal-cancel-movement").modal("show");
        },
        formatterOriginLocation(value, row) {
            const location = row.originLocation || row.externalOriginLocation;

            if (location) {
                return Formatter.formatField(location);
            }

            if (row.manualOriginLocation) {
                return Formatter.concatFields(row.manualOriginLocation.country, row.manualOriginLocation.state);
            }
        },
        formatterDestinationLocation(value, row) {
            const location = row.destinationLocation || row.externalDestinationLocation;

            if (location) {
                return Formatter.formatField(location);
            }

            if (row.manualDestinationLocation) {
                return Formatter.concatFields(row.manualDestinationLocation.country, row.manualDestinationLocation.state);
            }
        },
        actionsFormatterDriver(value, row) {
            const actions = [
                `<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md details" title="${txtTrans.form.details}"><i class="flaticon-eye"></i></a>`,
            ];

            if (![constants.movementStatus.finalized, constants.movementStatus.cancelled].includes(row.movementStatus.id)) {
                actions.push(
                    `<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md edit" title="${txtTrans.form.edit}"><i class="flaticon-edit"></i></a>`
                );
            }

            if (row.movementStatus.id === constants.movementStatus.progress) {
                actions.push(
                    `<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md file" title="${txtTrans.form.pdf}"><i class="flaticon-file"></i></a>`,
                    `<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md close" style="float:none;z-index:0" title="${txtTrans.form.closeMovement}"><i class="icon-2x text-dark-50 flaticon2-check-mark"></i></a>`,
                    `<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md cancel" title="${txtTrans.form.cancelMovement}"><i class="flaticon-cancel"></i></a>`
                );
            }

            return actions.join("");
        },
        exportCSV() {
            let filters = this.$store.getters["filter/items"];

            // Recorrer todas las propiedades del objeto
            for (const key in filters) {
                if (filters.hasOwnProperty(key) && typeof filters[key] === "string") {
                    try {
                        // Intentar convertir el valor de cadena JSON a un array
                        filters[key] = JSON.parse(filters[key]);
                    } catch (error) {
                        // Si hay un error en el parsing, dejar el valor sin cambios
                        console.error(`Error al convertir ${key} a un array: ${error.message}`);
                    }
                }
            }
            filters["movementTypeId"] = this.movementTypeId;

            //transform filters to object
            filters = { ...filters };

            //Axios call to movement.excel
            Loading.starLoading();
            this.axios
                .get(this.routing.generate("movement.excel", { filters }), {
                    responseType: "blob",
                })
                .then((response) => {
                    Loading.endLoading();

                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute("download", "movement_driver_list.csv");
                    document.body.appendChild(link);
                    link.click();
                })
                .catch(async (error) => {
                    Loading.endLoading();
                    let errorMessage = JSON.parse(await error.response.data.text());
                    this.$notify({
                        title: errorMessage.error,
                        message: errorMessage.error,
                        type: "error",
                    });
                });
        },
    },
};
</script>

<style scoped>
.kt-portlet /deep/ .fixed-table-container {
    padding-bottom: 0px;
    width: 100%;
    height: 55vh;
}
.kt-portlet /deep/ thead tr {
    background: white;
    position: sticky;
    top: 0;
}
#dataTable /deep/ tr td a {
    display: table-cell;
    padding-right: 5px;
}
</style>
