<template>
    <erp-ajax-table
        :url="routing.generate('vehicle.anticipations.list')"
        :columns="columns"
        :options="options"
        :parameter-default="{ vehicleId: vehicleId }"
    />
</template>

<script>
import Formatter from "../../../../../SharedAssets/js/formatter";
import ErpAjaxTable from "../../../../../SharedAssets/vue/components/table/ErpAjaxTable";

export default {
    name: "VehicleAnticipationsTab",
    components: {
        ErpAjaxTable,
    },
    props: {
        vehicleId: Number,
    },
    data() {
        return {
            columns: [
                {
                    field: "movementId",
                    title: txtTrans.fields.movementId,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "originLocation",
                    title: txtTrans.fields.originLocation,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "destinationLocation",
                    title: txtTrans.fields.destinationLocation,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "expectedLoadDate",
                    title: txtTrans.fields.expectedLoadDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "expectedUnloadDate",
                    title: txtTrans.fields.expectedUnloadDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "",
                    title: txtTrans.fields.businessUnitArticle,
                    sortable: true,
                    formatter: (value, row) => Formatter.concatFields(row.businessUnitName, row.businessUnitArticleName),
                },
            ],
            options: { pagination: true, locale: "es-ES" },
            data: null,
        };
    },
};
</script>

<style scoped></style>
