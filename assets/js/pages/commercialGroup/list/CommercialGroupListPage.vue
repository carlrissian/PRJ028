<template>
    <div>
        <div class="kt-container">
            <div class="kt-portlet kt-portlet--bordered">
                <div class="kt-portlet__body">
                    <commercial-group-list-filter />

                    <div class="kt-align-right mb-2">
                        <button
                            @click="createCommercialGroupPage"
                            type="button"
                            class="btn btn-dark kt-label-bg-color-4 mb-5"
                            v-text="txt.titles.createCommercialGroup"
                        ></button>
                    </div>

                    <div
                        class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded"
                    >
                        <erp-ajax-table
                            id="dataTable"
                            :url="routing.generate('commercialgroup.filter')"
                            :columns="columns"
                            :options="options"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ErpAjaxTable from "../../../components/table/ErpAjaxTable";
import CommercialGroupListFilter from "./CommercialGroupListFilter";

export default {
    name: "CommercialGroupListPage",
    components: {
        ErpAjaxTable,
        CommercialGroupListFilter,
    },
    data() {
        return {
            txt: {},
            row: {},
            columns: [
                {
                    field: "name",
                    title: txtTrans.fields.commercialGroup,
                    sortable: true,
                },
                {
                    field: "acrissName",
                    title: txtTrans.fields.acriss,
                    sortable: true,
                },
                {
                    field: "status",
                    title: txtTrans.fields.status,
                    sortable: true,
                    formatter: this.formatterStatus,
                },
                {
                    title: txtTrans.form.actions,
                    formatter: this.actionsFormatter,
                    events: {
                        "click .details": (e, value, row) =>
                            this.clickDetails(row),
                        "click .delete": (e, value, row) =>
                            this.clickDelete(row),
                    },
                    width: 160,
                },
            ],
            options: {
                pagination: true,
                locale: "es-ES",
                scrollX: true,
            },
        };
    },
    created() {
        this.txt = txtTrans;
    },
    methods: {
        createCommercialGroupPage() {
            window.location.href = this.routing.generate(
                "commercialgroup.create"
            );
        },
        formatterStatus(value) {
            return value == true
                ? this.txt.form.activated
                : this.txt.form.deactivated;
        },
        actionsFormatter() {
            let actions = [
                ` <button class="btn btn-sm btn-clean btn-icon btn-icon-md details" title="${txtTrans.form.viewDetails}"><i class="flaticon-eye"></i></button>`,
                ` <button class="btn btn-sm btn-clean btn-icon btn-icon-md delete" title="${txtTrans.form.delete}"><i class="flaticon-delete"></i></button>`,
            ];
            return actions.join("");
        },
        clickDetails(row) {
            window.location.href = this.routing.generate(
                "commercialgroup.details",
                {
                    id: row.id,
                }
            );
        },
        async clickDelete(row) {
            window.swal
                .fire({
                    title: this.txt.form.deleteCommercialGroup,
                    text: this.txt.form.thisChangeCannotBeRevert,
                    type: "warning",
                    confirmButtonText: this.txt.form.delete,
                    confirmButtonColor: "#48465b",
                    showCancelButton: true,
                    cancelButtonText: this.txt.form.cancel,
                    cancelButtonColor: "#d33",
                })
                .then((result) => {
                    if (result.value) {
                        let formData = new FormData();
                        formData.set("id", id);
                        let url = this.routing.generate(
                            "commercialgroup.delete",
                            {
                                id: row.id,
                            }
                        );
                        Axios.post(url, formData)
                            .then((response) => {
                                // console.log("Delete CommercialGroup: ", response);
                                if (response.data.deleted) {
                                    this.showNotification(
                                        "success",
                                        this.txt.form
                                            .commercialGroupDeletedSuccessNotification
                                    );

                                    this.$store.commit(`filter/items`, {});
                                } else {
                                    this.showNotification(
                                        "error",
                                        this.txt.form
                                            .errorDeletingCommercialGroupNotification
                                    );
                                }
                            })
                            .catch((e) => {
                                console.log(e);
                            });
                    }
                });
        },
    },
};
</script>

<style scoped></style>
