<template>
    <div class="row">
        <div class="col-md-12">
            <div class="kt-portlet kt-portlet--bordered">
                <div class="kt-portlet__head" @click="collapsed = !collapsed">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <i :class="collapsed ? 'fa fa-minus' : 'fa fa-plus'"></i> {{ txt.titles.filters }}
                        </h3>
                    </div>
                </div>

                <div class="kt-portlet__body" :style="collapsed ? 'display: block' : 'display: none'">
                    <div class="row">
                        <!-- Vehicle type -->
                        <multiple-select-picker
                            @updatedMultipleSelectPicker="vehicleFilters.vehicleTypeIdIn = $event"
                            name="vehicleTypeId"
                            id="vehicleTypeId"
                            divClass="form-group col-md-3"
                            :label="txt.fields.vehicleType"
                            :placeholder="txt.form.selectAnOption"
                            :options="selectList.vehicleTypeList"
                            :value="vehicleFilters.vehicleTypeIdIn"
                            :disabled="$parent.isInProgress"
                            return-object
                            disabled-options
                        />
                        <!--  -->

                        <!-- Vehicle brand -->
                        <multiple-select-picker
                            @updatedMultipleSelectPicker="
                                vehicleFilters.brandIdIn = $event;
                                filterModelList($event);
                            "
                            name="brandId"
                            id="brandId"
                            divClass="form-group col-md-3"
                            :label="txt.fields.brand"
                            :placeholder="txt.form.selectAnOption"
                            :options="selectList.brandList"
                            :value="vehicleFilters.brandIdIn"
                            :disabled="$parent.isInProgress"
                            return-object
                            disabled-options
                        />
                        <!--  -->

                        <!-- Vehicle model -->
                        <multiple-select-picker
                            @updatedMultipleSelectPicker="vehicleFilters.modelIdIn = $event"
                            name="modelId"
                            id="modelId"
                            divClass="form-group col-md-3"
                            :label="txt.fields.model"
                            :placeholder="txt.form.selectAnOption"
                            :options="modelListFiltered"
                            :value="vehicleFilters.modelIdIn"
                            :disabled="$parent.isInProgress"
                            return-object
                            disabled-options
                        />
                        <!--  -->

                        <!-- Vehicle carGroup -->
                        <multiple-select-picker
                            @updatedMultipleSelectPicker="vehicleFilters.carGroupIdIn = $event"
                            name="carGroupId"
                            id="carGroupId"
                            divClass="form-group col-md-3"
                            :label="txt.fields.carGroup"
                            :placeholder="txt.form.selectAnOption"
                            :options="selectList.carGroupList"
                            :value="vehicleFilters.carGroupIdIn"
                            :disabled="$parent.isInProgress"
                            return-object
                            disabled-options
                        />
                        <!--  -->
                    </div>

                    <div class="row">
                        <!-- Kilometers from -->
                        <input-number
                            @updatedInputNumber="vehicleFilters.kilometersFrom.value = $event"
                            name="kilometersFrom"
                            id="kilometersFrom"
                            divClass="form-group col-md-3"
                            :min="0"
                            :max="vehicleFilters.kilometersTo.value ? parseInt(vehicleFilters.kilometersTo.value) : undefined"
                            :label="txt.fields.kilometersFrom"
                            :value="vehicleFilters.kilometersFrom.value"
                            :disabled="vehicleFilters.kilometersFrom.disabled || $parent.isInProgress"
                        />
                        <!--  -->

                        <!-- Kilometers to -->
                        <input-number
                            @updatedInputNumber="vehicleFilters.kilometersTo.value = $event"
                            name="kilometersTo"
                            id="kilometersTo"
                            divClass="form-group col-md-3"
                            :min="vehicleFilters.kilometersFrom.value ? parseInt(vehicleFilters.kilometersFrom.value) : undefined"
                            :label="txt.fields.kilometersTo"
                            :value="vehicleFilters.kilometersTo.value"
                            :disabled="vehicleFilters.kilometersTo.disabled || $parent.isInProgress"
                        />
                        <!--  -->

                        <!-- Renting end date from -->
                        <date-picker
                            @updatedDatePicker="vehicleFilters.rentingEndDateFrom.value = $event"
                            name="rentingEndDateFrom"
                            id="rentingEndDateFrom"
                            divClass="form-group col-md-3"
                            :label="txt.fields.rentingEndDateFrom"
                            :value="vehicleFilters.rentingEndDateFrom.value"
                            :limit-end-day="vehicleFilters.rentingEndDateTo.value"
                            :disabled="vehicleFilters.rentingEndDateFrom.disabled || $parent.isInProgress"
                        />
                        <!--  -->

                        <!-- Renting end date to -->
                        <date-picker
                            @updatedDatePicker="vehicleFilters.rentingEndDateTo.value = $event"
                            name="rentingEndDateTo"
                            id="rentingEndDateTo"
                            divClass="form-group col-md-3"
                            :label="txt.fields.rentingEndDateTo"
                            :value="vehicleFilters.rentingEndDateTo.value"
                            :limit-start-day="vehicleFilters.rentingEndDateFrom.value"
                            :disabled="vehicleFilters.rentingEndDateTo.disabled || $parent.isInProgress"
                        />
                        <!--  -->
                    </div>

                    <div class="row">
                        <!-- Check In Due date from -->
                        <date-picker
                            @updatedDatePicker="vehicleFilters.checkInDateFrom.value = $event"
                            name="checkInDateFrom"
                            id="checkInDateFrom"
                            divClass="form-group col-md-3"
                            :label="txt.fields.checkInDueDateFrom"
                            :value="vehicleFilters.checkInDateFrom.value"
                            :disabled="vehicleFilters.checkInDateFrom.disabled || $parent.isInProgress"
                        />
                        <!--  -->

                        <!-- Sale mothod -->
                        <multiple-select-picker
                            @updatedMultipleSelectPicker="vehicleFilters.saleMethodIdIn = $event"
                            name="saleMethodId"
                            id="saleMethodId"
                            divClass="form-group col-md-3"
                            :label="txt.fields.saleMethod"
                            :placeholder="txt.form.selectAnOption"
                            :options="selectList.saleMethodList"
                            :value="vehicleFilters.saleMethodIdIn"
                            :disabled="cannotEditSaleMethod || $parent.isInProgress"
                            return-object
                            disabled-options
                        />
                        <!--  -->

                        <!-- Vehicle status -->
                        <multiple-select-picker
                            @updatedMultipleSelectPicker="vehicleFilters.vehicleStatusIdIn = $event"
                            name="vehicleStatusId"
                            id="vehicleStatusId"
                            divClass="form-group col-md-3"
                            :label="txt.fields.vehicleStatus"
                            :placeholder="txt.form.selectAnOption"
                            :options="selectList.vehicleStatusList"
                            :value="vehicleFilters.vehicleStatusIdIn"
                            :disabled="$parent.isInProgress"
                            return-object
                            disabled-options
                        />
                        <!--  -->

                        <!-- Connected vehicle -->
                        <single-select-picker
                            @updatedSelectPicker="vehicleFilters.connectedVehicle.value = $event"
                            name="connectedVehicle"
                            id="connectedVehicle"
                            divClass="form-group col-md-3"
                            :label="txt.fields.connectedVehicle"
                            :placeholder="txt.form.selectAnOption"
                            :options="selectList.connectedVehicleList"
                            :value="vehicleFilters.connectedVehicle.value"
                            :disabled="vehicleFilters.connectedVehicle.disabled || $parent.isInProgress"
                        />
                        <!--  -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DatePicker from "../../../../../SharedAssets/vue/components/base/inputs/DatePicker";
import InputNumber from "../../../../../SharedAssets/vue/components/base/inputs/InputNumber";
import MultipleSelectPicker from "../../../../../SharedAssets/vue/components/base/inputs/MultipleSelectPicker";
import SingleSelectPicker from "../../../../../SharedAssets/vue/components/base/inputs/SingleSelectPicker";

export default {
    name: "MovementCarrierVehicleFilter",
    components: {
        DatePicker,
        InputNumber,
        MultipleSelectPicker,
        SingleSelectPicker,
    },
    props: {
        selectList: Object,
        filters: Object,
        saleMethodId: {
            type: Number,
            default: null,
        },
    },
    data() {
        return {
            txt: {},
            constants: {},
            collapsed: false,
            cannotEditSaleMethod: false,

            vehicleFilters: {
                vehicleTypeIdIn: [],
                brandIdIn: [],
                modelIdIn: [],
                carGroupIdIn: [],
                kilometersFrom: {
                    value: null,
                    disabled: false,
                },
                kilometersTo: {
                    value: null,
                    disabled: false,
                },
                rentingEndDateFrom: {
                    value: null,
                    disabled: false,
                },
                rentingEndDateTo: {
                    value: null,
                    disabled: false,
                },
                checkInDateFrom: {
                    value: null,
                    disabled: false,
                },
                saleMethodIdIn: [],
                vehicleStatusIdIn: [],
                connectedVehicle: {
                    value: null,
                    disabled: false,
                },
            },

            modelListFiltered: [],
        };
    },
    created() {
        this.txt = txtTrans;
        this.constants = constants;
    },
    mounted() {
        this.$nextTick(() => {
            this.fillFilters();
        });
    },
    watch: {
        filters: {
            handler() {
                this.fillFilters();
            },
            inmediate: true,
            deep: true,
        },
        saleMethodId: {
            handler() {
                this.cannotEditSaleMethod = this.saleMethodId !== null;
                this.vehicleFilters.saleMethodIdIn = this.selectList.saleMethodList.filter(
                    (saleMethod) => saleMethod.id === this.saleMethodId
                );
            },
        },
    },
    methods: {
        fillFilters() {
            this.vehicleFilters.vehicleTypeIdIn = this.filters?.vehicleTypeIdIn || [];
            this.vehicleFilters.brandIdIn = this.filters?.brandIdIn || [];
            this.filterModelList(this.vehicleFilters.brandIdIn);
            this.vehicleFilters.modelIdIn = this.filters?.modelIdIn || [];
            this.vehicleFilters.carGroupIdIn = this.filters?.carGroupIdIn || [];
            this.vehicleFilters.kilometersFrom.value = this.filters?.kilometersFrom?.value || null;
            this.vehicleFilters.kilometersFrom.disabled = this.filters?.kilometersFrom?.disabled || false;
            this.vehicleFilters.kilometersTo.value = this.filters?.kilometersTo?.value || null;
            this.vehicleFilters.kilometersTo.disabled = this.filters?.kilometersTo?.disabled || false;
            this.vehicleFilters.rentingEndDateFrom.value = this.filters?.rentingEndDateFrom?.value || null;
            this.vehicleFilters.rentingEndDateFrom.disabled = this.filters?.rentingEndDateFrom?.disabled || false;
            this.vehicleFilters.rentingEndDateTo.value = this.filters?.rentingEndDateTo?.value || null;
            this.vehicleFilters.rentingEndDateTo.disabled = this.filters?.rentingEndDateTo?.disabled || false;
            this.vehicleFilters.checkInDateFrom.value = this.filters?.checkInDateFrom?.value || null;
            this.vehicleFilters.checkInDateFrom.disabled = this.filters?.checkInDateFrom?.disabled || false;
            this.vehicleFilters.saleMethodIdIn = this.filters?.saleMethodIdIn || [];
            this.vehicleFilters.vehicleStatusIdIn = this.filters?.vehicleStatusIdIn || [];
            this.vehicleFilters.connectedVehicle.value = this.filters?.connectedVehicle?.value || null;
            this.vehicleFilters.connectedVehicle.disabled = this.filters?.connectedVehicle?.disabled || false;

            this.filtersHaveValues();
        },
        filterModelList(brandId = null) {
            if (brandId !== null && brandId.length > 0) {
                brandId = brandId.map((brand) => brand.id);

                this.modelListFiltered = this.selectList.modelList.filter((model) => brandId.includes(model.brandId));
                if (this.modelListFiltered.length == 0) {
                    this.$notify({
                        type: "error",
                        text: this.txt.form.noModelsBrand,
                    });
                }
            } else {
                this.modelListFiltered = this.selectList.modelList;
                this.vehicleFilters.modelIdIn.length = 0;
            }
        },
        filtersHaveValues() {
            this.collapsed = Object.values(this.filters).some((filter) => {
                if (Array.isArray(filter)) {
                    return filter.length > 0;
                }
                if (typeof filter === "object") {
                    return !["", null, undefined].includes(filter.value);
                }
                return false;
            });
        },
    },
};
</script>

<style scoped>
.kt-portlet__head {
    cursor: pointer;
}
</style>
