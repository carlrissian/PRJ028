<template>
    <fragment>
        <parameter-setting-list-filter />
        <div class="kt-portlet kt-portlet--bordered">
            <div class="kt-portlet__body">
                <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded">
                    <erp-ajax-table :url="routing.generate('parameterSettings.filter')" :columns="columns" :options="options" />
                </div>
            </div>
        </div>
    </fragment>
</template>

<script>
import Axios from "axios";
import Loading from "../../../../assets/js/utilities";
import Formatter from "../../../../SharedAssets/js/formatter";
import ErpAjaxTable from "../../../../SharedAssets/vue/components/table/ErpAjaxTable.vue";
import ParameterSettingListFilter from "./ParameterSettingListFilter.vue";

export default {
    name: "ParameterSettingListPage",
    components: {
        ErpAjaxTable,
        ParameterSettingListFilter,
    },
    data() {
        return {
            txt: txtTrans,
            columns: [
                {
                    field: "id",
                    title: txtTrans.fields.id,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                // {
                //     field: "region",
                //     title: txtTrans.fields.region,
                //     sortable: true,
                //     formatter: (value) => Formatter.formatField(value),
                // },
                // {
                //     field: "area",
                //     title: txtTrans.fields.area,
                //     sortable: true,
                //     formatter: (value) => Formatter.formatField(value),
                // },
                {
                    field: "branch",
                    title: txtTrans.fields.branch,
                    sortable: true,
                    formatter: (value) => Formatter.formatArray(value),
                },
                {
                    field: "parameterSettingType",
                    title: txtTrans.fields.parameterType,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "startDate",
                    title: txtTrans.fields.startDate,
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
                    field: "startTime",
                    title: txtTrans.fields.startTime,
                    sortable: true,
                },
                {
                    field: "endTime",
                    title: txtTrans.fields.endTime,
                    sortable: true,
                },
                {
                    field: "carGroup",
                    title: txtTrans.fields.parameterGroup,
                    sortable: true,
                    // formatter: (value) => Formatter.formatArray(value),
                },
                {
                    field: "acriss",
                    title: txtTrans.fields.parameterAcriss,
                    sortable: true,
                    formatter: (value) => Formatter.formatArray(value),
                },
                {
                    field: "parameter",
                    title: txtTrans.fields.parameter,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "replacementGroup",
                    title: txtTrans.fields.substitutionGroup,
                    sortable: true,
                    // formatter: (value) => Formatter.formatArray(value),
                },
                {
                    field: "replacementAcriss",
                    title: txtTrans.fields.substitutionAcriss,
                    sortable: true,
                    formatter: (value) => Formatter.formatArray(value),
                },
                {
                    field: "partner",
                    title: txtTrans.fields.partner,
                    sortable: true,
                    formatter: this.formatPartner,
                },
                // {
                //     field: "connectedVehicle",
                //     title: txtTrans.fields.connectedVehicle,
                //     sortable: true,
                //     formatter: (value) => {
                //         let formattedValue = Formatter.formatBoolean(value);
                //         return formattedValue != "-" ? txtTrans.form[formattedValue] : txtTrans.form.all;
                //     },
                // },
                {
                    field: "creationUser",
                    title: txtTrans.fields.creationUser,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "creationDate",
                    title: txtTrans.fields.creationDate,
                    formatter: (value) => Formatter.formatDateTime(value),
                },
                {
                    title: txtTrans.form.actions,
                    formatter: this.actionsFormatter,
                    events: {
                        "click .delete": (e, value, row, index) => {
                            this.clickDelete(row);
                        },
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
        };
    },
    methods: {
        formatPartner(value) {
            return `<a href="#" title="${Formatter.formatArray(value)}">${value.length} <i class="la la-eye"></i></a>`;
        },
        actionsFormatter() {
            let actions = [
                ` <button class="btn btn-sm btn-clean btn-icon btn-icon-md delete" title="${txtTrans.form.delete}"><i class="flaticon-delete"></i></button>`,
            ];
            return actions.join("");
        },
        clickDelete(row) {
            window.swal
                .fire({
                    title: this.txt.form.deleteParameterSetting,
                    text: this.txt.form.thisChangeCannotBeRevert,
                    icon: "warning",
                    confirmButtonText: this.txt.form.delete,
                    confirmButtonColor: "#48465b",
                    showCancelButton: true,
                    cancelButtonText: this.txt.form.cancel,
                    cancelButtonColor: "#d33",
                })
                .then((result) => {
                    if (result.value) {
                        Loading.starLoading();
                        let formData = new FormData();
                        formData.set("id", row.id);
                        let url = this.routing.generate("parameterSettings.delete", {
                            id: row.id,
                        });
                        Axios.post(url, formData)
                            .then((response) => {
                                if (response.data.deleted) {
                                    this.$notify({
                                        text: this.txt.form.parameterSettingDeletedSuccessNotification,
                                        type: "success",
                                    });
                                    this.$store.commit(`filter/items`, {});
                                } else {
                                    Loading.endLoading();
                                    this.$notify({
                                        text: this.txt.form.errorDeletingParameterSetting,
                                        type: "error",
                                    });
                                }
                            })
                            .catch((error) => {
                                Loading.endLoading();
                                let errorMessage = this.txt.form.errorDeletingParameterSetting;
                                if (error.response.status === 460) {
                                    errorMessage += error.response.data.message;
                                }
                                this.$notify({
                                    text: errorMessage,
                                    type: "error",
                                });
                            });
                    }
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
