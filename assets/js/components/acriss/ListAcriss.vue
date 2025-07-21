<template>
    <div class="kt-portlet kt-portlet--bordered">
        <div class="kt-portlet__body">
            <erp-filter>
                <erp-multiple-select-picker-filter
                    name="commercialGroupIds"
                    id="commercialGroupIds"
                    div-class="col-md-4 form-group"
                    :label="txt.fields.commercialGroup"
                    :options="selectList.commercialGroupList"
                />

                <erp-multiple-select-picker-filter
                    name="carGroupIds"
                    id="carGroupIds"
                    div-class="col-md-4 form-group"
                    :label="txt.fields.carGroup"
                    :options="selectList.carGroupList"
                />

                <erp-multiple-select-picker-filter
                    name="carClassIds"
                    id="carClassIds"
                    div-class="col-md-4 form-group"
                    :label="txt.fields.carClass"
                    :options="selectList.carClassList"
                />

                <erp-input-base-filter
                    name="acrissName"
                    id="acrissName"
                    div-class="col-md-4 form-group"
                    :label="txt.fields.acrissCode"
                    :value="null"
                />

                <erp-multiple-select-picker-filter
                    name="acrissTypeIds"
                    id="acrissTypeIds"
                    div-class="col-md-4 form-group"
                    :label="txt.fields.acrissType"
                    :options="selectList.acrissTypeList"
                />

                <erp-multiple-select-picker-filter
                    name="motorizationTypeIds"
                    id="motorizationTypeIds"
                    div-class="col-md-4 form-group"
                    :label="txt.fields.motorizationType"
                    :options="selectList.motorizationTypeList"
                />

                <erp-multiple-select-picker-filter
                    name="gearBoxIds"
                    id="gearBoxIds"
                    div-class="col-md-4 form-group"
                    :label="txt.fields.gearBox"
                    :options="selectList.gearBoxList"
                />

                <erp-single-select-picker-filter
                    name="status"
                    id="status"
                    div-class="col-md-4 form-group"
                    :label="txt.fields.status"
                    :options="selectList.statusList"
                    :value="null"
                />
            </erp-filter>

            <div class="kt-align-right mb-2">
                <button @click="goToCreate" type="button" class="btn btn-dark kt-label-bg-color-4 mb-5">
                    <i class="la la-plus"></i>
                    {{ txt.form.createAcriss }}
                </button>
            </div>
            <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded">
                <erp-ajax-table id="acrissTable" :url="routing.generate('acriss.filter')" :columns="columns" :options="options" />
            </div>
        </div>
    </div>
</template>

<script>
import ErpFilter from "../filter/ErpFilter.vue";

import Formatter from "../../../SharedAssets/js/formatter";
import ErpInputBaseFilter from "../../../SharedAssets/vue/components/filter/form/ErpInputBaseFilter.vue";
import ErpMultipleSelectPickerFilter from "../../../SharedAssets/vue/components/filter/form/ErpMultipleSelectPickerFilter.vue";
import ErpSingleSelectPickerFilter from "../../../SharedAssets/vue/components/filter/form/ErpSingleSelectPickerFilter.vue";
import ErpAjaxTable from "../../../SharedAssets/vue/components/table/ErpAjaxTable.vue";

export default {
    name: "ListAcriss",
    components: {
        ErpFilter,
        ErpInputBaseFilter,
        ErpMultipleSelectPickerFilter,
        ErpSingleSelectPickerFilter,
        ErpAjaxTable,
    },
    props: {
        selectList: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            txt: txtTrans,

            columns: [
                {
                    field: "name",
                    title: txtTrans.fields.acriss,
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
                    field: "acrissType",
                    title: txtTrans.fields.acrissType,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "gearBox",
                    title: txtTrans.fields.gearBox,
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
                    field: "commercialGroup",
                    title: txtTrans.fields.commercialGroup,
                    sortable: true,
                    formatter: (value) => Formatter.formatArray(value),
                },
                {
                    field: "carGroup",
                    title: txtTrans.fields.carGroup,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "status",
                    title: txtTrans.fields.status,
                    sortable: true,
                    formatter: this.formatterBoolean,
                },
                {
                    title: txtTrans.fields.actions,
                    formatter: this.actionsFormatter,
                    events: {
                        "click .show": (e, value, row) => this.clickShowRow(row),
                    },
                    width: 160,
                },
            ],
            options: {
                pagination: true,
                pageSize: 50,
                pageList: [25, 50, 100],
                locale: "es-ES",
                scrollX: true,
                fixedScroll: true,
                height: "65vh",
            },
        };
    },
    methods: {
        goToCreate() {
            location.href = this.routing.generate("acriss.create");
        },
        formatterBoolean(value) {
            return typeof value === "boolean" ? (value ? this.txt.form.enabled : this.txt.form.disabled) : "-";
        },
        actionsFormatter() {
            let actions = [
                '<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md show" title="Show"><em class="flaticon-eye"></em></a>',
            ];
            return actions.join("");
        },
        clickShowRow(row) {
            location.href = this.routing.generate("acriss.show", { id: row.id });
        },
    },
};
</script>

<style scoped></style>
