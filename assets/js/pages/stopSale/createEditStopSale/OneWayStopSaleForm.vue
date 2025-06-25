<template>
    <fragment>
        <notifications position="top right"></notifications>

        <form @submit.prevent="submitStopSale" ref="createStopSaleOneWay" enctype="multipart/form-data">
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

                                    <input
                                        type="hidden"
                                        name="stopSaleTypeId"
                                        v-model="stopSale.stopSaleTypeId"
                                    />

                                    <div class="row">
                                        <!-- Init date -->
                                        <erp-date-picker-static-filter
                                            @updateDatePicker="changedPicker('stopSaleInitDate', 'stopSaleEndDate', $event)"
                                            id="stopSaleInitDate"
                                            name="stopSaleInitDate"
                                            class-number="2"
                                            :label="txt.fields.initDate"
                                            :limit-start-day="new Date()"
                                            :limit-end-day="stopSale.endDate"
                                            :value="stopSale.initDate"
                                            :required="true"
                                            :disabled="editMode ? stopSale.initDate < new Date() : false"
                                            v-bind:style="[this.canBeEditCreated === true ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->

                                        <!-- End date -->
                                        <erp-date-picker-static-filter
                                            @updateDatePicker="changedPicker('stopSaleInitDate', 'stopSaleEndDate', $event)"
                                            name="stopSaleEndDate"
                                            id="stopSaleEndDate"
                                            class-number="2"
                                            :label="txt.fields.endDate"
                                            :limit-start-day="stopSale.initDate"
                                            :value="stopSale.endDate"
                                            :required="true"
                                        />
                                        <!--  -->

                                        <!-- Car groups -->
                                        <erp-multiple-select-static-filter
                                            @changeSelectMultiple="onChangeCarGroup"
                                            name="carGroupsId[]"
                                            id="carGroupsId"
                                            class-number="2"
                                            :label="txt.fields.carGroups"
                                            :data-for-ajax="carGroupList"
                                            :value="stopSale.carGroupsId"
                                            :disabled="disableGroupAcriss"
                                            v-bind:style="[disableGroupAcriss ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->

                                        <!-- ACRISS -->
                                        <erp-multiple-select-static-filter
                                            @changeSelectMultiple="onChangeAcriss"
                                            name="acrissId[]"
                                            id="acrissId"
                                            class-number="2"
                                            :label="txt.fields.acriss"
                                            :data-for-ajax="acrissList"
                                            :value="stopSale.acrissId"
                                            :disabled="disableGroupAcriss"
                                            v-bind:style="[disableGroupAcriss ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->

                                    </div>

                                    <!-- Pick Up -->
                                    <div class="row">

                                        <!-- Areas -->
                                        <erp-multiple-select-static-filter
                                            @changeSelectMultiple="onChangeAreaPickUp()"
                                            name="areaPickUpId[]"
                                            id="areaPickUpId"
                                            class-number="2"
                                            :label="txt.fields.originArea"
                                            :data-for-ajax="areaList"
                                            :value="stopSale.areaPickUpId"
                                            v-bind:style="[this.canBeEditCreated === true ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->

                                        <!-- Branches -->
                                        <erp-multiple-select-static-filter
                                            @changeSelectMultiple="onChangeBranchPickUp()"
                                            name="branchPickUpId[]"
                                            id="branchPickUpId"
                                            class-number="2"
                                            :label="txt.fields.originBranch"
                                            :data-for-ajax="branchList"
                                            :value="stopSale.branchPickUpId"
                                            :disabled="disableBranchPickUp"
                                            v-bind:style="[disableBranchPickUp ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->
                                    </div>
                                    <!--  -->

                                    <!-- Drop Off -->
                                    <div class="row">
                                        <!-- Regions -->
                                        <erp-multiple-select-static-filter
                                            @changeSelectMultiple="onChangeRegionDropOff()"
                                            name="regionDropOffId[]"
                                            id="regionDropOffId"
                                            class-number="2"
                                            :label="txt.fields.destinyRegion"
                                            :data-for-ajax="regionList"
                                            :value="stopSale.regionDropOffId"
                                            v-bind:style="[this.canBeEditCreated === true ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->

                                        <!-- Areas -->
                                        <erp-multiple-select-static-filter
                                            @changeSelectMultiple="onChangeAreaDropOff()"
                                            name="areaDropOffId[]"
                                            id="areaDropOffId"
                                            class-number="2"
                                            :label="txt.fields.destinyArea"
                                            :data-for-ajax="areaList"
                                            :value="stopSale.areaDropOffId"
                                            v-bind:style="[this.canBeEditCreated === true ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->

                                        <!-- Branches -->
                                        <erp-multiple-select-static-filter
                                            @changeSelectMultiple="onChangeBranchDropOff()"
                                            name="branchDropOffId[]"
                                            id="branchDropOffId"
                                            class-number="2"
                                            :label="txt.fields.destinyBranch"
                                            :data-for-ajax="branchList"
                                            :value="stopSale.branchDropOffId"
                                            v-bind:style="[this.canBeEditCreated === true ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->
                                    </div>
                                    <!--  -->

                                    <div class="row">
                                        <!-- Min Days Rent -->
                                        <input-number
                                            @onInputChangeInputNumber="canSubmit = true"
                                            @onChangeInputNumber="canSubmit = true"
                                            @updatedInputNumber="stopSale.minDaysRent = $event"
                                            name="minDaysRent"
                                            id="minDaysRent"
                                            :min="0"
                                            :label="this.txt.fields.minDaysRent"
                                            :value="stopSale.minDaysRent"
                                            v-bind:style="[this.canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->

                                        <!-- Max Days Rent -->
                                        <input-number
                                            @onInputChangeInputNumber="canSubmit = true"
                                            @onChangeInputNumber="canSubmit = true"
                                            @updatedInputNumber="stopSale.maxDaysRent = $event"
                                            name="maxDaysRent"
                                            id="maxDaysRent"
                                            :min="0"
                                            :label="this.txt.fields.maxDaysRent"
                                            :value="stopSale.maxDaysRent"
                                            v-bind:style="[this.canBeEditCreated !== true ? styleObjectNo : styleObject]"
                                        />
                                        <!--  -->

                                      <!-- Connected Vehicle (solo One-Way) -->
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

                                        <!--Notes-->
                                        <div
                                            class="form-group col-md-12"
                                            v-bind:style="[this.canBeEditCreated === true ? styleObjectNo : styleObject]"
                                        >
                                            <label for="notes" v-text="this.txt.fields.notes"></label>
                                            <textarea
                                                name="notes"
                                                id="notes"
                                                class="form-control"
                                                cols="30"
                                                rows="8"
                                                :placeholder="this.txt.fields.notes"
                                                v-model="stopSale.notes"
                                            ></textarea>
                                        </div>
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
    </fragment>
</template>

<script>
import Axios from "axios";
import Loading from "../../../../assets/js/utilities";
import ErpMultipleSelectStaticFilter from "../../../components/filterStatic/form/ErpMultipleSelectStaticFilter";
import ErpDatePickerStaticFilter from "../../../components/filterStatic/form/ErpDatePickerStaticFilter";

export default {
    name: "OneWayStopSaleForm",
    components: {
        ErpMultipleSelectStaticFilter,
        ErpDatePickerStaticFilter,
    },
    props: {
        selectList: Object,
        stopSaleData: Object,
    },
    data() {
        return {
            txt: {},
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
                regionDropOffId: [],
                areaPickUpId: [],
                areaDropOffId: [],
                branchPickUpId: [],
                branchDropOffId: [],
                recurrencesId: [],
                stopSaleTypeId: null,
                minDaysRent: null,
                maxDaysRent: null,
                connectedVehicle: null,
                notes: null,
                cancelled: null,
            },
            canBeEditCreated: false,
            canSubmit: false,
            carGroupList: [],
            acrissList: [],
            regionList: [],
            areaList: [],
            branchList: [],
            daysList: [],
            connectedVehicleList: [],

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
        this.txt = txtTrans;

        this.stopSale.stopSaleTypeId = 1;
    },
    mounted() {
        this.canBeEditCreated = this.selectList.canBeEditCreated;
        this.carGroupList = this.selectList.carGroupList;
        this.acrissList = this.selectList.acrissList;
        this.regionList = this.selectList.regionList;
        this.areaList = this.selectList.areaList;
        this.branchList = this.selectList.branchList;
        this.daysList = this.selectList.daysList;
        this.connectedVehicleList = this.selectList.connectedVehicleList;
        this.stopSaleStatusList = this.selectList.stopSaleStatusList;

        // selectpicker
        this.loadSelectPickers();

        if (this.stopSaleData != undefined && this.stopSaleData != null) {
            this.editMode = true;
            this.title = this.txt.titles.editOneWay;
            this.submitButton = this.txt.form.update;
            this.submitButtonClass = "la-edit";
            this.fillStopSaleData();
        } else {
            this.title = this.txt.titles.createOneWay;
            this.submitButton = this.txt.form.create;
            this.submitButtonClass = "la-plus";
            this.stopSale.departmentId = constants.department.distribution;
            this.stopSale.categoryId = constants.category.oneway;
            this.stopSale.startTime = moment(new Date(), "HH:mm").format("HH:mm");
            this.stopSale.endTime = moment(new Date(), "HH:mm")
                .add(32, "hour")
                .format("HH:mm");
            this.stopSale.initDate = moment(new Date(), "DD/MM/YYYY").format("DD/MM/YYYY");
        }
    },
    updated() {
        this.$nextTick(function() {
            $("#carGroupsId").selectpicker("refresh");
            $("#acrissId").selectpicker("refresh");
            $("#regionDropOffId").selectpicker("refresh");
            $("#areaPickUpId").selectpicker("refresh");
            $("#areaDropOffId").selectpicker("refresh");
            $("#branchPickUpId").selectpicker("refresh");
            $("#branchDropOffId").selectpicker("refresh");
            $("#connectedVehicle").selectpicker("refresh");
        });
    },
    computed: {
        disableGroupAcriss() {
            return (
                this.stopSale.endDate &&
                this.stopSale.carGroupsId.length === 0 &&
                this.stopSale.acrissId.length === 0
            );
        },
        disableBranchPickUp() {
            return (
                this.stopSale.endDate && this.stopSale.branchPickUpId.length === 0
            );
        },
    },
    watch: {
        disableGroupAcriss(val) {
            if (val) {
                this.stopSale.carGroupsId = [];
                this.stopSale.acrissId = [];
            }
        },
        disableBranchPickUp(val) {
            if (val) {
                this.stopSale.branchPickUpId = [];
            }
        },
    },
    methods: {
        showNotification(type = "", text = "") {
            this.$notify({
                text,
                type,
            });
        },
        loadSelectPickers: function() {
            let config = {
                noneSelectedText: this.txt.form.selectAnOption,
                actionsBox: true,
            };

            // connectedVehicle
            let connectedVehicle = $("#connectedVehicle");
            connectedVehicle.selectpicker(config);
        },
        fillStopSaleData() {
            this.stopSale.id = this.stopSaleData?.id;
            this.stopSale.departmentId = this.stopSaleData?.department?.id
                ? this.stopSaleData.department.id
                : constants.department.distribution;
            this.stopSale.categoryId = this.stopSaleData?.category?.id
                ? this.stopSaleData.category.id
                : constants.category.oneway;
            this.stopSale.initDate = this.stopSaleData?.initDate;
            this.stopSale.endDate = this.stopSaleData?.endDate;
            if (this.stopSaleData.acriss != null)
                this.getSelectedIds(
                    this.stopSaleData.acriss.map((item) => item?.carGroup),
                    this.stopSale.carGroupsId
                );

            if (this.stopSaleData.acriss != null) this.getSelectedIds(this.stopSaleData.acriss, this.stopSale.acrissId);


            if (this.stopSaleData.regionDropOff != null)
                this.getSelectedIds(this.stopSaleData.regionDropOff, this.stopSale.regionDropOffId);

            if (this.stopSaleData.areaPickUp != null)
                this.getSelectedIds(this.stopSaleData.areaPickUp, this.stopSale.areaPickUpId);

            if (this.stopSaleData.areaDropOff != null)
                this.getSelectedIds(this.stopSaleData.areaDropOff, this.stopSale.areaDropOffId);

            if (this.stopSaleData.branchPickUp != null)
                this.getSelectedIds(this.stopSaleData.branchPickUp, this.stopSale.branchPickUpId);

            if (this.stopSaleData.branchDropOff != null)
                this.getSelectedIds(this.stopSaleData.branchDropOff, this.stopSale.branchDropOffId);

            this.stopSale.stopSaleTypeId = this.stopSaleData?.stopSaleType?.id;
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
        changedPicker(dateFrom, dateTo, e) {
            let { name, value } = e.target;

            if (value) {
                switch (name) {
                    case dateFrom:
                        this.stopSale.initDate = value;
                        break;
                    case dateTo:
                        this.stopSale.endDate = value;
                        break;
                }
            } else {
                if (name === dateTo) {
                    this.stopSale.endDate = null;
                }
            }
        },
        onChangeCarGroup() {
            this.stopSale.carGroupsId = $("#carGroupsId")
                .val()
                .map((element) => parseInt(element));
            this.stopSale.acrissId = [];

            for (let acriss of this.acrissList) {
                if (!acriss.carGroupId) {
                    continue;
                }
                if (this.stopSale.carGroupsId.includes(acriss.carGroupId)) {
                    this.stopSale.acrissId.push(acriss.id);
                }
            }
            let acrissId = $("#acrissId");
            acrissId.val(this.stopSale.acrissId);
        },
        onChangeAcriss() {
            this.stopSale.acrissId = $("#acrissId")
                .val()
                .map((element) => parseInt(element));
            this.stopSale.carGroupsId = [];

            for (let acriss of this.acrissList) {
                if (!acriss.carGroupId) {
                    continue;
                }
                if (this.stopSale.acrissId.includes(acriss.id)) {
                    this.stopSale.carGroupsId.push(acriss.carGroupId);
                }
            }

            let carGroupsId = $("#carGroupsId");
            carGroupsId.val(this.stopSale.carGroupsId);
        },
        onChangeRegionDropOff() {
            this.stopSale.regionDropOffId = $("#regionDropOffId")
                .val()
                .map((element) => parseInt(element));
        },
        onChangeAreaPickUp() {
            this.stopSale.areaPickUpId = $("#areaPickUpId")
                .val()
                .map((element) => parseInt(element));
        },
        onChangeAreaDropOff() {
            this.stopSale.areaDropOffId = $("#areaDropOffId")
                .val()
                .map((element) => parseInt(element));
        },
        onChangeBranchPickUp() {
            this.stopSale.branchPickUpId = $("#branchPickUpId")
                .val()
                .map((element) => parseInt(element));
        },
        onChangeBranchDropOff() {
            this.stopSale.branchDropOffId = $("#branchDropOffId")
                .val()
                .map((element) => parseInt(element));
        },
        submitStopSale: async function() {
            let url = null;
            let validated = true;

            if (this.canBeEditCreated !== true) {
                validated = false;
                this.showNotification("error", this.txt.form.cannotBeEditCreated);
            }

            if (!this.disableGroupAcriss && this.stopSale.carGroupsId.length == 0 && this.stopSale.acrissId.length == 0) {
                validated = false;
                this.showNotification("warn", this.txt.form.selectAGroupOrAcriss);
                document.querySelector("#acrissId").focus();
            }

            if (!this.disableBranchPickUp && this.stopSale.branchPickUpId.length == 0) {
                validated = false;
                this.showNotification("warn", this.txt.form.selectABranch);
                document.querySelector("#branchPickUpId").focus();
            }

            if (this.stopSale.recurrencesId.length == 7) {
                validated = false;
                this.showNotification("warn", this.txt.form.onlySixRecurrences);
            }

            if (validated) {
                let formData = new FormData();
                formData.set("stopSale", JSON.stringify(this.stopSale));

                if (!this.editMode) {
                    url = this.routing.generate("stopsale.store");
                    Axios.post(url, formData)
                        .then((response) => {
                            // console.log("Create StopSale: ", response);
                            if (response.status == 200) {
                                this.showNotification("success", this.txt.form.stopSaleCreatedSuccessNotification);

                                setTimeout(() => {
                                    window.location.href = this.routing.generate("stopsale.list", {
                                        stopSaleCategory: "oneway",
                                    });
                                }, 2000);
                            } else {
                                this.showNotification("error", this.txt.form.errorCreatingStopSaleNotification);
                            }
                        })
                        .catch((e) => {
                            console.log(e);
                            this.showNotification("error", this.txt.form.errorCreatingStopSaleNotification);
                        });
                } else {
                    url = this.routing.generate("stopsale.update", {
                        id: this.stopSale.id,
                    });
                    Axios.post(url, formData)
                        .then((response) => {
                            // console.log("Update StopSale: ", response);
                            if (response.status == 200) {
                                this.showNotification("success", this.txt.form.stopSaleUpdatedSuccessNotification);

                                setTimeout(() => {
                                    window.location.href = this.routing.generate("stopsale.list", {
                                        stopSaleCategory: "oneway",
                                    });
                                }, 2000);
                            } else {
                                this.showNotification("error", this.txt.form.errorUpdatingStopSaleNotification);
                            }
                        })
                        .catch((e) => {
                            console.log(e);
                            this.showNotification("error", this.txt.form.errorUpdatingStopSaleNotification);
                        });
                }
            }
        },
    },
};
</script>

<style scoped></style>
