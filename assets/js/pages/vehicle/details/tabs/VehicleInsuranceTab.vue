<template>
    <p v-if="notInsurancesAvailables" class="text-center" v-text="txt.form.noVehicleInsurancesAvailable"></p>
    <erp-ajax-table
        v-else
        @items="items = $event"
        :url="routing.generate('vehicle.insurance.list')"
        :columns="columns"
        :options="options"
        :parameter-default="{ vehicleId: vehicleId }"
    />
</template>

<script>
import Formatter from "../../../../../SharedAssets/js/formatter";
import ErpAjaxTable from "../../../../../SharedAssets/vue/components/table/ErpAjaxTable.vue";

export default {
    name: "VehicleInsuranceTab",
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
                    field: "policyCompany",
                    title: txtTrans.fields.policyCompany,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "policyBroker",
                    title: txtTrans.fields.policyBroker,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "policyNumber",
                    title: txtTrans.fields.policyNumber,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "policyType",
                    title: txtTrans.fields.policyType,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "activationDate",
                    title: txtTrans.fields.activationDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "finishDate",
                    title: txtTrans.fields.finishDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "policyStatus",
                    title: txtTrans.fields.policyStatus,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
            ],
            options: {
                pagination: true,
                pageSize: 30,
                locale: "es-ES",
                scrollX: true,
            },
            txt: txtTrans,
            items: null,
        };
    },
    computed: {
        notInsurancesAvailables() {
            return typeof this.items === "object" && this.items?.rows.length === 0;
        },
    },
};
</script>

<style scoped></style>
