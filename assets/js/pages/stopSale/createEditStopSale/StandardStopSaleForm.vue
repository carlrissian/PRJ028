<template>
    <fragment>
        <notifications position="top right"></notifications>

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
                                        v-model="stopSale.categoryId"
                                        required
                                    />

                                    <input
                                        type="hidden"
                                        name="departmentId"
                                        id="departmentId"
                                        v-model="stopSale.departmentId"
                                        required
                                    />

                                    <div class="row">
                                        <!-- Stop Sale Type -->
                                        <single-select-picker
                                            @onChangeSelectPicker="canSubmit = true"
                                            @updatedSelectPicker="stopSale.stopSaleTypeId = $event"
                                            name="stopSaleTypeId"
                                            id="stopSaleTypeId"
                                            divClass="form-group col-md-2"
                                            :placeholder="txt.form.selectAnOption"
                                            :label="txt.fields.stopSaleType"
                                            :options="selectList.stopSaleTypeList"
                                            :value="stopSale.stopSaleTypeId"
                                            required
                                            :disabled="editMode"
                                            v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->

                                        <!-- Car groups -->
                                        <multiple-select-picker
                                            @updatedMultipleSelectPicker="
                                                (stopSale.carGroupsId = $event), onChangeCarGroup($event)
                                            "
                                            name="carGroupsId[]"
                                            id="carGroupsId"
                                            divClass="form-group col-md-2"
                                            :placeholder="txt.form.selectAnOption"
                                            :label="txt.fields.carGroups"
                                            :options="selectList.carGroupList"
                                            :value="stopSale.carGroupsId"
                                            v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->

                                        <!-- ACRISS -->
                                        <multiple-select-picker
                                            @updatedMultipleSelectPicker="(stopSale.acrissId = $event), onChangeAcriss($event)"
                                            name="acrissId[]"
                                            id="acrissId"
                                            divClass="form-group col-md-2"
                                            :placeholder="txt.form.selectAnOption"
                                            :label="txt.fields.acriss"
                                            :options="selectList.acrissList"
                                            :value="stopSale.acrissId"
                                            v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->

                                        <!-- Regions -->
                                        <!-- <multiple-select-picker
                                            @updatedMultipleSelectPicker="stopSale.regionsId = $event"
                                            name="regionPickUpId[]"
                                            id="regionPickUpId"
                                            divClass="form-group col-md-2"
                                            :placeholder="txt.form.selectAnOption"
                                            :label="txt.fields.regions"
                                            :options="selectList.regionList"
                                            :value="stopSale.regionsId"
                                            v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                        /> -->
                                        <!--  -->

                                        <!-- Areas -->
                                        <!-- <multiple-select-picker
                                            @updatedMultipleSelectPicker="stopSale.areasId = $event"
                                            name="areaPickUpId[]"
                                            id="areaPickUpId"
                                            divClass="form-group col-md-2"
                                            :placeholder="txt.form.selectAnOption"
                                            :label="txt.fields.areas"
                                            :options="selectList.areaList"
                                            :value="stopSale.areasId"
                                            v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                        /> -->
                                        <!--  -->

                                        <!-- Branches -->
                                        <multiple-select-picker
                                            @updatedMultipleSelectPicker="stopSale.branchPickUpId = $event"
                                            name="branchPickUpId[]"
                                            id="branchPickUpId"
                                            divClass="form-group col-md-2"
                                            :placeholder="txt.form.selectAnOption"
                                            :label="txt.fields.branches"
                                            :options="selectList.branchList"
                                            :value="stopSale.branchPickUpId"
                                            v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->
                                    </div>

                                    <div class="row">
                                        <!-- Connected vehicle -->
                                        <single-select-picker
                                            name="connectedVehicle"
                                            id="connectedVehicle"
                                            divClass="form-group col-md-2"
                                            :label="txt.fields.connectedVehicle"
                                            :placeholder="txt.form.selectAnOption"
                                            :value="stopSale.connectedVehicle"
                                            :style="!canBeEditCreated ? styleObjectNo : styleObject"
                                            @onChangeSelectPicker="canSubmit = true"
                                            @updatedSelectPicker="stopSale.connectedVehicle = $event"
                                        >
                                            <option :value="true">{{ txt.form.yes }}</option>
                                            <option :value="false">{{ txt.form.no }}</option>
                                        </single-select-picker>
                                        <!--  -->

                                        <!-- Partners -->
                                        <multiple-select-picker
                                            @updatedMultipleSelectPicker="stopSale.partnersId = $event"
                                            name="partnersId[]"
                                            id="partnersId"
                                            divClass="form-group col-md-2"
                                            :placeholder="txt.form.selectAnOption"
                                            :label="txt.fields.partners"
                                            :options="selectList.partnerList"
                                            :value="stopSale.partnersId"
                                            v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->

                                        <!-- Sell Codes -->
                                        <multiple-select-picker
                                            @updatedMultipleSelectPicker="stopSale.sellCodesId = $event"
                                            name="sellCodesId[]"
                                            id="sellCodesId"
                                            divClass="form-group col-md-2"
                                            :placeholder="txt.form.selectAnOption"
                                            :label="txt.fields.sellCodes"
                                            :options="selectList.sellCodeList"
                                            :value="stopSale.sellCodesId"
                                            v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->

                                        <!-- Products -->
                                        <multiple-select-picker
                                            @updatedMultipleSelectPicker="stopSale.productsId = $event"
                                            name="productsId[]"
                                            id="productsId"
                                            divClass="form-group col-md-2"
                                            :placeholder="txt.form.selectAnOption"
                                            :label="txt.fields.products"
                                            :options="selectList.productList"
                                            :value="stopSale.productsId"
                                            v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->
                                    </div>

                                    <div class="row">
                                        <!-- Init date -->
                                        <date-picker
                                            @updatedDatePicker="(stopSale.initDate = $event), (canSubmit = true)"
                                            name="stopSaleInitDate"
                                            id="stopSaleInitDate"
                                            divClass="form-group col-md-2"
                                            :label="txt.fields.initDate"
                                            :limit-start-day="new Date()"
                                            :limit-end-day="stopSale.endDate"
                                            :value="stopSale.initDate"
                                            required
                                            :disabled="editMode ? stopSale.initDate < new Date() : false"
                                            v-bind:style="[
                                                canBeEditCreated !== true && stopSaleData ? styleObjectNo : styleObject,
                                            ]"
                                        />
                                        <!--  -->

                                        <!-- End date -->
                                        <date-picker
                                            @updatedDatePicker="(stopSale.endDate = $event), (canSubmit = true)"
                                            name="stopSaleEndDate"
                                            id="stopSaleEndDate"
                                            divClass="form-group col-md-2"
                                            :label="txt.fields.endDate"
                                            :limit-start-day="stopSale.initDate"
                                            :value="stopSale.endDate"
                                            required
                                            v-bind:style="[
                                                canBeEditCreated !== true && stopSaleData ? styleObjectNo : styleObject,
                                            ]"
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
                                                    :checked="stopSale.recurrencesId.includes(day.id)"
                                                />
                                            </div>
                                        </div>
                                        <!--  -->
                                    </div>

                                    <div class="row">
                                        <!-- Start Time -->
                                        <time-picker
                                            @onChangeTimePicker="canSubmit = true"
                                            @updatedTimePicker="stopSale.startTime = $event"
                                            name="startTime"
                                            id="startTime"
                                            divClass="form-group col-md-2"
                                            :label="txt.fields.startTime"
                                            :limit-end-time="stopSale.initDate == stopSale.endDate ? stopSale.endTime : null"
                                            :value="stopSale.startTime"
                                            v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->

                                        <!-- End Time -->
                                        <time-picker
                                            @onChangeTimePicker="canSubmit = true"
                                            @updatedTimePicker="stopSale.endTime = $event"
                                            name="endTime"
                                            id="endTime"
                                            divClass="form-group col-md-2"
                                            :label="txt.fields.endTime"
                                            :limit-start-time="stopSale.initDate == stopSale.endDate ? stopSale.startTime : null"
                                            :value="stopSale.endTime"
                                            v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->

                                        <!-- Min Days Rent -->
                                        <input-number
                                            @onInputChangeInputNumber="canSubmit = true"
                                            @onChangeInputNumber="canSubmit = true"
                                            @updatedInputNumber="stopSale.minDaysRent = $event"
                                            name="minDaysRent"
                                            id="minDaysRent"
                                            divClass="form-group col-md-2"
                                            :min="0"
                                            :label="txt.fields.minDaysRent"
                                            :value="stopSale.minDaysRent"
                                            v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->

                                        <!-- Max Days Rent -->
                                        <input-number
                                            @onInputChangeInputNumber="canSubmit = true"
                                            @onChangeInputNumber="canSubmit = true"
                                            @updatedInputNumber="stopSale.maxDaysRent = $event"
                                            name="maxDaysRent"
                                            id="maxDaysRent"
                                            divClass="form-group col-md-2"
                                            :min="0"
                                            :label="txt.fields.maxDaysRent"
                                            :value="stopSale.maxDaysRent"
                                            v-bind:style="[canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->
                                    </div>

                                    <div class="row">
                                        <!-- Notes -->
                                        <text-area
                                            @updatedTextArea="(stopSale.notes = $event), (canSubmit = true)"
                                            name="notes"
                                            id="notes"
                                            divClass="form-group col-md-12"
                                            :cols="30"
                                            :rows="8"
                                            :label="txt.fields.notes"
                                            :value="stopSale.notes"
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
    </fragment>
</template>

<script>
import Loading from "../../../../assets/js/utilities";
import CheckBox from "../../../../SharedAssets/vue/components/base/inputs/CheckBox";
import DatePicker from "../../../../SharedAssets/vue/components/base/inputs/DatePicker";
import InputNumber from "../../../../SharedAssets/vue/components/base/inputs/InputNumber";
import MultipleSelectPicker from "../../../../SharedAssets/vue/components/base/inputs/MultipleSelectPicker";
import SingleSelectPicker from "../../../../SharedAssets/vue/components/base/inputs/SingleSelectPicker";
import TextArea from "../../../../SharedAssets/vue/components/base/inputs/TextArea";
import TimePicker from "../../../../SharedAssets/vue/components/base/inputs/TimePicker";

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
        stopSaleData: Object,
    },
    data() {
        return {
            txt: txtTrans,
            title: null,
            submitButton: null,
            submitButtonClass: null,
            editMode: false,

            stopSale: {
                id: null,
                categoryId: null,
                departmentId: null,
                initDate: null,
                endDate: null,
                carGroupsId: [],
                acrissId: [],
                regionPickUpId: [],
                areaPickUpId: [],
                branchPickUpId: [],
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
            },
            styleObject: {
                pointerEvents: "visible",
                opacity: "1",
            },
        };
    },
    created() {
        this.selectList.carGroupList.sort((a, b) => {
            let nameA = a.name.toLowerCase();
            let nameB = b.name.toLowerCase();
            if (nameA < nameB) return -1;
            if (nameA > nameB) return 1;
            return 0;
        });
        this.selectList.acrissList.sort((a, b) => {
            let nameA = a.name.toLowerCase();
            let nameB = b.name.toLowerCase();
            if (nameA < nameB) return -1;
            if (nameA > nameB) return 1;
            return 0;
        });
        this.selectList.partnerList.sort((a, b) => {
            let nameA = a.name.toLowerCase();
            let nameB = b.name.toLowerCase();
            if (nameA < nameB) return -1;
            if (nameA > nameB) return 1;
            return 0;
        });
        this.selectList.sellCodeList.sort((a, b) => {
            let nameA = a.name.toLowerCase();
            let nameB = b.name.toLowerCase();
            if (nameA < nameB) return -1;
            if (nameA > nameB) return 1;
            return 0;
        });
        this.selectList.productList.sort((a, b) => {
            let nameA = a.name.toLowerCase();
            let nameB = b.name.toLowerCase();
            if (nameA < nameB) return -1;
            if (nameA > nameB) return 1;
            return 0;
        });
    },
    mounted() {
        this.canBeEditCreated = this.selectList.canBeEditCreated;

        if (![null, undefined].includes(this.stopSaleData)) {
            this.editMode = true;
            this.title = this.txt.titles.editStandard;
            this.submitButton = this.txt.form.update;
            this.submitButtonClass = "la-edit";
            this.fillStopSaleData();
        } else {
            this.title = this.txt.titles.createStandard;
            this.submitButton = this.txt.form.create;
            this.submitButtonClass = "la-plus";
            this.stopSale.departmentId = constants.department.distribution;
            this.stopSale.categoryId = constants.category.standard;
            // this.stopSale.startTime = moment("00:00", "HH:mm").format("HH:mm");
            // this.stopSale.endTime = moment("23:59", "HH:mm").format("HH:mm");
            this.stopSale.initDate = moment(new Date(), "DD/MM/YYYY").format("DD/MM/YYYY");
        }
    },
    methods: {
        fillStopSaleData() {
            this.stopSale.id = this.stopSaleData?.id;
            this.stopSale.departmentId = this.stopSaleData?.department?.id
                ? this.stopSaleData.department.id
                : constants.department.distribution;
            this.stopSale.categoryId = this.stopSaleData?.category?.id
                ? this.stopSaleData.category.id
                : constants.category.standard;
            this.stopSale.initDate = this.stopSaleData?.initDate;
            this.stopSale.endDate = this.stopSaleData?.endDate;
            if (this.stopSaleData.acriss != null)
                this.getSelectedIds(
                    this.stopSaleData.acriss.map((item) => item?.carGroup),
                    this.stopSale.carGroupsId
                );

            if (this.stopSaleData.acriss != null) this.getSelectedIds(this.stopSaleData.acriss, this.stopSale.acrissId);

            if (this.stopSaleData.regionPickUp != null)
                this.getSelectedIds(this.stopSaleData.regionPickUp, this.stopSale.regionPickUpId);

            if (this.stopSaleData.areaPickUp != null)
                this.getSelectedIds(this.stopSaleData.areaPickUp, this.stopSale.areaPickUpId);

            if (this.stopSaleData.branchPickUp != null)
                this.getSelectedIds(this.stopSaleData.branchPickUp, this.stopSale.branchPickUpId);

            if (this.stopSaleData.partners != null) this.getSelectedIds(this.stopSaleData.partners, this.stopSale.partnersId);

            if (this.stopSaleData.sellCodes != null) this.getSelectedIds(this.stopSaleData.sellCodes, this.stopSale.sellCodesId);

            if (this.stopSaleData.products != null) this.getSelectedIds(this.stopSaleData.products, this.stopSale.productsId);

            this.stopSale.stopSaleTypeId = this.stopSaleData?.stopSaleType?.id;
            this.stopSale.startTime = this.stopSaleData?.startTime?.time;
            this.stopSale.endTime = this.stopSaleData?.endTime?.time;

            if (this.stopSaleData.recurrence != null)
                this.getSelectedIds(this.stopSaleData.recurrence, this.stopSale.recurrencesId);

            this.stopSale.minDaysRent = this.stopSaleData?.minDaysRent;
            this.stopSale.maxDaysRent = this.stopSaleData?.maxDaysRent;
            this.stopSale.connectedVehicle = this.stopSaleData?.connectedVehicle;
            this.stopSale.notes = this.stopSaleData?.notes;
        },
        getSelectedIds(arrayFrom, arrayTo) {
            arrayFrom.map((obj) => {
                arrayTo.push(obj.id);
            });
        },
        onChangeCarGroup(selection) {
            this.stopSale.acrissId = this.selectList.acrissList
                .filter((acriss) => selection.includes(acriss.carGroupId))
                .map((acriss) => acriss.id);
        },
        onChangeAcriss(selection) {
            this.stopSale.carGroupsId = this.selectList.acrissList
                .filter((acriss) => selection.includes(acriss.id))
                .map((acriss) => acriss.carGroupId);
        },
        onChangeRecurrence(e) {
            if (e.target.checked) {
                this.stopSale.recurrencesId.push(parseInt(e.target.value));
            } else {
                this.stopSale.recurrencesId = this.stopSale.recurrencesId.filter(
                    (element) => element !== parseInt(e.target.value)
                );
            }

            this.stopSale.recurrencesId.sort((a, b) => a - b);
        },
        checkStopSale() {
            if (this.canBeEditCreated !== true) {
                this.$notify({
                    type: "error",
                    text: this.txt.form.cannotBeEditCreated,
                });
                return false;
            }

            if (this.stopSale.carGroupsId.length == 0 && this.stopSale.acrissId.length == 0) {
                this.$notify({
                    type: "warn",
                    text: this.txt.form.selectAGroupOrAcriss,
                });
                document.querySelector("#acrissId").focus();
                return false;
            }

            if (this.stopSale.branchPickUpId.length == 0) {
                this.$notify({
                    type: "warn",
                    text: this.txt.form.selectABranch,
                });
                document.querySelector("#branchPickUpId").focus();
                return false;
            }

            if (this.stopSale.recurrencesId.length == 7) {
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
                formData.set("stopSale", JSON.stringify(this.stopSale));

                let url = this.editMode
                    ? this.routing.generate("stopsale.update", {
                          id: this.stopSale.id,
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
