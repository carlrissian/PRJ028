<template>
    <erp-filter :show-count="false">
        <erp-single-select-picker-filter
            name="originStatusId"
            id="originStatusId"
            divClass="col-md-3"
            :label="txt.fields.originStatus"
            :url="routing.generate('vehicle.status.selectList')"
        />

        <erp-single-select-picker-filter
            name="endStatusId"
            id="endStatusId"
            divClass="col-md-3"
            :label="txt.fields.endStatus"
            :url="routing.generate('vehicle.status.selectList')"
        />

        <erp-date-picker-filter
            @updatedDatePicker="statusChangeDateFrom = $event"
            name="statusChangeDateFrom"
            id="statusChangeDateFrom"
            divClass="col-md-3"
            :label="txt.fields.statusChangeDateFrom"
            :limit-end-day="statusChangeDateTo"
        />

        <erp-date-picker-filter
            @updatedDatePicker="statusChangeDateTo = $event"
            name="statusChangeDateTo"
            id="statusChangeDateTo"
            divClass="col-md-3"
            :label="txt.fields.statusChangeDateTo"
            :limit-start-day="statusChangeDateFrom"
        />
    </erp-filter>
</template>

<script>
import ErpFilter from "../../../../components/filter/ErpFilter.vue";
import ErpDatePickerFilter from "../../../../../SharedAssets/vue/components/filter/form/ErpDatePickerFilter2.vue";
import ErpSingleSelectPickerFilter from "../../../../../SharedAssets/vue/components/filter/form/ErpSingleSelectPickerFilter.vue";

export default {
    name: "VehicleHistoryTabFilter",
    components: {
        ErpFilter,
        ErpDatePickerFilter,
        ErpSingleSelectPickerFilter,
    },
    data() {
        return {
            txt: {},
            statusChangeDateFrom: null,
            statusChangeDateTo: null,
        };
    },
    created() {
        this.txt = txtTrans;
    },
};
</script>

<style scoped></style>
