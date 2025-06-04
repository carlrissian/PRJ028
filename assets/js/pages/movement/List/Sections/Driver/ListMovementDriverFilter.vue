<template>
    <erp-filter>
        <erp-input-base-filter
            @onInputChangeInput="onInputChange($event, 'orderMovement')"
            ref="orderMovement"
            name="orderMovement"
            id="orderMovement"
            divClass="col-md-3"
            :label="txt.fields.movementNumber"
            regex="^\d+(?:,\s?\d+)*,?\s?$"
        />
        <erp-input-base-filter
            @onInputChangeInput="onInputChange($event, 'orderNumber')"
            ref="orderNumber"
            name="orderNumber"
            id="orderNumber"
            divClass="col-md-3"
            :label="txt.fields.orderNumber"
            regex="^\d+(?:,\s?\d+)*,?\s?$"
        />
        <erp-input-base-filter divClass="col-md-3" name="licensePlate" id="licensePlate" :label="txt.fields.licensePlate" />

        <erp-select-filter
            class-number="3"
            name="isExtTransport"
            id="isExtTransport"
            :label="txt.fields.isExtTransport"
            :options="selectList.extTransportList"
        />

        <erp-multiple-select-filter
            class-number="3"
            :label="txt.fields.movementCategory"
            name="movementCategory"
            id="movementCategory"
            :data-for-ajax="selectList.movementCategoryList"
        />
        <erp-multiple-select-filter
            class-number="3"
            :label="txt.fields.provider"
            name="supplierCode"
            id="supplierCode"
            :data-for-ajax="selectList.supplierList"
        />
        <erp-multiple-select-filter
            class-number="3"
            :label="txt.fields.brand"
            name="brandId"
            id="brandId"
            :data-for-ajax="selectList.brandList"
        />
        <erp-multiple-select-filter
            class-number="3"
            :label="txt.fields.model"
            name="modelId"
            id="modelId"
            :data-for-ajax="selectList.modelList"
        />

        <erp-multiple-select-filter
            class-number="3"
            :label="txt.fields.originBranch"
            name="originBranchId"
            id="originBranchId"
            :data-for-ajax="selectList.branchList"
        />
        <erp-multiple-select-filter
            class-number="3"
            :label="txt.fields.originLocation"
            name="originLocationId"
            id="originLocationId"
            :data-for-ajax="selectList.locationList"
        />
        <erp-multiple-select-filter
            class-number="3"
            :label="txt.fields.destinationBranch"
            name="destinationBranchId"
            id="destinationBranchId"
            :data-for-ajax="selectList.branchList"
        />
        <erp-multiple-select-filter
            class-number="3"
            :label="txt.fields.destinationLocation"
            name="destinationLocationId"
            id="destinationLocationId"
            :data-for-ajax="selectList.locationList"
        />

        <erp-multiple-select-filter
            class-number="3"
            :label="txt.fields.businessUnit"
            name="businessUnitId"
            id="businessUnitId"
            :data-for-ajax="selectList.businessUnitList"
        />
        <erp-multiple-select-filter
            class-number="3"
            :label="txt.fields.businessUnitArticle"
            name="businessUnitArticleId"
            id="businessUnitArticleId"
            :data-for-ajax="selectList.businessUnitArticleList"
        />
        <erp-date-picker-filter
            class-number="col-md-3"
            @updateDatePicker="changedPicker('actualLoadDateFrom', 'actualLoadDateTo', $event)"
            name="actualLoadDateFrom"
            id="actualLoadDateFrom"
            :label="txt.fields.actualLoadDateFrom"
            :limit-end-day="dates.actualLoadDateTo"
        />
        <erp-date-picker-filter
            class-number="col-md-3"
            @updateDatePicker="changedPicker('actualLoadDateFrom', 'actualLoadDateTo', $event)"
            name="lactualLadDateTo"
            id="actualLoadDateTo"
            :label="txt.fields.actualLoadDateTo"
            :limit-start-day="dates.actualLoadDateFrom"
        />

        <erp-date-picker-filter
            class-number="col-md-3"
            @updateDatePicker="changedPicker('expectedUnloadDateFrom', 'expectedUnloadDateTo', $event)"
            name="expectedUnloadDateFrom"
            id="expectedLoadDate"
            :label="txt.fields.expectedUnloadDateFrom"
            :limit-end-day="dates.expectedUnloadDateTo"
        />
        <erp-date-picker-filter
            class-number="col-md-3"
            @updateDatePicker="changedPicker('expectedUnloadDateFrom', 'expectedUnloadDateTo', $event)"
            name="expectedUnloadDateTo"
            id="expectedUnloadDate"
            :label="txt.fields.expectedUnloadDateTo"
            :limit-start-day="dates.expectedUnloadDateFrom"
        />
        <erp-date-picker-filter
            class-number="col-md-3"
            @updateDatePicker="changedPicker('actualUnloadDateFrom', 'actualUnloadDate', $event)"
            name="actualUnloadDateFrom"
            id="actualUnloadDateFrom"
            :label="txt.fields.actualUnloadDateFrom"
            :limit-end-day="dates.actualUnloadDateTo"
        />
        <erp-date-picker-filter
            class-number="col-md-3"
            @updateDatePicker="changedPicker('actualUnloadDateFrom', 'actualUnloadDateTo', $event)"
            name="actualUnloadDateTo"
            id="actualUnloadDateTo"
            :label="txt.fields.actualUnloadDateTo"
            :limit-start-day="dates.actualUnloadDateFrom"
        />

        <erp-select-filter
            class-number="3"
            name="movementStatusId"
            id="movementStatusId"
            :label="txt.fields.movementStatus"
            :options="selectList.movementStatusList"
        />
    </erp-filter>
</template>

<script>
// FIXME el de Shared no funciona correctamente, no recoge bien algunos labels, y recoge inputs de búsqueda
// import ErpFilter from "../../../../../../SharedAssets/vue/components/filter/ErpFilter.vue"
import ErpFilter from "../../../../../components/filter/ErpFilter.vue";
import ErpInputBaseFilter from "../../../../../../SharedAssets/vue/components/filter/form/ErpInputBaseFilter.vue";
import ErpInputNumberFilter from "../../../../../../SharedAssets/vue/components/filter/form/ErpInputNumberFilter.vue";
import ErpDatePickerFilter from "../../../../../components/filter/form/ErpDatePickerFilter.vue";
import ErpMultipleSelectFilter from "../../../../../components/filter/form/ErpMultipleSelectFilter.vue";
import ErpSelectFilter from "../../../../../components/filter/form/ErpSelectFilter.vue";

export default {
    name: "ListMovementDriverFilter",
    components: {
        ErpFilter,
        ErpDatePickerFilter,
        ErpInputBaseFilter,
        ErpInputNumberFilter,
        ErpMultipleSelectFilter,
        ErpSelectFilter,
    },
    props: {
        selectList: Object,
        movementTypeId: Number,
    },
    data() {
        return {
            txt: {},
            dates: {
                expectedLoadDateTo: null,
                expectedLoadDateFrom: null,
                expectedUnloadDateTo: null,
                expectedUnloadDateFrom: null,
                actualLoadDateTo: null,
                actualLoadDateFrom: null,
                actualUnloadDateTo: null,
                actualUnloadDateFrom: null,
            },
            kilometersFrom: null,
            kilometersTo: null,
        };
    },
    created() {
        this.txt = txtTrans;
    },
    methods: {
        changedPicker(dateFrom, dateTo, e) {
            let { name, value } = e.target;
            if (value) {
                switch (name) {
                    case dateTo:
                        this.dates[dateTo] = value;
                        break;
                    case dateFrom:
                        this.dates[dateFrom] = value;
                        break;
                }
            } else {
                if (name === dateTo) {
                    this.dates[dateTo] = null;
                }
            }
        },
        onInputChange(e, ref) {
            if (this.$refs[ref].regex && !new RegExp(this.$refs[ref].regex).test(e.target.value)) {
                this.$refs[ref].data = e.target.value.slice(0, -1);
            }
        },
    },
};
</script>

<style scoped></style>
