<template>
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
</template>

<script>
import ErpFilter from "../../../components/filter/ErpFilter.vue";
import ErpInputBaseFilter from "../../../../SharedAssets/vue/components/filter/form/ErpInputBaseFilter.vue";
import ErpMultipleSelectPickerFilter from "../../../../SharedAssets/vue/components/filter/form/ErpMultipleSelectPickerFilter.vue";
import ErpSingleSelectPickerFilter from "../../../../SharedAssets/vue/components/filter/form/ErpSingleSelectPickerFilter.vue";

export default {
    name: "AcrissListFilter",
    components: {
        ErpFilter,
        ErpInputBaseFilter,
        ErpMultipleSelectPickerFilter,
        ErpSingleSelectPickerFilter,
    },
    props: {
        selectList: Object,
    },
    data() {
        return {
            txt: {},
        };
    },
    created() {
        this.txt = txtTrans;
    },
};
</script>

<style scoped></style>
