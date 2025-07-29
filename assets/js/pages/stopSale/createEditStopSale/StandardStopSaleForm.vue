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
                                        divClass="form-group col-md-2"
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
                                        divClass="form-group col-md-2"
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
                                        divClass="form-group col-md-2"
                                        :placeholder="txt.form.selectAnOption"
                                        :label="txt.fields.acriss"
                                        :options="selectList.acrissList"
                                        :value="stopSaleData.acrissId"
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->

                                    <!-- Regions -->
                                    <!-- <multiple-select-picker
                                            @updatedMultipleSelectPicker="stopSaleData.regionsId = $event"
                                            name="pickUpRegionId[]"
                                            id="pickUpRegionId"
                                            divClass="form-group col-md-2"
                                            :placeholder="txt.form.selectAnOption"
                                            :label="txt.fields.regions"
                                            :options="selectList.regionList"
                                            :value="stopSaleData.regionsId"
                                            v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                        /> -->
                                    <!--  -->

                                    <!-- Areas -->
                                    <!-- <multiple-select-picker
                                            @updatedMultipleSelectPicker="stopSaleData.areasId = $event"
                                            name="pickUpAreaId[]"
                                            id="pickUpAreaId"
                                            divClass="form-group col-md-2"
                                            :placeholder="txt.form.selectAnOption"
                                            :label="txt.fields.areas"
                                            :options="selectList.areaList"
                                            :value="stopSaleData.areasId"
                                            v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                        /> -->
                                    <!--  -->

                                    <!-- Branches -->
                                    <multiple-select-picker
                                        @updatedMultipleSelectPicker="stopSaleData.pickUpBranchId = $event"
                                        name="pickUpBranchId[]"
                                        id="pickUpBranchId"
                                        divClass="form-group col-md-2"
                                        :placeholder="txt.form.selectAnOption"
                                        :label="txt.fields.branches"
                                        :options="selectList.branchList"
                                        :value="stopSaleData.pickUpBranchId"
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->
                                </div>

                                <div class="row">
                                    <!-- Connected vehicle -->
                                    <single-select-picker
                                        @onChangeSelectPicker="canSubmit = true"
                                        @updatedSelectPicker="stopSaleData.connectedVehicle = $event"
                                        name="connectedVehicle"
                                        id="connectedVehicle"
                                        divClass="form-group col-md-2"
                                        :placeholder="txt.form.selectAnOption"
                                        :label="txt.fields.connectedVehicle"
                                        :options="selectList.connectedVehicleList"
                                        :value="stopSaleData.connectedVehicle"
                                        disabled
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->

                                    <!-- Partners -->
                                    <multiple-select-picker
                                        @updatedMultipleSelectPicker="stopSaleData.partnersId = $event"
                                        name="partnersId[]"
                                        id="partnersId"
                                        divClass="form-group col-md-2"
                                        :placeholder="txt.form.selectAnOption"
                                        :label="txt.fields.partners"
                                        :options="selectList.partnerList"
                                        :value="stopSaleData.partnersId"
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->

                                    <!-- Sell Codes -->
                                    <multiple-select-picker
                                        @updatedMultipleSelectPicker="stopSaleData.sellCodesId = $event"
                                        name="sellCodesId[]"
                                        id="sellCodesId"
                                        divClass="form-group col-md-2"
                                        :placeholder="txt.form.selectAnOption"
                                        :label="txt.fields.sellCodes"
                                        :options="selectList.sellCodeList"
                                        :value="stopSaleData.sellCodesId"
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->

                                    <!-- Products -->
                                    <multiple-select-picker
                                        @updatedMultipleSelectPicker="stopSaleData.productsId = $event"
                                        name="productsId[]"
                                        id="productsId"
                                        divClass="form-group col-md-2"
                                        :placeholder="txt.form.selectAnOption"
                                        :label="txt.fields.products"
                                        :options="selectList.productList"
                                        :value="stopSaleData.productsId"
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->
                                </div>

                                <div class="row">
                                    <!-- Init date -->
                                    <date-picker
                                        @updatedDatePicker="(stopSaleData.initDate = $event), (canSubmit = true)"
                                        name="stopSaleInitDate"
                                        id="stopSaleInitDate"
                                        divClass="form-group col-md-2"
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
                                        divClass="form-group col-md-2"
                                        :label="txt.fields.endDate"
                                        :limit-start-day="stopSaleData.initDate"
                                        :value="stopSaleData.endDate"
                                        required
                                        v-bind:style="[canBeEditCreated !== true && stopSale ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->

                                    <!-- Days -->
                                    <div
                                        class="form-group col-md-8"
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    >
                                        <label v-text="txt.fields.recurrence"></label>
                                        <div class="kt-checkbox-inline">
                                            <check-box
                                                v-for="day in selectList.daysList"
                                                :key="day.id"
                                                @onChangeCheckBox="onChangeRecurrence($event), (canSubmit = true)"
                                                name="recurrencesId[]"
                                                :id="'day' + day.id"
                                                :label="day.name"
                                                :value="day.id"
                                                :checked="stopSaleData.recurrencesId.includes(day.id)"
                                            />
                                        </div>
                                    </div>
                                    <!--  -->
                                </div>

                                <div class="row">
                                    <!-- Start Time -->
                                    <time-picker
                                        @onChangeTimePicker="canSubmit = true"
                                        @updatedTimePicker="stopSaleData.startTime = $event"
                                        name="startTime"
                                        id="startTime"
                                        divClass="form-group col-md-2"
                                        :label="txt.fields.startTime"
                                        :limit-end-time="
                                            stopSaleData.initDate == stopSaleData.endDate ? stopSaleData.endTime : null
                                        "
                                        :value="stopSaleData.startTime"
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->

                                    <!-- End Time -->
                                    <time-picker
                                        @onChangeTimePicker="canSubmit = true"
                                        @updatedTimePicker="stopSaleData.endTime = $event"
                                        name="endTime"
                                        id="endTime"
                                        divClass="form-group col-md-2"
                                        :label="txt.fields.endTime"
                                        :limit-start-time="
                                            stopSaleData.initDate == stopSaleData.endDate ? stopSaleData.startTime : null
                                        "
                                        :value="stopSaleData.endTime"
                                        v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                    />
                                    <!--  -->

                                    <!-- Min Days Rent -->
                                    <input-number
                                        @onInputChangeInputNumber="canSubmit = true"
                                        @onChangeInputNumber="canSubmit = true"
                                        @updatedInputNumber="stopSaleData.minDaysRent = $event"
                                        name="minDaysRent"
                                        id="minDaysRent"
                                        divClass="form-group col-md-2"
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
                                        divClass="form-group col-md-2"
                                        :min="0"
                                        :label="txt.fields.maxDaysRent"
                                        :value="stopSaleData.maxDaysRent"
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
                                        <button
                                            type="submit"
                                            class="btn btn-dark kt-label-bg-color-4"
                                            v-bind:style="[
                                                canBeEditCreated !== true || canSubmit !== true ? styleObjectNo : styleObject,
                                            ]"
                                        >
                                            <i :class="`la ${submitButtonClass}`"></i>
                                            {{ submitButton }}
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
import Loading from "../../../../assets/js/utilities.js";
import CheckBox from "../../../../SharedAssets/vue/components/base/inputs/CheckBox.vue";
import DatePicker from "../../../../SharedAssets/vue/components/base/inputs/DatePicker.vue";
import InputNumber from "../../../../SharedAssets/vue/components/base/inputs/InputNumber.vue";
import MultipleSelectPicker from "../../../../SharedAssets/vue/components/base/inputs/MultipleSelectPicker.vue";
import SingleSelectPicker from "../../../../SharedAssets/vue/components/base/inputs/SingleSelectPicker.vue";
import TextArea from "../../../../SharedAssets/vue/components/base/inputs/TextArea.vue";
import TimePicker from "../../../../SharedAssets/vue/components/base/inputs/TimePicker.vue";

export default {
    name: "StandardStopSaleForm",
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

                partnersId: [],
                sellCodesId: [],
                productsId: [],
                stopSaleTypeId: null,
                startTime: null,
                endTime: null,
                recurrencesId: [],
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
                display: "none",
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
            this.stopSaleData.categoryId = constants.category.standard;
            this.stopSaleData.stopSaleTypeId = 2;
            // this.stopSaleData.startTime = moment("00:00", "HH:mm").format("HH:mm");
            // this.stopSaleData.endTime = moment("23:59", "HH:mm").format("HH:mm");
            this.stopSaleData.initDate = moment(new Date(), "DD/MM/YYYY").format("DD/MM/YYYY");
        }
    },
    computed: {
        title() {
            return this.editMode ? this.txt.titles.editStandard : this.txt.titles.createStandard;
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
                : constants.department.distribution;
            this.stopSaleData.categoryId = this.stopSale?.category?.id ? this.stopSale.category.id : constants.category.standard;
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
            this.getSelectedIds(this.stopSale?.partners, this.stopSaleData.partnersId);
            this.getSelectedIds(this.stopSale?.sellCodes, this.stopSaleData.sellCodesId);
            this.getSelectedIds(this.stopSale?.products, this.stopSaleData.productsId);

            this.stopSaleData.stopSaleTypeId = this.stopSale?.stopSaleType?.id;
            this.stopSaleData.startTime = this.stopSale?.startTime?.time;
            this.stopSaleData.endTime = this.stopSale?.endTime?.time;

            this.getSelectedIds(this.stopSale?.recurrence, this.stopSaleData.recurrencesId);

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
        onChangeRecurrence(e) {
            if (e.target.checked) {
                this.stopSaleData.recurrencesId.push(parseInt(e.target.value));
            } else {
                this.stopSaleData.recurrencesId = this.stopSaleData.recurrencesId.filter(
                    (element) => element !== parseInt(e.target.value)
                );
            }

            this.stopSaleData.recurrencesId.sort((a, b) => a - b);
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

            if (this.stopSaleData.pickUpBranchId.length == 0) {
                this.$notify({
                    type: "warn",
                    text: this.txt.form.selectABranch,
                });
                document.querySelector("#pickUpBranchId").focus();
                return false;
            }

            if (this.stopSaleData.recurrencesId.length == 7) {
                this.$notify({
                    type: "warn",
                    text: this.txt.form.onlySixRecurrences,
                });
                return false;
            }

            return true;
        },
        submitStopSale: async function() {
            if (this.checkStopSale()) {
                Loading.starLoading();

                let formData = new FormData();
                let stopSaleData = { ...this.stopSaleData };
                if (stopSaleData.connectedVehicle !== null && stopSaleData.connectedVehicle !== undefined) {
                    if (parseInt(stopSaleData.connectedVehicle) === 1) {
                        stopSaleData.connectedVehicle = true;
                    } else if (parseInt(stopSaleData.connectedVehicle) === 2) {
                        stopSaleData.connectedVehicle = false;
                    }
                }
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
                                    stopSaleCategory: "standard",
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
