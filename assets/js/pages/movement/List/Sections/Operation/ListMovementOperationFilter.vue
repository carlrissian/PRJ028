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
        <erp-input-base-filter name="licensePlate" id="licensePlate" divClass="col-md-3" :label="txt.fields.licensePlate" />
        <erp-input-base-filter name="vin" id="vin" divClass="col-md-3" :label="txt.fields.vin" />

        <erp-multiple-select-filter
            class-number="3"
            :label="txt.fields.provider"
            name="supplierCode"
            id="supplierCode"
            :data-for-ajax="selectList.supplierList"
        />

        <erp-multiple-select-filter
            class-number="3"
            :label="txt.fields.originLocation"
            name="originLocationId"
            id="originLocationId"
            :data-for-ajax="selectList.locationList"
            @changeSelectMultiple="changeLocation"
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
            :label="txt.fields.destinationLocation"
            name="destinationLocationId"
            id="destinationLocationId"
            :data-for-ajax="selectList.locationDestinationList"
        />
        <erp-multiple-select-filter
            class-number="3"
            :label="txt.fields.destinationBranch"
            name="destinationBranchId"
            id="destinationBranchId"
            :data-for-ajax="selectList.branchList"
        />

        <erp-date-picker-filter
            @updateDatePicker="changedPicker('expectedLoadDateFrom', 'expectedLoadDateTo', $event)"
            name="expectedLoadDateFrom"
            id="expectedLoadDateFrom"
            class-number="col-md-3"
            :label="txt.fields.expectedLoadDateFrom"
            :limit-end-day="dates.expectedLoadDateTo"
        />
        <erp-date-picker-filter
            @updateDatePicker="changedPicker('expectedLoadDateFrom', 'expectedLoadDateTo', $event)"
            name="expectedLoadDateTo"
            id="expectedLoadDateTo"
            class-number="col-md-3"
            :label="txt.fields.expectedLoadDateTo"
            :limit-start-day="dates.expectedLoadDateFrom"
        />
        <erp-date-picker-filter
            @updateDatePicker="changedPicker('expectedUnloadDateFrom', 'expectedUnloadDateTo', $event)"
            name="expectedUnloadDateFrom"
            id="expectedUnloadDateFrom"
            class-number="col-md-3"
            :label="txt.fields.expectedUnloadDateFrom"
            :limit-end-day="dates.expectedUnloadDateTo"
        />
        <erp-date-picker-filter
            @updateDatePicker="changedPicker('expectedUnloadDateFrom', 'expectedUnloadDateTo', $event)"
            name="expectedUnloadDateTo"
            id="expectedUnloadDateTo"
            class-number="col-md-3"
            :label="txt.fields.expectedUnloadDateTo"
            :limit-start-day="dates.expectedUnloadDateFrom"
        />

        <erp-date-picker-filter
            @updateDatePicker="changedPicker('actualLoadDateFrom', 'actualLoadDateTo', $event)"
            name="actualLoadDateFrom"
            id="actualLoadDateFrom"
            class-number="col-md-3"
            :label="txt.fields.actualLoadDateFrom"
            :limit-end-day="dates.actualLoadDateTo"
        />
        <erp-date-picker-filter
            @updateDatePicker="changedPicker('actualLoadDateFrom', 'actualLoadDateTo', $event)"
            name="actualLoadDateTo"
            id="actualLoadDateTo"
            class-number="col-md-3"
            :label="txt.fields.actualLoadDateTo"
            :limit-start-day="dates.actualLoadDateFrom"
        />
        <erp-date-picker-filter
            @updateDatePicker="changedPicker('actualUnloadDateFrom', 'actualUnloadDateTo', $event)"
            name="actualUnloadDateFrom"
            id="actualUnloadDateFrom"
            class-number="col-md-3"
            :label="txt.fields.actualUnloadDateFrom"
            :limit-end-day="dates.actualUnloadDateTo"
        />
        <erp-date-picker-filter
            @updateDatePicker="changedPicker('actualUnloadDateFrom', 'actualUnloadDateTo', $event)"
            name="actualUnloadDateTo"
            id="actualUnloadDateTo"
            class-number="col-md-3"
            :label="txt.fields.actualUnloadDateTo"
            :limit-start-day="dates.actualUnloadDateFrom"
        />

        <erp-multiple-select-filter
            class-number="3"
            :label="txt.fields.movementStatus"
            name="movementStatusId"
            id="movementStatusId"
            :data-for-ajax="selectList.movementStatusList"
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
        <erp-select-filter
            class-number="3"
            name="connectedVehicle"
            id="connectedVehicle"
            :label="txt.fields.connectedVehicle"
            :options="selectList.connectedVehicleList"
            disabled
        />
    </erp-filter>
</template>

<script>
import Loading from "../../../../../../assets/js/utilities";
import ErpFilter from "../../../../../components/filter/ErpFilter";
import ErpInputBaseFilter from "../../../../../../SharedAssets/vue/components/filter/form/ErpInputBaseFilter.vue";
import ErpSelectFilter from "../../../../../components/filter/form/ErpSelectFilter";
import ErpDatePickerFilter from "../../../../../components/filter/form/ErpDatePickerFilter";
import ErpMultipleSelectFilter from "../../../../../components/filter/form/ErpMultipleSelectFilter";

export default {
    name: "ListMovementOperationFilter",
    components: {
        ErpFilter,
        ErpInputBaseFilter,
        ErpSelectFilter,
        ErpDatePickerFilter,
        ErpMultipleSelectFilter,
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
        };
    },
    created() {
        this.txt = txtTrans;
    },
    methods: {
        changeLocation(item) {
            const value = item[Object.keys(item)];

            if (value) {
                Loading.starLoading();

                let url = this.routing.generate("movement.get.destinations", {
                    idOrigin: value,
                });

                this.axios
                    .post(url)
                    .then((response) => {
                        // console.log("Destination locations: ", response);
                        Loading.endLoading();

                        if (!response.data) {
                            this.showNotification("error", this.txt.form.errorProcessingDestinations);
                        } else {
                            this.locationDestinationList = response.data;
                        }
                    })
                    .catch((e) => {
                        console.log(e);
                        Loading.endLoading();
                        this.showNotification("error", this.txt.form.errorProcessingDestinations);
                    });
            }
        },
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
