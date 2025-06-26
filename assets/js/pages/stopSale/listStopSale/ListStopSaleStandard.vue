<template>
    <fragment>
        <div class="kt-portlet kt-portlet--bordered">
            <div class="kt-portlet__body">
                <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded">
                    <erp-ajax-table
                        :url="routing.generate('stopsale.filter')"
                        :parameter-default="{ stopSaleCategoryId: stopSaleCategoryId }"
                        :columns="columns"
                        :options="options"
                    />
                </div>
            </div>
        </div>

        <modal-history-stop-sale :stopSaleId="stopSaleId" :stopSaleCategoryId="stopSaleCategoryId" :title="stopSaleName" />
    </fragment>
</template>

<script>
import moment from "moment";
import Loading from "../../../../assets/js/utilities";
import Formatter from "../../../../SharedAssets/js/formatter";
import ErpAjaxTable from "../../../../SharedAssets/vue/components/table/ErpAjaxTable";
import ModalHistoryStopSale from "../Modals/ModalHistoryStopSale";

export default {
    name: "ListStopSaleStandard",
    components: {
        ErpAjaxTable,
        ModalHistoryStopSale,
    },
    props: {
        selectList: Object,
        stopSaleName: String,
        stopSaleCategoryId: Number,
    },
    data() {
        return {
            txt: {},
            columns: [
                {
                    field: "id",
                    title: txtTrans.fields.id,
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
                    field: "stopSaleType",
                    title: txtTrans.fields.stopSaleType,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "initDate",
                    title: txtTrans.fields.initDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "endDate",
                    title: txtTrans.fields.endDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "recurrence",
                    title: txtTrans.fields.recurrence,
                    sortable: false,
                    formatter: (value) => Formatter.trimArray(value),
                },
                // {
                //     field: "regionPickUp",
                //     title: txtTrans.fields.regions,
                //     sortable: true,
                //     formatter: (value) => Formatter.trimArray(value),
                // },
                // {
                //     field: "areaPickUp",
                //     title: txtTrans.fields.areas,
                //     sortable: true,
                //     formatter: (value) => Formatter.trimArray(value),
                // },
                {
                    field: "branchPickUp",
                    title: txtTrans.fields.branches,
                    sortable: true,
                    formatter: (value) => Formatter.trimArray(value, 1, ', ', '-', 'branchIATA'),
                },
                // {
                //     field: "connectedVehicle",
                //     title: txtTrans.fields.connectedVehicle,
                //     sortable: true,
                //     formatter: (value) => Formatter.formatterBoolean(value),
                // },
                {
                    field: "carGroups",
                    title: txtTrans.fields.carGroups,
                    sortable: false,
                    // formatter: (value) => Formatter.trimArray(value),
                    formatter: (value) => Formatter.trimArray(value,3),
                },
                {
                    field: "acriss",
                    title: txtTrans.fields.acriss,
                    sortable: false,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "startTime",
                    title: txtTrans.fields.startTime,
                    sortable: false,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "endTime",
                    title: txtTrans.fields.endTime,
                    sortable: false,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "minDaysRent",
                    title: txtTrans.fields.minDaysRent,
                    sortable: false,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "maxDaysRent",
                    title: txtTrans.fields.maxDaysRent,
                    sortable: false,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "partners",
                    title: txtTrans.fields.partners,
                    sortable: false,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "sellCodes",
                    title: txtTrans.fields.sellCodes,
                    sortable: false,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "products",
                    title: txtTrans.fields.products,
                    sortable: false,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "creationUser",
                    title: txtTrans.fields.creationUser,
                    sortable: false,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "creationDate",
                    title: txtTrans.fields.creationDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "active",
                    title: txtTrans.fields.active,
                    sortable: true,
                    formatter: (value) => {
                        let formattedValue = Formatter.formatBoolean(value);
                        // return formattedValue != "-" ? txtTrans.form[formattedValue] : formattedValue;
                        return formattedValue != "-" ? txtTrans.form[formattedValue] : txtTrans.form.all;
                    },
                },
                {
                    title: txtTrans.form.actions,
                    formatter: this.actionsFormatter,
                    events: {
                        "click .history": (e, value, row) => this.clickHistoryRow(row),
                        "click .edit": (e, value, row) => this.clickEditRow(row),
                        "click .cancel": (e, value, row) => this.cancelStopSale(row),
                    },
                    width: 160,
                },
            ],
            options: {
                pagination: true,
                locale: "es-ES",
                scrollX: true,
                pageSize: 25,
                rowStyle: this.getRowStyle, 
            },
            stopSaleId: null,
        };
    },
    created() {
        this.txt = txtTrans;
    },
    methods: {
        getRowStyle(row, index) {
            if (row.active === false) {
                return { classes: 'selected' };
            }
            return {};
        },
        clickHistoryRow(row) {
            this.stopSaleId = row.id;
            $("#modal-history-stopSale").modal("show");
        },
        clickEditRow(row) {
            window.location.href = this.routing.generate("stopsale.edit", { id: row.id });
        },
        async cancelStopSale(row) {
            window.swal
                .fire({
                    title: this.txt.form.cancelStopSaleQuestion,
                    text: this.txt.form.thisChangeCannotBeRevert,
                    type: "warning",
                    confirmButtonText: this.txt.form.cancel,
                    confirmButtonColor: "#5867dd",
                    showCancelButton: true,
                    cancelButtonText: this.txt.form.close,
                    cancelButtonColor: "#d33",
                })
                .then((result) => {
                    if (result.value) {
                        Loading.starLoading();

                        let url = this.routing.generate("stopsale.cancel");
                        let formData = new FormData();
                        formData.set("id", row.id);
                        this.axios.post(url, formData)
                            .then((response) => {
                                Loading.endLoading();
                                // console.log("Cancel Stop Sale: ", response);
                                if (response.data.cancelled) {
                                    this.$notify({
                                        text: this.txt.form.stopSaleCancelledSuccessNotification,
                                        type: "success",
                                    });

                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 2000);
                                } else {
                                    this.$notify({
                                        text: this.txt.form.errorCancelingStopSaleNotification,
                                        type: "error",
                                    });
                                }
                            })
                            .catch((error) => {
                                console.error(error.response);
                                Loading.endLoading();
                                this.$notify({
                                    text: this.txt.form.errorCancelingStopSaleNotification,
                                    type: "error",
                                });
                            });
                    }
                });
        },
        /**
         * TODO reservo esta función por si en el futuro se desea implementar multilenguaje
         * 27/112024 Si al final se desea utilizar, crear en formatter.js una función genérica (?)
         *
         * @param {*} value
         */
        recurrenceFormatter(value) {
            // Use user preference instead browser locale
            let locale = window.navigator.userLanguage || window.navigator.language;
            let localMoment = moment().locale(locale);

            if (value !== null && value !== undefined) {
                if (Array.isArray(value) && value.length > 0) {
                    let names = value.map((val) => {
                        // TODO pendiente capitalizar, ahora mismo se muestra en lowerCase
                        return localMoment.isoWeekday(parseInt(val.id)).format("dddd");
                    });
                    return names.join(", ");
                }
                return "-";
            }
            return "-";
        },
        actionsFormatter(value, row) {
            const actions = [
                `<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md history" title="${txtTrans.form.history}"><i class="flaticon-list"></i></a>`,
            ];

            if (row.canBeEditCancel === true) {
                actions.push(
                    `<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md edit" title="${txtTrans.form.edit}"><i class="flaticon2-edit"></i></a>`
                );
                if (!row.cancelled) {
                    actions.push(
                        `<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md cancel" title="${txtTrans.form.cancel}"><i class="flaticon2-delete"></i></a>`
                    );
                }
            }
            return actions.join("");
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
