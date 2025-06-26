<template>
    <fragment>
        <vehicle-list-filter @sendSearch="sendSearch" />

        <alert v-if="errorColumn" @flush="errorColumn = false" type="warning" class="mt-5">
            <template #text>
                <p v-text="txt.form.mustSelectColumn" style="margin: 0"></p>
            </template>
        </alert>

        <div class="kt-portlet kt-portlet--bordered" :style="hidden ? 'display: none' : 'display: block'">
            <div class="kt-portlet__body">
                <div class="kt-align-right mb-2">
                    <button
                        @click="exportCSV"
                        type="button"
                        class="btn btn-dark kt-label-bg-color-4 mb-5"
                        v-text="txt.form.exportExcel"
                    ></button>
                </div>

                <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded">
                    <bootstrap-table ref="table" :columns="columns" :options="options" />
                </div>
            </div>
        </div>
    </fragment>
</template>

<script>
import Loading from "../../../../assets/js/utilities";
import Formatter from "../../../../SharedAssets/js/formatter";
import Alert from "../../../../SharedAssets/vue/components/Alert.vue";

import VehicleListFilter from "./VehicleListFilter.vue";

export default {
    name: "VehicleListPage",
    components: {
        Alert,
        VehicleListFilter,
    },
    data() {
        return {
            count: 0,
            ref: {},
            hiddenColumns: [],
            defaultColumns: ["vin", "licensePlate", "brand", "model", "modelyear"],
            columns: [
                 {
                    field: "vin",
                    title: txtTrans.fields.vin,
                    sortable: true,
                    formatter: (value) => this.vehicleLinkFormatter(value, "vin"),
                    events: {
                        "click .details": (e, value, row) => this.clickDetailsRow(row),
                    },
                },
                {
                    field: "licensePlate",
                    title: txtTrans.fields.licensePlate,
                    sortable: true,
                    formatter: (value) => this.vehicleLinkFormatter(value, "licensePlate"),
                    events: {
                        "click .details": (e, value, row) => this.clickDetailsRow(row),
                    },
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
                    field: "modelyear",
                    title: txtTrans.fields.modelyear,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "trim",
                    title: txtTrans.fields.trim,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "acriss",
                    title: txtTrans.fields.acriss,
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
                    field: "carClass",
                    title: txtTrans.fields.carClass,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "commercialGroup",
                    title: txtTrans.fields.commercialGroup,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "region",
                    title: txtTrans.fields.region,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "area",
                    title: txtTrans.fields.area,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "branch",
                    title: txtTrans.fields.branch,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "location",
                    title: txtTrans.fields.location,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "vehicleStatus",
                    title: txtTrans.fields.status,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "kilometers",
                    title: txtTrans.fields.actualKms,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "provider",
                    title: txtTrans.fields.provider,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "purchaseMethod",
                    title: txtTrans.fields.purchaseMethod,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "purchaseType",
                    title: txtTrans.fields.purchaseType,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "motorizationType",
                    title: txtTrans.fields.motorizationType,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "transmission",
                    title: txtTrans.fields.gearBox,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "vehicleType",
                    title: txtTrans.fields.vehicleType,
                    sortable: true,
                    formatter: (value) => {
                        let formattedValue = Formatter.formatBoolean(value);
                        return formattedValue != "-" ? txtTrans.form[formattedValue] : formattedValue;
                    },
                },
                {
                    field: "connected",
                    title: txtTrans.fields.connectedVehicle,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "firstRegistrationDate",
                    title: txtTrans.fields.firstRegistrationDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "registrationDate",
                    title: txtTrans.fields.registrationDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "deliveryDate",
                    title: txtTrans.fields.deliveryDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "returnDate",
                    title: txtTrans.fields.returnDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "firstRentDate",
                    title: txtTrans.fields.firstRentDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "rentingEndDate",
                    title: txtTrans.fields.rentingEndDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "initBlockDate",
                    title: txtTrans.fields.initBlockageDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "endBlockDate",
                    title: txtTrans.fields.endBlockageDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "movementNumber",
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
                    field: "transportInvoiceNumber",
                    title: txtTrans.fields.transportInvoiceNumber,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "logistic",
                    title: txtTrans.fields.logistic,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "assumedCostBy",
                    title: txtTrans.fields.assumedCostBy,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "actualLoadingDate",
                    title: txtTrans.fields.actualLoadingDate,
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
                    field: "resaleCode",
                    title: txtTrans.fields.saleMethod,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "salesCustomer",
                    title: txtTrans.fields.salesCustomer,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "conditioned",
                    title: txtTrans.fields.conditioned,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "rentalAgreementPickUpDate",
                    title: txtTrans.fields.rentalAgreementPickUpDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "rentalAgreementDropOffDate",
                    title: txtTrans.fields.rentalAgreementDropOffDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "byeByeDate",
                    title: txtTrans.fields.byeByeDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "actions",
                    title: txtTrans.form.actions,
                    formatter: (value) => this.vehicleLinkFormatter(value, "actions"),
                    events: {
                        "click .details": (e, value, row) => this.clickDetailsRow(row),
                    },
                    width: 160,
                },
            ],
            options: {
                sidePagination: "server",
                ajax: this.ajaxRequest,
                pagination: true,
                locale: "es-ES",
            },
            url: this.routing.generate("vehicle.filter"),
            hidden: true,
            headers: [],
            items: null,
            search: "",
            errorColumn: false,
            queryString: null,
            txt: {},
        };
    },
    created() {
        this.txt = txtTrans;
    },
    methods: {
        sendSearch() {
            this.headers = this.$store.getters["filter/columns"];

            this.defaultColumns.forEach((item) => {
                if (!this.headers.includes(item)) {
                    this.headers.push(item);
                }
            });

            if (this.headers.length === 0) {
                this.errorColumn = true;
            }
        },
        hiddenHeader() {
            this.hidden = true;
            this.$refs.table.hideAllColumns();
        },
        exportCSV() {
            let url = this.routing.generate("vehicle.downloadExcel");
            let columns = encodeURIComponent(JSON.stringify(this.$store.getters["filter/columns"]));
            let query = `?${this.queryString}&columns=${columns}`;

            Loading.starLoading();
            this.axios
                .get(url + query, {
                    responseType: "blob",
                })
                .then((response) => {
                    Loading.endLoading();

                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute("download", "vehicle_list.csv");
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
        clickDetailsRow(row) {
            location.href = this.routing.generate("vehicle.details", { licensePlate: row.licensePlate });
        },
        ajaxRequest(params) {
            if (this.items !== null) {
                Loading.starLoading();
                this.hiddenHeader();
                this.axios.get(this.getUrlByFilter(params)).then((resp) => {
                    params.success(resp.data, null, {});
                    if (this.headers.length !== 0) {
                        if (!this.headers.includes("licensePlate") && !this.headers.includes("vin")) {
                            this.headers.push("actions");
                        }
                        this.headers.forEach((item) => {
                            this.$refs.table.showColumn(item);
                        });
                        this.$store.commit("filter/count", resp.data.rows.length);
                        this.hidden = false;
                    }
                    Loading.endLoading();
                });
            }
        },
        getUrlByFilter(params) {
            let queryString = "";
            this.getParameterFilterSearch(params);
            queryString = this.getParameterFilterInputs(queryString);
            queryString += Object.keys(params.data)
                .map((key) => key + "=" + params.data[key])
                .join("&");
            this.queryString = queryString;
            return `${this.url}?${queryString}`;
        },
        getParameterFilterSearch(params) {
            if (this.search !== "") {
                params.data.search = this.search;
            }
        },
        getParameterFilterInputs(queryString) {
            if (this.items) {
                queryString =
                    Object.keys(this.items)
                        .map((key) => {
                            if (Array.isArray(this.items[key])) {
                                return `${key}=${JSON.stringify(this.items[key])}`;
                            } else {
                                return `${key}=${this.items[key]}`;
                            }
                        })
                        .join("&") + "&";
            }
            return queryString;
        },
        vehicleLinkFormatter(value, field) {
            switch (field) {
                case "licensePlate":
                    return this.headers.includes(field) || (this.headers.includes(field) && this.headers.includes("vin"))
                        ? `<a href="javascript:void(0)" class="details" title="${
                              txtTrans.form.viewVehicleDetails
                          }">${Formatter.formatField(value)}</a>`
                        : Formatter.formatField(value);
                case "vin":
                    return this.headers.includes(field) && !this.headers.includes("licensePlate")
                        ? `<a href="javascript:void(0)" class="details" title="${
                              txtTrans.form.viewVehicleDetails
                          }">${Formatter.formatField(value)}</a>`
                        : Formatter.formatField(value);
                case "actions":
                    if (!this.headers.includes("licensePlate") && !this.headers.includes("vin")) {
                        return `<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md details" title="${txtTrans.form.viewVehicleDetails}"><i class="flaticon-eye"></i></a>`;
                    }
                    break;
            }
        },
    },
    watch: {
        "$store.state.filter.search": function() {
            console.log("Store search");
            this.search = this.$store.getters["filter/search"];
            this.$refs.table.refresh();
        },
        "$store.state.filter.items": function() {
            this.items = this.$store.getters["filter/items"];
            this.headers = this.$store.getters["filter/columns"];

            this.$store.commit("filter/count", 0);
            if (this.headers.length === 0 && Object.keys(this.items).length > 0) {
                this.hidden = true;
                this.errorColumn = true;
            } else if (this.headers.length === 0 && Object.keys(this.items).length === 0) {
                this.hidden = true;
            } else {
                this.errorColumn = false;
                this.$refs.table.refresh();
            }
        },
        "$store.state.filter.columns": function() {
            this.items = this.$store.getters["filter/items"];
            this.headers = this.$store.getters["filter/columns"];

            if (this.headers.length === 0 && Object.keys(this.items).length > 0) {
                this.hidden = true;
                this.errorColumn = true;
                this.$store.commit("filter/count", 0);
            }
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
