<template>
    <erp-modal :title="`${txt.titles.historyStopSale} ${title} ${stopSaleId}`" id="modal-history-stopSale" :size="modalSize.XXL">
        <template #body>
            <bootstrap-table
                v-if="stopSaleCategoryId === constants.category.standard"
                ref="table"
                :columns="columnsStandard"
                :data="stopSale"
                :options="options"
            />
            <bootstrap-table
                v-if="stopSaleCategoryId === constants.category.oneway"
                ref="table"
                :columns="columnsOneWay"
                :data="stopSale"
                :options="options"
            />
        </template>
    </erp-modal>
</template>

<script>
import Loading from "../../../../assets/js/utilities.js";
import Formatter from "../../../../SharedAssets/js/formatter.js";
import ErpModal from "../../../../SharedAssets/vue/components/modal/ErpModal.vue";
import { MODAL_SIZE } from "../../../helpers/constants";

export default {
    name: "ModalHistoryStopSale",
    components: { ErpModal },
    props: {
        stopSaleId: Number,
        stopSaleCategoryId: Number,
        title: String,
    },
    data() {
        return {
            txt: {},
            constants,
            modalTitle: null,
            modalSize: MODAL_SIZE,
            columnsStandard: [
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
                    sortable: true,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "pickUpBranch",
                    title: txtTrans.fields.branches,
                    sortable: true,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "partners",
                    title: txtTrans.fields.partners,
                    sortable: true,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "sellCodes",
                    title: txtTrans.fields.sellCodes,
                    sortable: true,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "products",
                    title: txtTrans.fields.products,
                    sortable: true,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "carGroups",
                    title: txtTrans.fields.carGroups,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "acriss",
                    title: txtTrans.fields.acriss,
                    sortable: true,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "startTime",
                    title: txtTrans.fields.startTime,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "endTime",
                    title: txtTrans.fields.endTime,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "minDaysRent",
                    title: txtTrans.fields.minDaysRent,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "maxDaysRent",
                    title: txtTrans.fields.maxDaysRent,
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
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "cancellationUser",
                    title: txtTrans.fields.cancellationUser,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "cancellationDate",
                    title: txtTrans.fields.cancellationDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                // {
                //     field: "stopSaleStatus",
                //     title: txtTrans.fields.status,
                //     sortable: true,
                //     formatter: (value) => Formatter.formatField(value),
                // },
            ],
            columnsOneWay: [
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
                    field: "minDaysRent",
                    title: txtTrans.fields.minDaysRent,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "maxDaysRent",
                    title: txtTrans.fields.maxDaysRent,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "connectedVehicle",
                    title: txtTrans.fields.connectedVehicle,
                    sortable: true,
                    formatter: (value) => Formatter.formatBoolean(value),
                },
                {
                    field: "acriss",
                    title: txtTrans.fields.acriss,
                    sortable: true,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "pickUpRegion",
                    title: txtTrans.fields.regionPickUp,
                    sortable: true,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "pickUpArea",
                    title: txtTrans.fields.areaPickUp,
                    sortable: true,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "pickUpBranch",
                    title: txtTrans.fields.branchPickUp,
                    sortable: true,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "dropOffRegion",
                    title: txtTrans.fields.regionDropOff,
                    sortable: true,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "dropOffArea",
                    title: txtTrans.fields.areaDropOff,
                    sortable: true,
                    formatter: (value) => Formatter.trimArray(value),
                },
                {
                    field: "dropOffBranch",
                    title: txtTrans.fields.branchDropOff,
                    sortable: true,
                    formatter: (value) => Formatter.trimArray(value),
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
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "cancellationUser",
                    title: txtTrans.fields.cancellationUser,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "cancellationDate",
                    title: txtTrans.fields.cancellationDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                // {
                //     field: "stopSaleStatus",
                //     title: txtTrans.fields.status,
                //     sortable: true,
                //     formatter: (value) => Formatter.formatField(value),
                // },
            ],
            options: {
                pagination: true,
                locale: "es-ES",
                scrollX: true,
            },
            stopSale: {},
        };
    },
    created() {
        this.txt = txtTrans;
    },
    methods: {
        async getHistory() {
            Loading.starLoading();

            await this.axios
                .get(this.routing.generate("stopsale.history", { id: this.stopSaleId }))
                .then((response) => {
                    Loading.endLoading();
                    this.stopSale = response.data;
                })
                .catch((error) => {
                    console.error(error.response);
                    Loading.endLoading();
                });
        },
    },
    watch: {
        stopSaleId() {
            this.$refs.table.removeAll();
            this.getHistory();
        },
    },
};
</script>

<style scoped></style>
