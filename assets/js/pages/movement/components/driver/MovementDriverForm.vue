<template>
    <form @submit.prevent="submitMovement" enctype="multipart/form-data">
        <!-- Movement general info -->
        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--bordered">
                    <div class="kt-portlet__body">
                        <div class="kt-portlet kt-portlet--bordered">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title" v-text="title"></h3>
                                </div>
                            </div>

                            <div class="kt-portlet__body">
                                <div class="row">
                                    <!-- Driver type -->
                                    <div class="form-group col-md-3">
                                        <label for="driverType" v-text="this.txt.fields.driverType"></label>
                                        <div class="kt-radio-inline">
                                            <radio-button
                                                @onChangeRadioButton="setCategory('driverType', $event)"
                                                @updatedRadioButton="movement.driverTypeId = $event"
                                                v-for="driverType in driverTypeList"
                                                :key="driverType.id"
                                                name="driverType"
                                                :label="driverType.label"
                                                :value="driverType.id"
                                                :checked="movement.driverTypeId == driverType.id"
                                                :disabled="isInProgress"
                                                required
                                            />
                                        </div>
                                    </div>
                                    <!--  -->

                                    <!-- Origin location -->
                                    <input-base
                                        @updatedInputBase="movement.originLocation.name = $event"
                                        name="originLocationName"
                                        id="originLocationName"
                                        div-class="form-group col-md-3"
                                        :label="txt.fields.originLocation"
                                        :value="movement.originLocation.name"
                                        input-group
                                        disabled
                                    >
                                        <template #apend>
                                            <button
                                                @click="openCloseOriginLocationForm"
                                                type="button"
                                                class="btn btn-sm btn-clean btn-icon btn-icon-md btn-circle"
                                                :class="showOriginLocationForm ? 'close' : 'add'"
                                                :title="txt.form.createLocation"
                                                :disabled="isInProgress"
                                            >
                                                <i :class="showOriginLocationForm ? 'flaticon2-cross' : 'flaticon2-add-1'"></i>
                                            </button>
                                        </template>
                                    </input-base>

                                    <!-- Destination branch -->
                                    <single-select-picker
                                        @updatedSelectPicker="
                                            movement.destinationLocation.branchId = $event;
                                            filterLocationList($event, 'destination');
                                        "
                                        name="destinationBranchId"
                                        id="destinationBranchId"
                                        divClass="form-group col-md-3"
                                        :label="txt.fields.destinationBranch"
                                        :placeholder="txt.form.selectAnOption"
                                        :value="movement.destinationLocation.branchId"
                                        :options="selectList.branchList"
                                        :disabled="isInProgress"
                                    />

                                    <!-- Destination location -->
                                    <single-select-picker
                                        @onChangeSelectPicker="setCategory('destinationLocation', $event)"
                                        @updatedSelectPicker="movement.destinationLocation.id = $event"
                                        name="destinationLocation"
                                        id="destinationLocation"
                                        divClass="form-group col-md-3"
                                        :label="this.txt.fields.destinationLocation"
                                        :placeholder="this.txt.form.selectAnOption"
                                        required
                                        :value="movement.destinationLocation.id"
                                        :options="this.destinationLocationList"
                                        :disabled="isInProgress"
                                    >
                                        <option
                                            v-for="item in constants.locations"
                                            :key="item.id"
                                            :value="item.id"
                                            v-text="item.name"
                                        >
                                        </option>
                                    </single-select-picker>
                                    <!--  -->
                                </div>

                                <!-- External location form -->
                                <div v-if="showExternalLocationForm" class="row external-location">
                                    <!-- External provider -->
                                    <single-select-picker
                                        @updatedSelectPicker="
                                            onChangeExternalLocationProvider($event);
                                            movement.destinationExternalLocation.providerId = $event;
                                        "
                                        name="destinationExternalLocationProviderId"
                                        id="destinationExternalLocationProviderId"
                                        divClass="form-group col-md-3"
                                        :label="this.txt.fields.destinationExternalProvider"
                                        :placeholder="this.txt.form.selectAnOption"
                                        required
                                        :value="movement.destinationExternalLocation.providerId"
                                        :options="selectList.supplierList"
                                        :disabled="isInProgress"
                                    >
                                    </single-select-picker>
                                    <!--  -->

                                    <!-- External destination location -->
                                    <single-select-picker
                                        @updatedSelectPicker="movement.destinationExternalLocation.locationId = $event"
                                        name="destinationExternalLocationId"
                                        id="destinationExternalLocationId"
                                        divClass="form-group col-md-3"
                                        :label="this.txt.fields.destinationExternalLocation"
                                        :placeholder="this.txt.form.selectAnOption"
                                        required
                                        :value="movement.destinationExternalLocation.locationId"
                                        :options="this.externalDestinationLocationList"
                                        :disabled="isInProgress"
                                    >
                                    </single-select-picker>
                                    <!--  -->
                                </div>
                                <!--  -->

                                <div class="row">
                                    <!-- Expected departure date -->
                                    <date-picker
                                        @updatedDatePicker="movement.expectedDepartureDate = $event"
                                        name="expectedDepartureDate"
                                        id="expectedDepartureDate"
                                        divClass="form-group col-md-3"
                                        :label="this.txt.fields.expectedDepartureDate"
                                        :placeholder="this.txt.fields.expectedDepartureDate"
                                        :value="movement.expectedDepartureDate"
                                        disabled
                                        required
                                    />
                                    <!--  -->

                                    <!-- Expected Arrival date -->
                                    <date-picker
                                        @updatedDatePicker="movement.expectedArrivalDate = $event"
                                        name="expectedArrivalDate"
                                        id="expectedArrivalDate"
                                        divClass="form-group col-md-3"
                                        :label="this.txt.fields.expectedArrivalDate"
                                        :placeholder="this.txt.fields.expectedArrivalDate"
                                        :limit-start-day="movement.expectedDepartureDate"
                                        :value="movement.expectedArrivalDate"
                                        required
                                    />
                                    <!--  -->

                                    <!-- Auth department -->
                                    <single-select-picker
                                        @updatedSelectPicker="movement.authDepartmentId = $event"
                                        name="authDepartment"
                                        id="authDepartment"
                                        divClass="form-group col-md-3"
                                        :label="this.txt.fields.authDepartment"
                                        :placeholder="this.txt.form.selectAnOption"
                                        :value="movement.authDepartmentId"
                                        :options="this.selectList.departmentList"
                                        :required="movement.categoryId === constants.category.notOrdinary"
                                    >
                                    </single-select-picker>
                                    <!--  -->

                                    <!-- Notes -->
                                    <text-area
                                        @updatedTextArea="movement.notes = $event"
                                        name="notes"
                                        id="notes"
                                        divClass="form-group col-md-12"
                                        :cols="30"
                                        :rows="8"
                                        :label="this.txt.fields.notes"
                                        :value="movement.notes"
                                    />
                                    <!--  -->
                                </div>
                            </div>
                        </div>

                        <!-- ManualOriginLocation form -->
                        <div v-if="this.showOriginLocationForm" class="kt-portlet kt-portlet--bordered">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title" v-text="this.txt.titles.newOriginLocation"></h3>
                                </div>
                                <div class="kt-align-right close-btn">
                                    <button
                                        @click="openCloseOriginLocationForm"
                                        type="button"
                                        class="close"
                                        :title="this.txt.form.close"
                                    >
                                        <i class="la la-times"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="kt-portlet__body">
                                <div class="row">
                                    <!-- Origin Country -->
                                    <single-select-picker
                                        @updatedSelectPicker="
                                            movement.originLocation.countryId = $event;
                                            loadStateList($event, 'from');
                                        "
                                        name="originLocationCountryId"
                                        id="originLocationCountryId"
                                        divClass="form-group col-md-3"
                                        :label="this.txt.fields.country"
                                        :placeholder="this.txt.form.selectAnOption"
                                        :value="movement.originLocation.countryId"
                                        required
                                        :options="this.selectList.countryList"
                                        :disabled="isInProgress"
                                    >
                                    </single-select-picker>
                                    <!--  -->

                                    <!-- Origin State -->
                                    <single-select-picker
                                        @updatedSelectPicker="movement.originLocation.stateId = $event"
                                        name="originLocationStateId"
                                        id="originLocationStateId"
                                        divClass="form-group col-md-3"
                                        :label="this.txt.fields.state"
                                        :placeholder="this.txt.form.selectAnOption"
                                        :value="movement.originLocation.stateId"
                                        required
                                        :options="stateListFrom"
                                        :disabled="isInProgress"
                                    >
                                    </single-select-picker>
                                    <!--  -->

                                    <!-- Notes -->
                                    <text-area
                                        @updatedTextArea="movement.originLocation.notes = $event"
                                        name="originLocationNotes"
                                        id="originLocationNotes"
                                        divClass="form-group col-md-12"
                                        :cols="30"
                                        :rows="8"
                                        :label="this.txt.fields.notes"
                                        :value="movement.originLocation.notes"
                                        required
                                    />
                                    <!--  -->
                                </div>
                            </div>
                        </div>
                        <!--  -->

                        <!-- ManualDestinationLocation form -->
                        <div v-if="this.showDestinationLocationForm" class="kt-portlet kt-portlet--bordered">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title" v-text="this.txt.titles.newDestinationLocation"></h3>
                                </div>
                                <div class="kt-align-right close-btn">
                                    <button
                                        @click="openCloseDestinationLocationForm"
                                        type="button"
                                        class="close"
                                        :title="this.txt.form.close"
                                    >
                                        <i class="la la-times"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="kt-portlet__body">
                                <div class="row">
                                    <!-- Destination Country -->
                                    <single-select-picker
                                        @updatedSelectPicker="
                                            movement.destinationLocation.countryId = $event;
                                            loadStateList($event, 'to');
                                        "
                                        name="destinationLocationCountryId"
                                        id="destinationLocationCountryId"
                                        divClass="form-group col-md-3"
                                        :label="this.txt.fields.country"
                                        :placeholder="this.txt.form.selectAnOption"
                                        :value="movement.destinationLocation.countryId"
                                        required
                                        :options="this.selectList.countryList"
                                        :disabled="isInProgress"
                                    >
                                    </single-select-picker>
                                    <!--  -->

                                    <!-- Destination State -->
                                    <single-select-picker
                                        @updatedSelectPicker="movement.destinationLocation.stateId = $event"
                                        name="destinationLocationStateId"
                                        id="destinationLocationStateId"
                                        divClass="form-group col-md-3"
                                        :label="this.txt.fields.state"
                                        :placeholder="this.txt.form.selectAnOption"
                                        :value="movement.destinationLocation.stateId"
                                        required
                                        :options="stateListTo"
                                        :disabled="isInProgress"
                                    >
                                    </single-select-picker>
                                    <!--  -->

                                    <!-- Notes -->
                                    <text-area
                                        @updatedTextArea="movement.destinationLocation.notes = $event"
                                        name="destinationLocationNotes"
                                        id="destinationLocationNotes"
                                        divClass="form-group col-md-12"
                                        :cols="30"
                                        :rows="8"
                                        :label="this.txt.fields.notes"
                                        :value="movement.destinationLocation.notes"
                                        required
                                    />
                                    <!--  -->
                                </div>
                            </div>
                        </div>
                        <!--  -->
                    </div>
                </div>
            </div>
        </div>
        <!--  -->

        <!-- Movement type -> Ordinary/Not ordinary -->
        <div v-if="this.movement.driverTypeId == this.constants.driverType.provider" class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--bordered">
                    <div class="kt-portlet__body">
                        <h3 class="mb-5" v-text="this.movementCategoryName"></h3>
                        <div class="kt-portlet kt-portlet--bordered">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title" v-text="this.movementCategoryName"></h3>
                                </div>
                            </div>

                            <div class="kt-portlet__body">
                                <div class="row">
                                    <!-- Provider selector -->
                                    <single-select-picker
                                        @updatedSelectPicker="movement.providerId = $event"
                                        name="provider"
                                        id="provider"
                                        divClass="form-group col-md-3"
                                        :label="this.txt.fields.provider"
                                        :placeholder="this.txt.form.selectAnOption"
                                        :value="movement.providerId"
                                        required
                                        :options="selectList.supplierList"
                                    >
                                    </single-select-picker>
                                    <!--  -->

                                    <!-- Business unit -->
                                    <single-select-picker
                                        @onChangeSelectPicker="onBusinessUnitSelected"
                                        @updatedSelectPicker="movement.businessUnitId = $event"
                                        name="businessUnit"
                                        id="businessUnit"
                                        divClass="form-group col-md-3"
                                        :label="this.txt.fields.businessUnit"
                                        :placeholder="this.txt.form.selectAnOption"
                                        :value="movement.businessUnitId"
                                        required
                                        :options="this.selectList.businessUnitList"
                                    >
                                    </single-select-picker>
                                    <!--  -->

                                    <!-- Business unit article -->
                                    <single-select-picker
                                        @updatedSelectPicker="movement.businessUnitArticleId = $event"
                                        name="businessUnitArticle"
                                        id="businessUnitArticle"
                                        divClass="form-group col-md-3"
                                        :label="this.txt.fields.businessUnitArticle"
                                        :placeholder="this.txt.form.selectAnOption"
                                        :value="movement.businessUnitArticleId"
                                        :disabled="disableBusinessUnitArticle || movement.businessUnitId == null"
                                        :required="!disableBusinessUnitArticle"
                                        :options="this.selectList.businessUnitArticleList"
                                    >
                                    </single-select-picker>
                                    <!--  -->

                                    <!-- Manual amount -->
                                    <input-number
                                        v-if="movement.categoryId == constants.category.notOrdinary"
                                        @updatedInputNumber="movement.manualAmount = $event"
                                        name="manualAmount"
                                        id="manualAmount"
                                        divClass="form-group col-md-3"
                                        :min="0"
                                        :step="0.01"
                                        :numOfDecimals="2"
                                        :label="this.txt.fields.movementAmount"
                                        :placeholder="this.txt.fields.movementAmount"
                                        required
                                        :value="movement.manualAmount"
                                    />
                                    <!--  -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->

        <!-- Driver data -->
        <div v-if="this.movement.driverTypeId !== null" class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--bordered">
                    <div class="kt-portlet__body">
                        <h3
                            class="mb-5"
                            v-text="
                                this.movement.driverTypeId == this.constants.driverType.employee
                                    ? this.movementCategoryName
                                    : this.txt.titles.driverData
                            "
                        ></h3>
                        <driver-data
                            @action="onDriverAction"
                            ref="driverData"
                            :internalDriver="!movement.externalTransport"
                            :providerId="movement.providerId || movement.destinationExternalLocation.providerId"
                            :branch="this.vehicle.branch"
                            :selectList="selectList"
                        ></driver-data>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->

        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--bordered">
                    <div class="kt-portlet__foot">
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
    </form>
</template>

<script>
export const CREATE_ACTION = "create";
export const EDIT_ACTION = "edit";

import Axios from "axios";
import Loading from "../../../../../assets/js/utilities";
import DriverData from "./DriverData";
import DatePicker from "../../../../../SharedAssets/vue/components/base/inputs/DatePicker";
import InputBase from "../../../../../SharedAssets/vue/components/base/inputs/InputBase";
import InputNumber from "../../../../../SharedAssets/vue/components/base/inputs/InputNumber";
import SingleSelectPicker from "../../../../../SharedAssets/vue/components/base/inputs/SingleSelectPicker";
import RadioButton from "../../../../../SharedAssets/vue/components/base/inputs/RadioButton";
import TextArea from "../../../../../SharedAssets/vue/components/base/inputs/TextArea";

export default {
    name: "MovementDriverForm",
    components: {
        DriverData,
        DatePicker,
        InputBase,
        InputNumber,
        SingleSelectPicker,
        RadioButton,
        TextArea,
    },
    props: {
        selectList: Object,
        movementTypeId: Number,
        movementData: Object,
        vehicle: Object,
        action: String,
    },
    watch: {
        vehicle() {
            if (this.movementData == null) this.initForm();
        },
    },
    data() {
        return {
            txt: {},
            constants: {},
            title: null,
            editable: true,
            submitButton: null,
            submitButtonClass: null,
            showOriginLocationForm: false,
            showDestinationLocationForm: false,
            showExternalLocationForm: false,
            disableBusinessUnitArticle: false,
            movementCategoryName: null,
            isInProgress: false,

            movement: {
                id: null,
                movementTypeId: null,
                statusId: null,
                categoryId: null,
                driverTypeId: null,
                externalTransport: null,
                originLocation: {
                    id: null,
                    name: null,
                    branchId: null,
                    countryId: null,
                    stateId: null,
                    notes: null,
                },
                destinationLocation: {
                    id: null,
                    name: null,
                    branchId: null,
                    countryId: null,
                    stateId: null,
                    notes: null,
                },
                destinationExternalLocation: {
                    providerId: null,
                    locationId: null,
                },
                expectedDepartureDate: new Intl.DateTimeFormat("en-GB").format(new Date(Date.now())),
                expectedArrivalDate: null,
                authDepartmentId: null,
                vehicleId: null,
                driverId: null,
                providerId: null,
                businessUnitId: null,
                businessUnitArticleId: null,
                manualAmount: null,
                notes: null,
            },

            driverTypeList: [],
            destinationLocationList: [],
            externalDestinationLocationList: [],
            stateListFrom: [],
            stateListTo: [],
        };
    },
    created() {
        this.txt = txtTrans;
        this.constants = constants;
    },
    mounted() {
        this.driverTypeList = [
            {
                id: this.constants.driverType.employee,
                label: this.txt.fields.internal,
            },
            {
                id: this.constants.driverType.provider,
                label: this.txt.fields.provider,
            },
        ];

        if (this.movementData != null) this.initForm();
    },
    methods: {
        showNotification(type = "", text = "") {
            this.$notify({
                text,
                type,
            });
        },
        loadExternalDestinationLocationList: async function(providerId = null) {
            this.externalDestinationLocationList = [];
            this.movement.destinationExternalLocation.locationId = null;

            if (providerId != null) {
                Loading.starLoading();
                let url = this.routing.generate("movement.get.externalLocations", {
                    providerId: providerId,
                });

                Axios.get(url)
                    .then((response) => {
                        Loading.endLoading();
                        this.externalDestinationLocationList = response.data;
                    })
                    .catch((error) => {
                        console.log(error.response);
                        Loading.endLoading();
                        if (error.response.status === 404) this.showNotification("error", this.txt.form.noExternalLocations);
                    });
            }
        },
        loadStateList: async function(countryId = null, target) {
            if (countryId != null) {
                Loading.starLoading();
                let url = this.routing.generate("state.select.list", {
                    countryId: countryId,
                });

                Axios.get(url)
                    .then((response) => {
                        Loading.endLoading();

                        if (response.status == 200) {
                            if (target === "from") {
                                this.stateListFrom = response.data;
                            }
                            if (target === "to") {
                                this.stateListTo = response.data;
                            }
                        } else {
                            this.showNotification("error", this.txt.form.msgErrorProcessData);
                        }
                    })
                    .catch((error) => {
                        console.log(error.response);
                        Loading.endLoading();
                    });
            }
        },
        initForm: function() {
            if (this.movementData != null || this.vehicle != null) {
                this.movement.vehicleId = this.vehicle.id;

                switch (this.action) {
                    case CREATE_ACTION:
                        this.title = this.txt.titles.createMovement;
                        this.submitButton = this.txt.form.create;
                        this.submitButtonClass = "la-plus";
                        this.movement.movementTypeId = this.constants.movementType.driver;
                        // this.movement.statusId = this.constants.movementStatus.progress;
                        this.movement.originLocation.id = this.vehicle.location.id;
                        this.movement.originLocation.name = this.vehicle.location.name;
                        this.editable = true;
                        break;
                    case EDIT_ACTION:
                        this.title = this.txt.titles.editMovement;
                        this.submitButton = this.txt.form.update;
                        this.submitButtonClass = "la-edit";
                        this.fillMovementData();
                        this.$nextTick(() => {
                            this.isInProgress = this.movement.statusId === this.constants.movementStatus.progress;
                        });
                        this.editable = false;
                        break;
                }

                this.filterLocationList(null, "destination");
            }
        },
        fillMovementData: function() {
            this.$nextTick(() => {
                let anotherLoaction = false;

                this.movement.id = this.movementData.id;
                this.movement.movementTypeId = this.movementData.movementTypeId;
                this.movement.statusId = this.movementData.movementStatus?.id;
                this.movement.categoryId = this.movementData.movementCategory?.id;
                this.setCategoryName();
                this.movement.driverTypeId = this.movementData.driverTypeId;
                this.movement.externalTransport = this.movementData.extTransport;

                // Origin location
                if (this.movementData.originLocation != null) {
                    this.movement.originLocation.id = this.movementData.originLocation.id;
                    this.movement.originLocation.name = this.movementData.originLocation.name;
                }
                if (this.movementData.originExternalLocation != null) {
                    this.movement.originLocation.id = this.movementData.originExternalLocation.id;
                    this.movement.originLocation.name = this.movementData.originExternalLocation.name;
                }

                // Manual origin location
                if (this.movementData.manualOriginLocation != null) {
                    this.openCloseOriginLocationForm();
                    this.movement.originLocation.countryId = this.movementData.manualOriginLocation.countryId;
                    this.movement.originLocation.stateId = this.movementData.manualOriginLocation.stateId;
                    this.movement.originLocation.notes = this.movementData.manualOriginLocation.notes;
                    this.loadStateList(this.movement.originLocation.countryId, "from");
                }

                // Manual oestination location
                if (this.movementData.manualDestinationLocation != null) {
                    anotherLoaction = true;
                    this.movement.destinationLocation.id = constants.locations.not_location.id;
                    this.openCloseDestinationLocationForm();
                    this.movement.destinationLocation.countryId = this.movementData.manualDestinationLocation.countryId;
                    this.movement.destinationLocation.stateId = this.movementData.manualDestinationLocation.stateId;
                    this.movement.destinationLocation.notes = this.movementData.manualDestinationLocation.notes;
                    this.loadStateList(this.movement.destinationLocation.countryId, "to");
                }

                // Destination external location
                if (
                    this.movementData.destinationExternalSupplier != null &&
                    this.movementData.destinationExternalLocation != null
                ) {
                    anotherLoaction = true;
                    this.movement.destinationLocation.id = constants.locations.location.id;
                    this.movement.destinationExternalLocation.providerId = this.movementData.destinationExternalSupplier.id;
                    this.loadExternalDestinationLocationList(this.movement.destinationExternalLocation.providerId);
                    this.movement.destinationExternalLocation.locationId = this.movementData.destinationExternalLocation.id;
                    this.showExternalLocationForm = true;
                }

                if (!anotherLoaction) {
                    // Destination location
                    if (this.movementData.destinationLocation != null) {
                        // Branch
                        this.movement.destinationLocation.branchId = this.movementData.destinationLocation.branchId;
                        this.filterLocationList(this.movement.destinationLocation.branchId, "destination");

                        this.movement.destinationLocation.id = this.movementData.destinationLocation.id;
                        this.movement.destinationLocation.name = this.movementData.destinationLocation.name;
                    }
                }

                this.movement.expectedDepartureDate = this.movementData.expectedLoadDate;
                this.movement.expectedArrivalDate = this.movementData.expectedUnloadDate;
                this.movement.authDepartmentId = this.movementData.departmentId;

                if (this.movementData.driver != null) {
                    this.movement.driverId = this.movementData.driver.id;
                    this.$nextTick(() => {
                        this.$refs.driverData.onDriverAction("select", this.movementData.driver);
                    });
                }

                // Movement Ordinary/Not Ordinary
                this.movement.providerId = this.movementData.providerId;
                this.movement.businessUnitId = this.movementData.businessUnit?.id;
                this.movement.businessUnitArticleId = this.movementData.businessUnitArticle?.id;
                this.movement.manualAmount = this.movementData.manualCost;

                this.movement.notes = this.movementData.notes;
            });
        },
        setCategory(from, e) {
            if (this.movement.driverId != null) {
                this.movement.driverId = null;
                this.$refs.driverData.reset();
            }

            switch (from) {
                case "driverType":
                    switch (e.target._value) {
                        case this.constants.driverType.employee:
                            this.flushOrdinaryNotMovementForm();
                            if (this.movement.destinationLocation.id == this.constants.locations.location.id) {
                                // Localización externa seleccionada? Flush
                                this.flushExternalLocationForm();
                                this.movement.destinationLocation.id = null;
                            }

                            this.movement.externalTransport = false;
                            this.movement.categoryId = this.constants.category.internal;
                            break;
                        case this.constants.driverType.provider:
                            this.movement.externalTransport = true;

                            if (this.movement.destinationLocation.id != null) {
                                if (this.sameBranchGroup(this.movement.destinationLocation.id)) {
                                    // Movimiento ordinario
                                    this.movement.categoryId = this.constants.category.ordinary;
                                } else {
                                    this.movement.categoryId = this.constants.category.notOrdinary;
                                    this.flushOrdinaryNotMovementForm();
                                }
                            } else {
                                this.movement.categoryId = this.constants.category.ordinary;
                            }
                            break;
                    }
                    break;

                case "originLocation":
                    // Si hay un tipo de conductor seleccionado:
                    if (this.movement.driverTypeId != null) {
                        // Interno
                        if (this.movement.driverTypeId == this.constants.driverType.employee) {
                            this.movement.externalTransport = false;
                            this.movement.categoryId = this.constants.category.internal;
                        }

                        // Proveedor
                        if (this.movement.driverTypeId == this.constants.driverType.provider) {
                            this.movement.externalTransport = true;

                            if (this.showOriginLocationForm) {
                                this.movement.categoryId = this.constants.category.notOrdinary;
                                this.flushOrdinaryNotMovementForm();

                                if (
                                    this.movement.destinationLocation.id != null &&
                                    this.sameBranchGroup(this.movement.destinationLocation.id)
                                ) {
                                    // Si son iguales, se elimina la selección, porque al crear originLocation
                                    // estamos forzando a que sea movimiento no ordinario
                                    this.movement.destinationLocation.id = null;
                                }
                            } else {
                                this.movement.categoryId = this.constants.category.ordinary;

                                if (
                                    this.movement.destinationLocation.id != null &&
                                    !this.sameBranchGroup(this.movement.destinationLocation.id)
                                ) {
                                    // Si no son iguales, se elimina la selección, porque al crear originLocation
                                    // estamos forzando a que sea movimiento ordinario
                                    if (this.movement.destinationLocation.id == this.constants.locations.not_location.id) {
                                        this.openCloseDestinationLocationForm();
                                    } else if (this.movement.destinationLocation.id == this.constants.locations.location.id) {
                                        this.showExternalLocationForm = false;
                                    }

                                    this.movement.destinationLocation.id = null;
                                }
                            }
                        }
                    } else {
                        this.movement.externalTransport = true;
                        this.movement.driverTypeId = this.constants.driverType.provider;

                        if (this.showOriginLocationForm) {
                            this.movement.categoryId = this.constants.category.notOrdinary;
                            this.flushOrdinaryNotMovementForm();

                            if (
                                this.movement.destinationLocation.id != null &&
                                this.sameBranchGroup(this.movement.destinationLocation.id)
                            ) {
                                // Si son iguales, se elimina la selección, porque al crear originLocation
                                // estamos forzando a que sea movimiento no ordinario
                                this.movement.destinationLocation.id = null;
                            }
                        } else {
                            this.movement.categoryId = this.constants.category.ordinary;

                            if (
                                this.movement.destinationLocation.id != null &&
                                !this.sameBranchGroup(this.movement.destinationLocation.id)
                            ) {
                                // Si no son iguales, se elimina la selección, porque al crear originLocation
                                // estamos forzando a que sea movimiento ordinario
                                if (this.movement.destinationLocation.id == this.constants.locations.not_location.id) {
                                    this.openCloseDestinationLocationForm();
                                } else if (this.movement.destinationLocation.id == this.constants.locations.location.id) {
                                    this.showExternalLocationForm = false;
                                }

                                this.movement.destinationLocation.id = null;
                            }
                        }
                    }
                    break;

                case "destinationLocation":
                    this.flushExternalLocationForm();
                    this.flushDestinationLocationForm();

                    // Si hay un tipo de conductor seleccionado:
                    if (this.movement.driverTypeId != null) {
                        // Interno
                        if (this.movement.driverTypeId == this.constants.driverType.employee) {
                            this.movement.externalTransport = false;
                            this.movement.categoryId = this.constants.category.internal;

                            if (e.target.selectedOptions[0]._value == this.constants.locations.not_location.id) {
                                this.openCloseDestinationLocationForm();
                            } else if (e.target.selectedOptions[0]._value == this.constants.locations.location.id) {
                                this.showExternalLocationForm = true;
                            }
                        }

                        // Proveedor
                        if (this.movement.driverTypeId == this.constants.driverType.provider) {
                            this.movement.externalTransport = true;

                            if (this.sameBranchGroup(e.target.selectedOptions[0]._value)) {
                                // Mismo grupo delegación? Movimiento ordinario
                                this.movement.categoryId = this.constants.category.ordinary;
                            } else if (e.target.selectedOptions[0]._value == this.constants.locations.not_location.id) {
                                // Nuvea localización destino? Movimiento no ordinario
                                this.movement.categoryId = this.constants.category.notOrdinary;
                                this.flushOrdinaryNotMovementForm();

                                this.openCloseDestinationLocationForm();
                            } else if (e.target.selectedOptions[0]._value == this.constants.locations.location.id) {
                                // Localización externa? Movimiento no ordinario
                                this.movement.categoryId = this.constants.category.notOrdinary;
                                this.flushOrdinaryNotMovementForm();
                                this.showExternalLocationForm = true;
                            } else {
                                this.movement.categoryId = this.constants.category.notOrdinary;
                                this.flushOrdinaryNotMovementForm();
                            }
                        }
                    } else {
                        // Si tipo conductor seleccionado no coincide con valor seleccionado
                        // ò
                        // Si no hay tipo conductor seleccionado, lo provocamos (siempre será provider)
                        this.movement.externalTransport = true;
                        this.movement.driverTypeId = this.constants.driverType.provider;

                        if (this.sameBranchGroup(e.target.selectedOptions[0]._value)) {
                            // Movimiento ordinario
                            this.movement.categoryId = this.constants.category.ordinary;
                        } else if (e.target.selectedOptions[0]._value == this.constants.locations.not_location.id) {
                            // Movimiento no ordinario
                            this.movement.categoryId = this.constants.category.notOrdinary;
                            this.flushOrdinaryNotMovementForm();

                            this.openCloseDestinationLocationForm();
                        } else if (e.target.selectedOptions[0]._value == this.constants.locations.location.id) {
                            // Movimiento no ordinario
                            this.movement.categoryId = this.constants.category.notOrdinary;
                            this.flushOrdinaryNotMovementForm();
                            this.showExternalLocationForm = true;
                        } else {
                            this.movement.categoryId = this.constants.category.notOrdinary;
                            this.flushOrdinaryNotMovementForm();
                        }
                    }

                    break;
            }

            this.setCategoryName();
        },
        setCategoryName() {
            switch (this.movement.categoryId) {
                case this.constants.category.internal:
                    this.movementCategoryName = this.txt.titles.internalMovement;
                    break;
                case this.constants.category.ordinary:
                    this.movementCategoryName = this.txt.titles.ordinaryMovement;
                    break;
                case this.constants.category.notOrdinary:
                    this.movementCategoryName = this.txt.titles.notOrdinaryMovement;
                    break;
            }
        },
        sameBranchGroup(value) {
            let branchGroupId = null;
            let branchGroupFrom =
                this.vehicle.branch?.branchGroupId ||
                this.selectList.locationList.filter((location) => location.id == this.vehicle.location.id)?.branchGroupId;

            this.selectList.locationList.forEach((current) => {
                if (current.id === value) branchGroupId = current?.branchGroupId;
            });

            return branchGroupFrom != null ? branchGroupFrom == branchGroupId : false;
        },
        openCloseOriginLocationForm() {
            this.showOriginLocationForm = !this.showOriginLocationForm;
            Object.keys(this.movement.originLocation).forEach((key) => {
                this.movement.originLocation[key] = null;
            });

            this.setCategory("originLocation");

            if (!this.showOriginLocationForm) {
                this.movement.originLocation.id = this.vehicle.location.id;
                this.movement.originLocation.name = this.vehicle.location.name;
            }

            this.filterLocationList(this.movement.destinationLocation.branchId, "destination");
        },
        openCloseDestinationLocationForm() {
            this.showDestinationLocationForm = !this.showDestinationLocationForm;

            if (!this.showDestinationLocationForm) {
                this.flushDestinationLocationForm(true);
            }
        },
        filterLocationList(branchId = null, target) {
            if (branchId !== null) {
                let filteredLocationList = this.selectList.locationList.filter((location) => location.branchId == branchId);
                let hasLocations = filteredLocationList.length > 0;

                if (hasLocations) {
                    this[`${target}LocationList`] = filteredLocationList;

                    if (this.movement[`${target}Location`].branchId != branchId) {
                        Object.keys(this.movement[`${target}Location`]).forEach((prop) => {
                            this.movement[`${target}Location`][prop] = null;
                        });
                    }
                } else {
                    this.$notify({
                        type: "error",
                        text: this.txt.form.noLocationsBranch,
                    });
                    this[`${target}LocationList`].length = filteredLocationList.length;
                }
            } else {
                this[`${target}LocationList`] = [];
            }

            if (!this.showOriginLocationForm) {
                if (this.movement.destinationLocation.id === this.vehicle.location.id)
                    this.movement[`${target}Location`].id = null;
                this[`${target}LocationList`] = this[`${target}LocationList`].filter(
                    (location) => location.id != this.vehicle.location.id && location.branchId != this.vehicle.branch.id
                );
            }
        },
        flushExternalLocationForm() {
            this.showExternalLocationForm = false;
            this.movement.destinationExternalLocation.providerId = null;
            this.movement.destinationExternalLocation.locationId = null;
            this.externalDestinationLocationList = [];
        },
        flushDestinationLocationForm(idIncluded = false) {
            this.showDestinationLocationForm = false;

            Object.keys(this.movement.destinationLocation).forEach((key) => {
                if (!idIncluded) {
                    if (!["id", "branchId"].includes(key)) {
                        this.movement.destinationLocation[key] = null;
                    }
                } else {
                    if (key !== "branchId") {
                        this.movement.destinationLocation[key] = null;
                    }
                }
            });
        },
        flushOrdinaryNotMovementForm() {
            this.movement.providerId = null;
            this.movement.businessUnitId = null;
            this.movement.businessUnitArticleId = null;
            this.movement.manualAmount = null;
        },
        onChangeExternalLocationProvider(value) {
            if (!["", null, undefined].includes(value)) {
                this.loadExternalDestinationLocationList(value);
            }
        },
        onBusinessUnitSelected(e) {
            this.disableBusinessUnitArticle = false;
            if (this.movement.categoryId == this.constants.category.notOrdinary) {
                if ([this.constants.businessUnit.vob2b, this.constants.businessUnit.vob2c].includes(e.target.value)) {
                    this.movement.businessUnitArticleId = null;
                    this.disableBusinessUnitArticle = true;
                }
            }
        },

        onDriverAction(response) {
            this.movement.driverId = response;
        },
        validateFormData() {
            if (!this.movement.driverId) {
                this.showNotification("warn", this.txt.form.noDriverSelectedOrFilled);
                return false;
            }
            return true;
        },
        submitMovement: async function() {
            if (!this.validateFormData()) {
                return;
            }

            window.swal
                .fire({
                    title: this.txt.form.createMovement,
                    text: this.txt.form.makeSureFillUpFields,
                    type: "warning",
                    confirmButtonText: this.txt.form.continue,
                    confirmButtonColor: "#5867dd",
                    showCancelButton: true,
                    cancelButtonText: this.txt.form.cancel,
                    cancelButtonColor: "#d33",
                })
                .then((result) => {
                    if (result.value) {
                        Loading.starLoading();

                        let formData = new FormData();
                        // FIXME refactorizar cuando se cambie el response de WS
                        // formData.set("movement", JSON.stringify(this.movement));
                        formData.set("movementTypeId", this.movement.movementTypeId);
                        formData.set("movementCategoryId", this.movement.categoryId);
                        formData.set("driverTypeId", this.movement.driverTypeId);
                        formData.set("extTransport", this.movement.externalTransport);
                        formData.set("vehicleId", this.movement.vehicleId);
                        formData.set("expectedLoadDate", this.movement.expectedDepartureDate);
                        formData.set("expectedUnloadDate", this.movement.expectedArrivalDate);
                        formData.set("departmentId", this.movement.authDepartmentId);
                        formData.set("providerId", this.movement.providerId);
                        formData.set("driverId", this.movement.driverId);
                        formData.set("businessUnitId", this.movement.businessUnitId);
                        formData.set("businessUnitArticleId", this.movement.businessUnitArticleId);
                        formData.set("manualCost", this.movement.manualAmount);
                        formData.set("notes", this.movement.notes);
                        formData.set("originLocationId", this.movement.originLocation.id);
                        formData.set("originLocationName", this.movement.originLocation.name);
                        formData.set("manualOriginLocationCountryId", this.movement.originLocation.countryId);
                        formData.set("manualOriginLocationProvinceId", this.movement.originLocation.stateId);
                        formData.set("manualOriginLocationNotes", this.movement.originLocation.notes);
                        formData.set("destinationLocationId", this.movement.destinationLocation.id);
                        formData.set("manualDestinationLocationCountryId", this.movement.destinationLocation.countryId);
                        formData.set("manualDestinationLocationProvinceId", this.movement.destinationLocation.stateId);
                        formData.set("manualDestinationLocationNotes", this.movement.destinationLocation.notes);
                        formData.set("destinationExternalProviderId", this.movement.destinationExternalLocation.providerId);
                        formData.set("destinationExternalLocationId", this.movement.destinationExternalLocation.locationId);

                        let url = this.movement.id
                            ? this.routing.generate("movement.update", { id: this.movement.id })
                            : this.routing.generate("movement.store");

                        Axios.post(url, formData)
                            .then((response) => {
                                // console.log("Create Movement: ", response);
                                Loading.endLoading();

                                if (response.status === 200) {
                                    let message = this.movement.id
                                        ? this.txt.form.movementUpdatedSuccessNotification
                                        : this.txt.form.movementCreatedSuccessNotification;
                                    this.showNotification("success", message);

                                    setTimeout(() => {
                                        window.location.href = this.routing.generate("movement.show", {
                                            id: response.data.id,
                                        });
                                    }, 2000);
                                } else {
                                    let errorMessage = this.movement.id
                                        ? this.txt.form.errorUpdatingMovementNotification
                                        : this.txt.form.errorCreatingMovementNotification;
                                    this.showNotification("error", errorMessage);
                                }
                            })
                            .catch((error) => {
                                console.log(error.response);
                                Loading.endLoading();

                                let errorMessage = this.movement.id
                                    ? this.txt.form.errorUpdatingMovementNotification
                                    : this.txt.form.errorCreatingMovementNotification;

                                if (error.response.status === 460) {
                                    errorMessage += error.response.data.message;
                                }

                                this.showNotification("error", errorMessage);
                            });
                    }
                });
        },
    },
};
</script>

<style scoped>
/* Form */
.form-group-btn {
    display: flex !important;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: space-between;
    align-items: center;
}

.btn-circle.add {
    background-color: #31cd54;
}

.btn-circle.add:hover {
    background-color: #28a745;
}

.btn-circle.add > i {
    color: white !important;
}

.btn-circle.close {
    background-color: #dc3545;
}

.btn-circle.close:hover {
    background-color: #a92835;
}

.btn-circle.close > i {
    color: white !important;
}

div.external-location {
    border-color: #31cd54;
    border-style: dashed;
}
/*  */

/* Footer */
.kt-portlet__foot {
    display: flex !important;
    flex-direction: row-reverse;
}

.kt-align-right.close-btn {
    display: flex;
    align-items: center;
}
/*  */
</style>
