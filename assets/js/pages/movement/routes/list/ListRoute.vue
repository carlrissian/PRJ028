<template>
    <fragment>
        <list-route-filter :select-list="selectList" />

        <div class="kt-portlet kt-portlet--bordered">
            <div class="kt-portlet__body">
                <div class="kt-align-right mb-2">
                    <button
                        @click="goToCreate"
                        type="button"
                        class="btn btn-dark kt-label-bg-color-4 mb-5"
                        v-text="txt.form.createRoute"
                    ></button>
                </div>
                <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded">
                    <erp-ajax-table :url="routing.generate('routes.filter')" :columns="columns" :options="options" />
                </div>
            </div>
        </div>
    </fragment>
</template>

<script>
import Formatter from "../../../../../SharedAssets/js/formatter";
import ErpAjaxTable from "../../../../../SharedAssets/vue/components/table/ErpAjaxTable.vue";
import ListRouteFilter from "./ListRouteFilter.vue";

export default {
    name: "ListRoute",
    components: {
        ListRouteFilter,
        ErpAjaxTable,
    },
    props: {
        selectList: {
            type: Object,
            required: true,
        },
    },
    created() {
        this.txt = txtTrans;
    },
    data() {
        return {
            txt: {},
            columns: [
                {
                    field: "transportMethod",
                    title: txtTrans.fields.transportMethod,
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
                    field: "originBranch",
                    title: txtTrans.fields.originBranch,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "destinationBranch",
                    title: txtTrans.fields.destinationBranch,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "fullTruckLoadAmount",
                    title: txtTrans.fields.fullTruckLoadAmount,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "vehicleAmount1",
                    title: txtTrans.fields.vehicleAmount1,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "vehicleAmount2",
                    title: txtTrans.fields.vehicleAmount2,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "vehicleAmount3",
                    title: txtTrans.fields.vehicleAmount3,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "vehicleAmount4",
                    title: txtTrans.fields.vehicleAmount4,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "vehicleAmount5",
                    title: txtTrans.fields.vehicleAmount5,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "vehicleAmount6",
                    title: txtTrans.fields.vehicleAmount6,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "vehicleAmount7",
                    title: txtTrans.fields.vehicleAmount7,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "vehicleAmount8",
                    title: txtTrans.fields.vehicleAmount8,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "vehicleAmount9",
                    title: txtTrans.fields.vehicleAmount9,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "vehicleAmount10",
                    title: txtTrans.fields.vehicleAmount10,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "sUVLoadAmount",
                    title: txtTrans.fields.suvLoadAmount,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "vanLoadAmount",
                    title: txtTrans.fields.vanLoadAmount,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
            ],
            options: {
                pagination: true,
                locale: "es-ES",
            },
        };
    },
    methods: {
        goToCreate() {
            location.href = this.routing.generate("routes.create.excel");
        },
    },
};
</script>

<style scoped></style>
