<template>
    <erp-filter>
        <!-- <erp-select-filter
            name="transportMethodId"
            id="transportMethodId"
            div-class="col-md-3"
            :label="txt.fields.transportMethod"
            :options="selectList.transportMethodList"
        >
            <option v-for="item in selectList.transportMethodList" :key="item.id" :value="item.id" v-text="item.name"></option>
        </erp-select-filter> -->

        <erp-select-filter
            name="providerId"
            id="providerId"
            div-class="col-md-3"
            :label="txt.fields.provider"
            :options="selectList.providerList"
        >
            <option v-for="item in selectList.providerList" :key="item.id" :value="item.id" v-text="item.name"></option>
        </erp-select-filter>

        <erp-select-filter
            name="originBranchId"
            id="originBranchId"
            div-class="col-md-3"
            :label="txt.fields.originBranch"
            :options="selectList.branchList"
        >
            <option v-for="item in selectList.branchList" :key="item.id" :value="item.id" v-text="item.name"></option>
        </erp-select-filter>

        <erp-select-filter
            name="destinationBranchId"
            id="destinationBranchId"
            div-class="col-md-3"
            :label="txt.fields.destinationBranch"
            :options="selectList.branchList"
        >
            <option v-for="item in selectList.branchList" :key="item.id" :value="item.id" v-text="item.name"></option>
        </erp-select-filter>
    </erp-filter>
</template>

<script>
// FIXME el ErpFilter de Shared no funciona correctamente
// import ErpFilter from "../../../../../SharedAssets/vue/components/filter/ErpFilter";
import ErpFilter from "../../../../components/filter/ErpFilter.vue";
import ErpSelectFilter from "../../../../components/filter/form/ErpSelectFilter.vue";

export default {
    name: "ListRouteFilter",
    components: {
        ErpFilter,
        ErpSelectFilter,
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
};
</script>

<style scoped></style>
