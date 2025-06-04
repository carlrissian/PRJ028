<template>
    <erp-modal id="associate-acriss-list" :closable="false">
        <template #body>
            <erp-ajax-table
                v-if="associtationType === SUPERIOR"
                @check="check($event)"
                ref="acrissAssociationTable"
                id="acrissAssociationTable"
                :url="routing.generate('acriss.associate.filter', { acrissId: acriss.id })"
                :columns="columns"
                :options="options"
            />
        </template>

        <template #footer> </template>
    </erp-modal>
</template>

<script>
export const SUPERIOR = "superior";
export const INFERIOR = "inferior";

import Formatter from "../../../../SharedAssets/js/formatter";
import ErpModal from "../../../../SharedAssets/vue/components/modal/ErpModal.vue";
import ErpAjaxTable from "../../../../SharedAssets/vue/components/table/ErpAjaxTable.vue";

export default {
    name: "AssociateAcrissModalForm",
    components: {
        ErpAjaxTable,
        ErpModal,
    },
    props: {
        acriss: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            txt: {},
            isAcrissChecked: false,
            ids: [],
            acrissSelected: 0,
            // TODO revisar qué campos mostrar. Ver MovementAssignedVehicles para checkbox y demás lógica.
            columns: [
                {
                    field: "checked",
                    sortable: false,
                    checkbox: true,
                },
                {
                    field: "id",
                    title: txtTrans.fields.xxx,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "id",
                    title: txtTrans.fields.xxx,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "id",
                    title: txtTrans.fields.xxx,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
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
        check(table) {
            let items = table.getAllSelections();
            this.acrissSelected = items.length;
            this.isAcrissChecked = items.length > 0;
            this.ids = items.map((item) => item.id);
        },
    },
};
</script>

<style scoped></style>
