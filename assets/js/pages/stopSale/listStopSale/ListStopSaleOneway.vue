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
import Axios from "axios";
import moment from "moment";
import Loading from "../../../../assets/js/utilities";
import ErpAjaxTable from "../../../../SharedAssets/vue/components/table/ErpAjaxTable";
import ModalHistoryStopSale from "../Modals/ModalHistoryStopSale";

export default {
    name: "ListStopSaleOneway",
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
                    field: "initDate",
                    title: txtTrans.fields.initDate,
                    sortable: true,
                    formatter: this.formatterDate,
                },
                {
                    field: "endDate",
                    title: txtTrans.fields.endDate,
                    sortable: true,
                    formatter: this.formatterDate,
                },
                {
                    field: "minDaysRent",
                    title: txtTrans.fields.minDaysRent,
                    sortable: true,
                    formatter: this.formatter,
                },
                {
                    field: "maxDaysRent",
                    title: txtTrans.fields.maxDaysRent,
                    sortable: true,
                    formatter: this.formatter,
                },
                {
                    field: "connectedVehicle",
                    title: txtTrans.fields.connectedVehicle,
                    sortable: true,
                    formatter: this.formatterBoolean,
                },
                {
                    field: "carGroups",
                    title: txtTrans.fields.carGroups,
                    sortable: true,
                    formatter: this.formatter,
                },
                {
                    field: "acriss",
                    title: txtTrans.fields.acriss,
                    sortable: true,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "areaPickUp",
                    title: txtTrans.fields.areaPickUp,
                    sortable: true,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "branchPickUp",
                    title: txtTrans.fields.branchPickUp,
                    sortable: true,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "areaDropOff",
                    title: txtTrans.fields.areaDropOff,
                    sortable: true,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "branchDropOff",
                    title: txtTrans.fields.branchDropOff,
                    sortable: true,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "creationUser",
                    title: txtTrans.fields.creationUser,
                    sortable: true,
                },
                {
                    field: "creationDate",
                    title: txtTrans.fields.creationDate,
                    sortable: true,
                    formatter: this.formatterDate,
                },
                {
                    field: "active",
                    title: txtTrans.fields.active,
                    sortable: true,
                    formatter: this.formatterBoolean,
                },
                {
                    title: txtTrans.form.actions,
                    formatter: this.actionsFormatter,
                    events: {
                        "click .history": (e, value, row) => this.clickHistoryRow(row),
                        "click .edit": (e, value, row) => this.clickEditRow(row),
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
            stopSaleId: null,
        };
    },
    created() {
        this.txt = txtTrans;
    },
    methods: {
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
                        Axios.post(url, formData)
                            .then((response) => {
                                Loading.endLoading();
                                // console.log("Cancel Stop Sale: ", response);
                                if (response.data.cancelled) {
                                    this.showNotification("success", this.txt.form.stopSaleCancelledSuccessNotification);

                                    setTimeout(() => {
                                        // window.location.href = this.routing.generate("stopsale.list", {
                                        //     stopSaleCategory: this.stopSaleName,
                                        // });
                                        window.location.reload();
                                    }, 2000);
                                } else {
                                    this.showNotification("error", this.txt.form.errorCancelingStopSaleNotification);
                                }
                            })
                            .catch((e) => {
                                console.log(e);
                                Loading.endLoading();
                                this.showNotification("error", this.txt.form.errorCancelingStopSaleNotification);
                            });
                    }
                });
        },
        actionsFormatter(row) {
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
