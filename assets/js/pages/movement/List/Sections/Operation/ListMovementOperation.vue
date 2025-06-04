<template>
    <fragment>
        <div class="kt-portlet kt-portlet--bordered">
            <div class="kt-portlet__body">
                <div class="kt-align-right mb-2">
                    <button
                        :disabled="exelExportDisabled"
                        @click="vehicleExportCSV"
                        type="button"
                        class="btn btn-dark kt-label-bg-color-4 mb-5"
                        v-text="txt.form.vehicleExcel"
                    ></button>
                    <button
                        :disabled="exelExportDisabled"
                        @click="exportCSV"
                        type="button"
                        class="btn btn-dark kt-label-bg-color-4 mb-5"
                        v-text="txt.form.movementExcel"
                    ></button>
                </div>

                <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded">
                    <erp-ajax-table
                        ref="movementOperationTable"
                        id="movementOperationTable"
                        @items="exelExportDisabled = $event.length === 0"
                        :url="routing.generate('movement.filter', { movementTypeId: movementTypeId })"
                        :columns="columns"
                        :options="options"
                    />
                </div>
            </div>
        </div>

        <modal-validation-movement :movement="movement" />

        <modal-cancel-movement
            modal-id="modal-cancel-movement"
            :movement-id="movementId"
            :movementTypeId="movementTypeId"
            :movement-type-name="movementTypeName"
            :row="row"
        />
    </fragment>
</template>

<script>
import Loading from "../../../../../../assets/js/utilities";
import Formatter from "../../../../../../SharedAssets/js/formatter";
import ErpAjaxTable from "../../../../../components/table/ErpAjaxTable";
// FIXME la tabla de Shared no capta los CSS de pintado de fila
// import ErpAjaxTable from "../../../../../../SharedAssets/vue/components/table/ErpAjaxTable";

import ModalCancelMovement from "../../../components/modals/ModalCancelMovement";
import ModalValidationMovement from "../../../components/modals/ModalValidationMovement";
export default {
    name: "ListMovementOperation",
    components: {
        ErpAjaxTable,
        ModalCancelMovement,
        ModalValidationMovement,
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
                    field: "movementStatus",
                    title: txtTrans.fields.movementStatus,
                    sortable: true,
                    formatter: this.formatterStatus,
                    cellStyle: this.isCancelled,
                },
                {
                    field: "",
                    title: txtTrans.fields.businessUnitsArticle,
                    sortable: true,
                    formatter: (value, row) => Formatter.concatFields(row.businessUnitName, row.businessUnitArticleName),
                },
                {
                    field: "supplierName",
                    title: txtTrans.fields.provider,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "",
                    title: txtTrans.fields.units,
                    sortable: true,
                    formatter: this.formatterAssignedLicensePlateUnits,
                },
                {
                    field: "expectedLoadDate",
                    title: txtTrans.fields.expectedLoadDate,
                    sortable: true,
                    formatter: this.formatterVehicleExpectedLoadDate,
                },
                {
                    field: "firstActualLoadDate",
                    title: txtTrans.fields.actualLoadDate,
                    sortable: true,
                    formatter: this.formatterVehicleActualLoadDate,
                },
                {
                    field: "expectedUnloadDate",
                    title: txtTrans.fields.expectedUnloadDate,
                    sortable: true,
                    formatter: this.formatterVehicleExpectedUnloadDate,
                },
                {
                    field: "firstActualUnloadDate",
                    title: txtTrans.fields.actualUnloadDate,
                    sortable: true,
                    formatter: this.formatterVehicleActualUnloadDate,
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
                    field: "originBranch",
                    title: txtTrans.fields.originBranch,
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
                    field: "destinationBranch",
                    title: txtTrans.fields.destinationBranch,
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
                    title: txtTrans.form.options,
                    formatter: this.actionsFormatterOperation,
                    events: {
                        "click .details": (e, value, row) => this.clickDetailsRow(row),
                        "click .edit": (e, value, row) => this.clickEditRow(row),
                        "click .validation": (e, value, row) => this.clickValidationRow(row),
                        "click .manage": (e, value, row) => this.clickManageRow(row),
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
            },
            row: {},
            movementId: null,
            movement: {},
            exelExportDisabled: false,
        };
    },
    created() {
        this.txt = txtTrans;
    },
    methods: {
        isCancelled(value, row) {
            return {
                classes: row.movementStatus.id === constants.movementStatus.cancelled ? "cancelled" : "",
            };
        },
        clickDetailsRow(row) {
            location.href = this.routing.generate("movement.show", { id: row.id });
        },
        clickEditRow(row) {
            location.href = this.routing.generate("movement.edit", { id: row.id });
        },
        clickValidationRow(row) {
            this.movement = row;
            $("#modal-validation-movement").modal({ backdrop: "static", keyboard: false });
        },
        clickFileRow(row) {
            location.href = this.routing.generate("movement.pdf", { id: row.id });
        },
        clickCancelRow(row) {
            this.movementId = row.id;
            this.row = row;
            $("#modal-cancel-movement").modal("show");
        },
        clickManageRow(row) {
            location.href = this.routing.generate("movement.vehicleLine.assigned.list", { id: row.id });
        },

        formatterDate(date) {
            return !["", null, undefined].includes(date) ? moment(date, "DD/MM/YYYY").format("DD/MM/YYYY") : "-";
        },
        formatterStatus(value, row) {
            value = Formatter.formatField(value);

            let style = "";
            let html = "";

            if (row.movementStatus.id === constants.movementStatus.pending) {
                if (row.pendingAssignedError) {
                    style = "color:red;cursor:pointer";
                    html += this.txt.form.statusErrorVehicleUnits + "\n";
                }
                if (row.pendingExpectedLoadError) {
                    style = "color:red;cursor:pointer";
                    html += this.txt.form.statusErrorExpectedLoadDate + "\n";
                }
                if (row.pendingExpectedUnoadError) {
                    style = "color:red;cursor:pointer";
                    html += this.txt.form.statusErrorExpectedUnloadDate + "\n";
                }
                if (row.pendingVehicleFilterError) {
                    style = "color:red;cursor:pointer";
                    html += this.txt.form.statusErrorVehicleFilters + "\n";
                }
                if (html !== "")
                    return `<a style="${style}" href="#" title="${html}">${value} <i class="fas fa-exclamation-triangle"></i></a>`;
            }

            return value;
        },
        formatterAssignedLicensePlateUnits(value, row) {
            return `
                ${this.txt.form.licensePlateLoad}: ${row.assignedLicensePlateUnits.load}/${row.assignedLicensePlateUnits.total}
                \n
                ${this.txt.form.licensePlateUnload}: ${row.assignedLicensePlateUnits.unload}/${row.assignedLicensePlateUnits.total}
            `;
        },
        formatterVehicleExpectedLoadDate(value, row) {
            value = this.formatterDate(value);
            return row.pendingExpectedLoadError ? `<b style="color:red;cursor:pointer">${value}</b>` : `<b>${value}</b>`;
        },
        formatterVehicleExpectedUnloadDate(value, row) {
            value = this.formatterDate(value);
            return row.pendingExpectedUnloadError ? `<b style="color:red;cursor:pointer">${value}</b>` : `<b>${value}</b>`;
        },
        formatterVehicleActualLoadDate(value, row) {
            // Paso 1: Filtrar valores nulos o vacíos y recoger solo las fechas
            const filteredDates = row.vehicle
                .map((line) => line.actualLoadDate)
                .filter((date) => date && moment(date, "DD/MM/YYYY").isValid());

            // Paso 2: Contar las ocurrencias de cada fecha
            const dateCounts = filteredDates.reduce((acc, date) => {
                const d = moment(date, "DD/MM/YYYY").format("DD/MM/YYYY");
                acc[d] = (acc[d] || 0) + 1;
                return acc;
            }, {});

            // Paso 3: Comprobar si alguna concurrencia coincide con la longitud del array
            const allSame = Object.values(dateCounts).some((count) => count === filteredDates.length);
            if (allSame || [0, 1].includes(filteredDates.length)) {
                return Formatter.formatDate(value);
            }

            // Paso 4: Filtrar el array para quitar duplicados y devolver las fechas únicas
            const uniqueDates = [...new Set(filteredDates.map((date) => Formatter.formatDate(date)))];

            return `<a href="#" title="${uniqueDates.join("\n")}"><i class='flaticon-info'></i></a>`;
        },
        formatterVehicleActualUnloadDate(value, row) {
            // Paso 1: Filtrar valores nulos o vacíos y recoger solo las fechas
            const filteredDates = row.vehicle
                .map((line) => line.actualUnloadDate)
                .filter((date) => date && moment(date, "DD/MM/YYYY").isValid());

            // Paso 2: Contar las ocurrencias de cada fecha
            const dateCounts = filteredDates.reduce((acc, date) => {
                const d = moment(date, "DD/MM/YYYY").format("DD/MM/YYYY");
                acc[d] = (acc[d] || 0) + 1;
                return acc;
            }, {});

            // Paso 3: Comprobar si alguna concurrencia coincide con la longitud del array
            const allSame = Object.values(dateCounts).some((count) => count === filteredDates.length);
            if (allSame || [0, 1].includes(filteredDates.length)) {
                return Formatter.formatDate(value);
            }

            // Paso 4: Filtrar el array para quitar duplicados y devolver las fechas únicas
            const uniqueDates = [...new Set(filteredDates.map((date) => Formatter.formatDate(date)))];

            return `<a href="#" title="${uniqueDates.join("\n")}"><i class='flaticon-info'></i></a>`;
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

        actionsFormatterOperation(value, row) {
            const actions = [
                `<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md details" title="${txtTrans.form.details}"><i class="flaticon-eye"></i></a>`,
            ];

            if ([constants.movementStatus.pending, constants.movementStatus.progress].includes(row.movementStatus.id)) {
                actions.push(
                    `<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md edit" title="${txtTrans.form.edit}"><i class="flaticon-edit"></i></a>`,
                    `<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md manage" title="${txtTrans.form.manageVehicles}"><i class="flaticon-signs-1"></i></a>`,
                    `<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md validation" title="${txtTrans.form.validate}"><i class="flaticon2-check-mark"></i></a>`
                );
            }

            if (row.movementStatus.id === constants.movementStatus.pending) {
                actions.push(
                    `<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md cancel" title="${txtTrans.form.cancelMovement}"><i class="flaticon-cancel"></i></a>`
                );
            }

            if (
                [
                    constants.movementStatus.pending,
                    constants.movementStatus.progress,
                    constants.movementStatus.finalized,
                ].includes(row.movementStatus.id)
            ) {
                actions.push(
                    `<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md file" title="${txtTrans.form.pdf}"><i class="flaticon-file"></i></a>`
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
                    link.setAttribute("download", "movement_operation_list.csv");
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
        vehicleExportCSV() {
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

            //Axios call to movement.vehicleLine.excel
            Loading.starLoading();
            this.axios
                .get(this.routing.generate("movement.vehicleLine.excel", { filters }), {
                    responseType: "blob",
                })
                .then((response) => {
                    Loading.endLoading();
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute("download", "movement_operation_vehicle_list.csv");
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

<style>
#movementOperationTable tbody tr:has(td.cancelled) {
    background-color: #d5d5d5;
}
#movementOperationTable tbody tr:has(td.cancelled):hover {
    background-color: #d5d5d5 !important;
}
#movementOperationTable tbody tr:hover {
    background-color: transparent !important;
}

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
