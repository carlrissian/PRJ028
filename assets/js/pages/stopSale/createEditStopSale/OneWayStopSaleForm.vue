<template>
    <form @submit.prevent="submitStopSale" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--bordered">
                    <div class="kt-portlet__body">
                        <div class="kt-portlet kt-portlet--bordered">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title" v-text="this.title"></h3>
                                </div>
                            </div>

                            <div class="kt-portlet__body">
                                <input
                                    type="hidden"
                                    name="categoryId"
                                    id="categoryId"
                                    v-model="stopSaleData.categoryId"
                                    required
                                />

                                <input
                                    type="hidden"
                                    name="departmentId"
                                    id="departmentId"
                                    v-model="stopSaleData.departmentId"
                                    required
                                />

                                <div class="row">
                                    <!-- Stop Sale Type -->
                                    <single-select-picker
                                        @onChangeSelectPicker="canSubmit = true"
                                        @updatedSelectPicker="stopSaleData.stopSaleTypeId = $event"
                                        name="stopSaleTypeId"
                                        id="stopSaleTypeId"
                                        divClass="form-group col-md-3"
                                        :placeholder="txt.form.selectAnOption"
                                        :label="txt.fields.stopSaleType"
                                        :options="selectList.stopSaleTypeList"
                                        :value="stopSaleData.stopSaleTypeId"
                                        required
                                        disabled
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->

                                    <!-- Car groups -->
                                    <multiple-select-picker
                                        @updatedMultipleSelectPicker="
                                            (stopSaleData.carGroupsId = $event), onChangeCarGroup($event)
                                        "
                                        name="carGroupsId[]"
                                        id="carGroupsId"
                                        divClass="form-group col-md-3"
                                        :placeholder="txt.form.selectAnOption"
                                        :label="txt.fields.carGroups"
                                        :options="selectList.carGroupList"
                                        :value="stopSaleData.carGroupsId"
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->

                                    <!-- ACRISS -->
                                    <multiple-select-picker
                                        @updatedMultipleSelectPicker="(stopSaleData.acrissId = $event), onChangeAcriss($event)"
                                        name="acrissId[]"
                                        id="acrissId"
                                        divClass="form-group col-md-3"
                                        :placeholder="txt.form.selectAnOption"
                                        :label="txt.fields.acriss"
                                        :options="selectList.acrissList"
                                        :value="stopSaleData.acrissId"
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->
                                </div>

                                <!-- Pick Up -->
                                <div class="row">
                                    <!-- Regions -->
                                    <!-- <multiple-select-picker
                                        @updatedMultipleSelectPicker="
                                            (stopSaleData.pickUpRegionId = $event), onChangeRegion($event, 'pickUp')
                                        "
                                        name="pickUpRegionId[]"
                                        id="pickUpRegionId"
                                        divClass="form-group col-md-3"
                                        :placeholder="txt.form.selectAnOption"
                                        :label="txt.fields.originRegion"
                                        :options="selectList.regionList"
                                        :value="stopSaleData.pickUpRegionId"
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    /> -->
                                    <!--  -->

                                    <!-- Areas -->
                                    <multiple-select-picker
                                        @updatedMultipleSelectPicker="
                                            (stopSaleData.pickUpAreaId = $event), onChangeArea($event, 'pickUp')
                                        "
                                        name="pickUpAreaId[]"
                                        id="pickUpAreaId"
                                        divClass="form-group col-md-3"
                                        :placeholder="txt.form.selectAnOption"
                                        :label="txt.fields.originArea"
                                        :options="selectList.areaList"
                                        :value="stopSaleData.pickUpAreaId"
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->

                                    <!-- Branches -->
                                    <multiple-select-picker
                                        @updatedMultipleSelectPicker="
                                            (stopSaleData.pickUpBranchId = $event), onChangeBranch($event, 'pickUp')
                                        "
                                        name="pickUpBranchId[]"
                                        id="pickUpBranchId"
                                        divClass="form-group col-md-3"
                                        :placeholder="txt.form.selectAnOption"
                                        :label="txt.fields.originBranch"
                                        :options="selectList.branchList"
                                        :value="stopSaleData.pickUpBranchId"
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->
                                </div>
                                <!--  -->

                                <!-- Drop Off -->
                                <div class="row">
                                    <!-- Regions -->
                                    <!-- <multiple-select-picker
                                        @updatedMultipleSelectPicker="
                                            (stopSaleData.dropOffRegionId = $event), onChangeRegion($event, 'dropOff')
                                        "
                                        name="dropOffRegionId[]"
                                        id="dropOffRegionId"
                                        divClass="form-group col-md-3"
                                        :placeholder="txt.form.selectAnOption"
                                        :label="txt.fields.destinyRegion"
                                        :options="selectList.regionList"
                                        :value="stopSaleData.dropOffRegionId"
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    /> -->
                                    <!--  -->

                                    <!-- Areas -->
                                    <multiple-select-picker
                                        @updatedMultipleSelectPicker="
                                            (stopSaleData.dropOffAreaId = $event), onChangeArea($event, 'dropOff')
                                        "
                                        name="dropOffAreaId[]"
                                        id="dropOffAreaId"
                                        divClass="form-group col-md-3"
                                        :placeholder="txt.form.selectAnOption"
                                        :label="txt.fields.destinyArea"
                                        :options="selectList.areaList"
                                        :value="stopSaleData.dropOffAreaId"
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->

                                    <!-- Branches -->
                                    <multiple-select-picker
                                        @updatedMultipleSelectPicker="
                                            (stopSaleData.dropOffBranchId = $event), onChangeBranch($event, 'dropOff')
                                        "
                                        name="dropOffBranchId[]"
                                        id="dropOffBranchId"
                                        divClass="form-group col-md-3"
                                        :placeholder="txt.form.selectAnOption"
                                        :label="txt.fields.destinyBranch"
                                        :options="selectList.branchList"
                                        :value="stopSaleData.dropOffBranchId"
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->
                                </div>
                                <!--  -->

                                <div class="row">
                                    <!-- Init date -->
                                    <date-picker
                                        @updatedDatePicker="(stopSaleData.initDate = $event), (canSubmit = true)"
                                        name="stopSaleInitDate"
                                        id="stopSaleInitDate"
                                        divClass="form-group col-md-3"
                                        :label="txt.fields.initDate"
                                        :limit-start-day="new Date()"
                                        :limit-end-day="stopSaleData.endDate"
                                        :value="stopSaleData.initDate"
                                        required
                                        :disabled="editMode ? stopSaleData.initDate < new Date() : false"
                                        v-bind:style="[canBeEditCreated !== true && stopSale ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->

                                    <!-- End date -->
                                    <date-picker
                                        @updatedDatePicker="(stopSaleData.endDate = $event), (canSubmit = true)"
                                        name="stopSaleEndDate"
                                        id="stopSaleEndDate"
                                        divClass="form-group col-md-3"
                                        :label="txt.fields.endDate"
                                        :limit-start-day="stopSaleData.initDate"
                                        :value="stopSaleData.endDate"
                                        required
                                        v-bind:style="[canBeEditCreated !== true && stopSale ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->

                                    <!-- Min Days Rent -->
                                    <input-number
                                        @onInputChangeInputNumber="canSubmit = true"
                                        @onChangeInputNumber="canSubmit = true"
                                        @updatedInputNumber="stopSaleData.minDaysRent = $event"
                                        name="minDaysRent"
                                        id="minDaysRent"
                                        divClass="form-group col-md-3"
                                        :min="0"
                                        :label="txt.fields.minDaysRent"
                                        :value="stopSaleData.minDaysRent"
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->

                                    <!-- Max Days Rent -->
                                    <input-number
                                        @onInputChangeInputNumber="canSubmit = true"
                                        @onChangeInputNumber="canSubmit = true"
                                        @updatedInputNumber="stopSaleData.maxDaysRent = $event"
                                        name="maxDaysRent"
                                        id="maxDaysRent"
                                        divClass="form-group col-md-3"
                                        :min="0"
                                        :label="txt.fields.maxDaysRent"
                                        :value="stopSaleData.maxDaysRent"
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->

                                    <!-- Connected vehicle -->
                                    <single-select-picker
                                        @onChangeSelectPicker="canSubmit = true"
                                        @updatedSelectPicker="stopSaleData.connectedVehicle = $event"
                                        name="connectedVehicle"
                                        id="connectedVehicle"
                                        divClass="form-group col-md-3"
                                        :placeholder="txt.form.selectAnOption"
                                        :label="txt.fields.connectedVehicle"
                                        :options="selectList.connectedVehicleList"
                                        :value="stopSaleData.connectedVehicle"
                                        disabled
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->
                                </div>

                                <div class="row">
                                    <!-- Notes -->
                                    <text-area
                                        @updatedTextArea="(stopSaleData.notes = $event), (canSubmit = true)"
                                        name="notes"
                                        id="notes"
                                        divClass="form-group col-md-12"
                                        :cols="30"
                                        :rows="8"
                                        :label="txt.fields.notes"
                                        :value="stopSaleData.notes"
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->
                                </div>
                            </div>

                            <div class="kt-portlet__foot">
                                <div class="text-right">
                                    <div class="kt-align-right">
                                        <button type="submit" class="btn btn-dark kt-label-bg-color-4">
                                            <i :class="'la ' + this.submitButtonClass"></i>
                                            {{ this.submitButton }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import { capitalize } from "../../../../SharedAssets/js/utils.js";
import Loading from "../../../../assets/js/utilities.js";
import CheckBox from "../../../../SharedAssets/vue/components/base/inputs/CheckBox.vue";
import DatePicker from "../../../../SharedAssets/vue/components/base/inputs/DatePicker.vue";
import InputNumber from "../../../../SharedAssets/vue/components/base/inputs/InputNumber.vue";
import MultipleSelectPicker from "../../../../SharedAssets/vue/components/base/inputs/MultipleSelectPicker.vue";
import SingleSelectPicker from "../../../../SharedAssets/vue/components/base/inputs/SingleSelectPicker.vue";
import TextArea from "../../../../SharedAssets/vue/components/base/inputs/TextArea.vue";
import TimePicker from "../../../../SharedAssets/vue/components/base/inputs/TimePicker.vue";

export default {
    name: "OneWayStopSaleForm",
    components: {
        CheckBox,
        DatePicker,
        InputNumber,
        MultipleSelectPicker,
        SingleSelectPicker,
        TextArea,
        TimePicker,
    },
    props: {
        selectList: Object,
        stopSale: Object,
    },
    data() {
        return {
            txt: txtTrans,
            constants,
            editMode: false,

            stopSaleData: {
                id: null,
                categoryId: null,
                departmentId: null,
                initDate: null,
                endDate: null,
                carGroupsId: [],
                acrissId: [],

                pickUpRegionId: [],
                pickUpAreaId: [],
                pickUpBranchId: [],

                dropOffRegionId: [],
                dropOffAreaId: [],
                dropOffBranchId: [],

                stopSaleTypeId: null,
                minDaysRent: null,
                maxDaysRent: null,
                connectedVehicle: null,
                notes: null,
                cancelled: null,
            },

            canBeEditCreated: false,
            canSubmit: false,

            styleObjectNo: {
                pointerEvents: "none",
                opacity: "0.5",
            },
            styleObject: {
                pointerEvents: "visible",
                opacity: "1",
            },
        };
    },
    mounted() {
        this.canBeEditCreated = this.selectList.canBeEditCreated;

        if (![null, undefined].includes(this.stopSale)) {
            this.editMode = true;
            this.fillStopSaleData();
        } else {
            this.stopSaleData.departmentId = constants.department.distribution;
            this.stopSaleData.categoryId = constants.category.oneway;
            this.stopSaleData.stopSaleTypeId = 1;
            this.stopSaleData.initDate = moment(new Date(), "DD/MM/YYYY").format("DD/MM/YYYY");
        }
    },
    computed: {
        title() {
            return this.editMode ? this.txt.titles.editOneWay : this.txt.titles.createOneWay;
        },
        submitButton() {
            return this.editMode ? this.txt.form.update : this.txt.form.create;
        },
        submitButtonClass() {
            return this.editMode ? "la-edit" : "la-plus";
        },
    },
    methods: {
        fillStopSaleData() {
            this.stopSaleData.id = this.stopSale?.id;
            this.stopSaleData.departmentId = this.stopSale?.department?.id
                ? this.stopSale.department.id
                : this.constants.department.distribution;
            this.stopSaleData.categoryId = this.stopSale?.category?.id
                ? this.stopSale.category.id
                : this.constants.category.oneway;
            this.stopSaleData.initDate = this.stopSale?.initDate;
            this.stopSaleData.endDate = this.stopSale?.endDate;

            this.getSelectedIds(
                this.stopSale?.acriss?.map((item) => item?.carGroup),
                this.stopSaleData.carGroupsId
            );
            this.getSelectedIds(this.stopSale?.acriss, this.stopSaleData.acrissId);
            this.getSelectedIds(this.stopSale?.pickUpRegion, this.stopSaleData.pickUpRegionId);
            this.getSelectedIds(this.stopSale?.pickUpArea, this.stopSaleData.pickUpAreaId);
            this.getSelectedIds(this.stopSale?.pickUpBranch, this.stopSaleData.pickUpBranchId);
            this.onChangeBranch(this.stopSaleData.pickUpBranchId, "pickUp");
            this.getSelectedIds(this.stopSale?.dropOffRegion, this.stopSaleData.dropOffRegionId);
            this.getSelectedIds(this.stopSale?.dropOffArea, this.stopSaleData.dropOffAreaId);
            this.getSelectedIds(this.stopSale?.dropOffBranch, this.stopSaleData.dropOffBranchId);
            this.onChangeBranch(this.stopSaleData.dropOffBranchId, "dropOff");

            this.stopSaleData.stopSaleTypeId = this.stopSale?.stopSaleType?.id;
            this.stopSaleData.minDaysRent = this.stopSale?.minDaysRent;
            this.stopSaleData.maxDaysRent = this.stopSale?.maxDaysRent;
            this.stopSaleData.connectedVehicle = this.stopSale?.connectedVehicle;
            this.stopSaleData.notes = this.stopSale?.notes;
        },
        getSelectedIds(arrayFrom, arrayTo) {
            arrayFrom?.map((obj) => {
                arrayTo.push(obj.id);
            });
        },
        onChangeCarGroup(selection) {
            this.stopSaleData.acrissId = this.selectList.acrissList
                .filter((acriss) => selection.includes(acriss.carGroupId))
                .map((acriss) => acriss.id);
        },
        onChangeAcriss(selection) {
            this.stopSaleData.carGroupsId = this.selectList.acrissList
                .filter((acriss) => selection.includes(acriss.id))
                .map((acriss) => acriss.carGroupId);
        },
        onChangeRegion(selection, type) {
            this.stopSaleData[`${type}AreaId`] = this.selectList.areaList
                .filter((area) => selection.includes(area.regionId))
                .map((area) => area.id);
            this.onChangeArea(this.stopSaleData[`${type}AreaId`], type);
        },
        onChangeArea(selection, type) {
            this.stopSaleData[`${type}BranchId`] = this.selectList.branchList
                .filter((branch) => selection.includes(branch.areaId))
                .map((branch) => branch.id);

            this.stopSaleData[`${type}RegionId`] = this.selectList.areaList
                .filter((area) => selection.includes(area.id))
                .map((area) => area.regionId);
        },
        onChangeBranch(selection, type) {
            this.stopSaleData[`${type}AreaId`] = this.selectList.branchList
                .filter((branch) => selection.includes(branch.id))
                .map((branch) => branch.areaId);

            this.stopSaleData[`${type}RegionId`] = this.selectList.areaList
                .filter((area) => this.stopSaleData[`${type}AreaId`].includes(area.id))
                .map((area) => area.regionId);
        },
        checkStopSale() {
            if (this.canBeEditCreated !== true) {
                this.$notify({
                    type: "error",
                    text: this.txt.form.cannotBeEditCreated,
                });
                return false;
            }

            if (this.stopSaleData.carGroupsId.length == 0 && this.stopSaleData.acrissId.length == 0) {
                this.$notify({
                    type: "warn",
                    text: this.txt.form.selectAGroupOrAcriss,
                });
                document.querySelector("#acrissId").focus();
                return false;
            }

            if (
                this.stopSaleData.pickUpRegionId.length == 0 &&
                this.stopSaleData.pickUpAreaId.length == 0 &&
                this.stopSaleData.pickUpBranchId.length == 0
            ) {
                this.$notify({
                    type: "warn",
                    text: this.txt.form.selectPickUp,
                });
                document.querySelector("#pickUpBranchId").focus();
                return false;
            }

            if (
                this.stopSaleData.dropOffRegionId.length == 0 &&
                this.stopSaleData.dropOffAreaId.length == 0 &&
                this.stopSaleData.dropOffBranchId.length == 0
            ) {
                this.$notify({
                    type: "warn",
                    text: this.txt.form.selectDropOff,
                });
                document.querySelector("#dropOffBranchId").focus();
                return false;
            }

            return true;
        },
        submitStopSale: async function() {
            if (this.checkStopSale()) {
                Loading.starLoading();

                let formData = new FormData();
                let stopSaleData = { ...this.stopSaleData };
                formData.set("stopSale", JSON.stringify(stopSaleData));

                let url = this.editMode
                    ? this.routing.generate("stopsale.update", {
                          id: this.stopSaleData.id,
                      })
                    : this.routing.generate("stopsale.store");

                this.axios
                    .post(url, formData)
                    .then((response) => {
                        Loading.endLoading();
                        if (response.status == 200) {
                            this.$notify({
                                type: "success",
                                text: this.editMode
                                    ? this.txt.form.stopSaleUpdatedSuccessNotification
                                    : this.txt.form.stopSaleCreatedSuccessNotification,
                            });

                            setTimeout(() => {
                                window.location.href = this.routing.generate("stopsale.list", {
                                    stopSaleCategory: "oneway",
                                });
                            }, 2000);
                        } else {
                            this.$notify({
                                type: "error",
                                text: this.editMode
                                    ? this.txt.form.errorUpdatingStopSaleNotification
                                    : this.txt.form.errorCreatingStopSaleNotification,
                            });
                            this.showNotification("error", this.txt.form.errorCreatingStopSaleNotification);
                        }
                    })
                    .catch((error) => {
                        Loading.endLoading();
                        console.error(error.response);
                        this.$notify({
                            type: "error",
                            text: this.editMode
                                ? this.txt.form.errorUpdatingStopSaleNotification
                                : this.txt.form.errorCreatingStopSaleNotification,
                        });
                    });
            }
        },
    },
};
</script>

<style scoped></style>
