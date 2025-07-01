<template>
    <form @submit.prevent="checkMovement" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--bordered">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title" v-text="this.title"></h3>
                        </div>
                    </div>

                    <div class="kt-portlet__body">
                        <div class="row">
                            <!-- Movement status -->
                            <single-select-picker
                                @updatedSelectPicker="movement.statusId = $event"
                                name="movementStatusId"
                                id="movementStatusId"
                                divClass="form-group col-md-3"
                                :label="txt.fields.status"
                                :placeholder="txt.form.selectAnOption"
                                disabled
                                :value="movement.statusId"
                                :options="selectList.movementStatusList"
                            />
                        </div>

                        <div class="row">
                            <!-- Origin branch -->
                            <single-select-picker
                                @updatedSelectPicker="
                                    movement.originBranchId = $event;
                                    loadLocationList($event, 'origin');
                                "
                                @onBlurSelectPicker="checkAutomaticCostNeedFields()"
                                name="originBranchId"
                                id="originBranchId"
                                divClass="form-group col-md-3"
                                :label="txt.fields.originBranch"
                                :placeholder="txt.form.selectAnOption"
                                :disabled="(isPending && (hasVehiclesLoaded || hasVehiclesUnloaded)) || isInProgress"
                                :value="movement.originBranchId"
                                :options="selectList.branchList"
                            />
                            <!--  -->

                            <!-- Origin location -->
                            <single-select-picker
                                @updatedSelectPicker="
                                    movement.originLocation.id = $event;
                                    onChangeLocation($event, 'origin');
                                "
                                @onBlurSelectPicker="checkAutomaticCostNeedFields()"
                                ref="originLocation"
                                name="originLocationId"
                                id="originLocationId"
                                divClass="form-group col-md-3"
                                :label="txt.fields.originLocation"
                                :placeholder="txt.form.selectAnOption"
                                :disabled="(isPending && (hasVehiclesLoaded || hasVehiclesUnloaded)) || isInProgress"
                                required
                                :value="movement.originLocation.id"
                                :options="originLocationList"
                            >
                                <option
                                    :value="constants.locations.location.id"
                                    v-text="constants.locations.location.name"
                                ></option>
                            </single-select-picker>
                            <!--  -->

                            <!-- Destination branch -->
                            <single-select-picker
                                @updatedSelectPicker="
                                    movement.destinationBranchId = $event;
                                    loadLocationList($event, 'destination');
                                "
                                @onBlurSelectPicker="checkAutomaticCostNeedFields()"
                                name="destinationBranchId"
                                id="destinationBranchId"
                                divClass="form-group col-md-3"
                                :label="txt.fields.destinationBranch"
                                :placeholder="txt.form.selectAnOption"
                                :disabled="(isPending && (hasVehiclesLoaded || hasVehiclesUnloaded)) || isInProgress"
                                :value="movement.destinationBranchId"
                                :options="selectList.branchList"
                            />
                            <!--  -->

                            <!-- Destination location -->
                            <single-select-picker
                                @updatedSelectPicker="
                                    movement.destinationLocation.id = $event;
                                    onChangeLocation($event, 'destination');
                                "
                                @onBlurSelectPicker="checkAutomaticCostNeedFields()"
                                ref="destinationLocation"
                                name="destinationLocationId"
                                id="destinationLocationId"
                                divClass="form-group col-md-3"
                                :label="txt.fields.destinationLocation"
                                :placeholder="txt.form.selectAnOption"
                                :disabled="(isPending && (hasVehiclesLoaded || hasVehiclesUnloaded)) || isInProgress"
                                required
                                :value="movement.destinationLocation.id"
                                :options="destinationLocationList"
                            >
                                <option
                                    :value="constants.locations.location.id"
                                    v-text="constants.locations.location.name"
                                ></option>
                            </single-select-picker>
                            <!--  -->
                        </div>

                        <!-- External location forms -->
                        <div
                            v-if="showExternalOriginLocationForm || showExternalDestinationLocationForm"
                            class="row external-location"
                        >
                            <!-- External origin provider -->
                            <single-select-picker
                                v-if="showExternalOriginLocationForm"
                                @updatedSelectPicker="
                                    movement.originExternalLocation.providerId = $event;
                                    loadExternalLocationList($event, 'origin');
                                "
                                @onBlurSelectPicker="checkAutomaticCostNeedFields()"
                                name="originExternalProvider"
                                id="originExternalProvider"
                                divClass="form-group col-md-3"
                                :label="txt.fields.originExternalProvider"
                                :placeholder="txt.form.selectAnOption"
                                :disabled="(isPending && (hasVehiclesLoaded || hasVehiclesUnloaded)) || isInProgress"
                                :required="showExternalOriginLocationForm"
                                :value="movement.originExternalLocation.providerId"
                                :options="selectList.supplierList"
                            />
                            <!--  -->

                            <!-- External origin location -->
                            <single-select-picker
                                v-if="showExternalOriginLocationForm"
                                @updatedSelectPicker="
                                    movement.originExternalLocation.location.id = $event;
                                    onChangeExternalLocation($event, 'origin');
                                "
                                @onBlurSelectPicker="checkAutomaticCostNeedFields()"
                                ref="originExternalLocation"
                                name="originExternalLocation"
                                id="originExternalLocation"
                                divClass="form-group col-md-3"
                                :label="txt.fields.originExternalLocation"
                                :placeholder="txt.form.selectAnOption"
                                :disabled="(isPending && (hasVehiclesLoaded || hasVehiclesUnloaded)) || isInProgress"
                                :required="showExternalOriginLocationForm"
                                :value="movement.originExternalLocation.location.id"
                                :options="originExternalLocationList"
                            />
                            <!--  -->

                            <!-- External destination provider -->
                            <single-select-picker
                                v-if="showExternalDestinationLocationForm"
                                @updatedSelectPicker="
                                    movement.destinationExternalLocation.providerId = $event;
                                    loadExternalLocationList($event, 'destination');
                                "
                                @onBlurSelectPicker="checkAutomaticCostNeedFields()"
                                name="destinationExternalProvider"
                                id="destinationExternalProvider"
                                divClass="form-group col-md-3"
                                :label="txt.fields.destinationExternalProvider"
                                :placeholder="txt.form.selectAnOption"
                                :disabled="(isPending && (hasVehiclesLoaded || hasVehiclesUnloaded)) || isInProgress"
                                :required="showExternalDestinationLocationForm"
                                :value="movement.destinationExternalLocation.providerId"
                                :options="selectList.supplierList"
                            />
                            <!--  -->

                            <!-- External destination location -->
                            <single-select-picker
                                v-if="showExternalDestinationLocationForm"
                                @updatedSelectPicker="
                                    movement.destinationExternalLocation.location.id = $event;
                                    onChangeExternalLocation($event, 'destination');
                                "
                                @onBlurSelectPicker="checkAutomaticCostNeedFields()"
                                ref="destinationExternalLocation"
                                name="destinationExternalLocation"
                                id="destinationExternalLocation"
                                divClass="form-group col-md-3"
                                :label="txt.fields.destinationExternalLocation"
                                :placeholder="txt.form.selectAnOption"
                                :disabled="(isPending && (hasVehiclesLoaded || hasVehiclesUnloaded)) || isInProgress"
                                :required="showExternalDestinationLocationForm"
                                :value="movement.destinationExternalLocation.location.id"
                                :options="destinationExternalLocationList"
                            />
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
                                :label="txt.fields.expectedDepartureDate"
                                :limit-start-day="today"
                                :limit-end-day="movement.expectedArrivalDate"
                                :value="movement.expectedDepartureDate"
                                :disabled="(isPending && (hasVehiclesLoaded || hasVehiclesUnloaded)) || isInProgress"
                                required
                            />
                            <!--  -->

                            <!-- Expected Arrival date -->
                            <date-picker
                                @updatedDatePicker="movement.expectedArrivalDate = $event"
                                name="expectedArrivalDate"
                                id="expectedArrivalDate"
                                divClass="form-group col-md-3"
                                :label="txt.fields.expectedArrivalDate"
                                :limit-start-day="movement.expectedDepartureDate"
                                :value="movement.expectedArrivalDate"
                                :disabled="(isPending && (hasVehiclesLoaded || hasVehiclesUnloaded)) || isInProgress"
                                required
                            />
                            <!--  -->

                            <!-- Business unit -->
                            <single-select-picker
                                @updatedSelectPicker="movement.businessUnitId = $event"
                                name="businessUnit"
                                id="businessUnit"
                                divClass="form-group col-md-3"
                                :label="txt.fields.businessUnit"
                                :placeholder="txt.form.selectAnOption"
                                :value="movement.businessUnitId"
                                required
                                :options="selectList.businessUnitList"
                            />
                            <!--  -->

                            <!-- Business unit article -->
                            <single-select-picker
                                @updatedSelectPicker="
                                    movement.businessUnitArticleId = $event;
                                    onChangeBusinessUnitArticle($event);
                                "
                                name="businessUnitArticle"
                                id="businessUnitArticle"
                                divClass="form-group col-md-3"
                                :label="txt.fields.businessUnitArticle"
                                :placeholder="txt.form.selectAnOption"
                                :value="movement.businessUnitArticleId"
                                :disabled="['', null, undefined].includes(movement.businessUnitId)"
                                required
                                :options="selectList.businessUnitArticleList"
                            />
                            <!--  -->
                        </div>

                        <div class="row">
                            <!-- Transport method -->
                            <single-select-picker
                                @updatedSelectPicker="
                                    movement.transportMethodId = $event;
                                    onChangeTransportMethod($event);
                                "
                                @onBlurSelectPicker="checkAutomaticCostNeedFields()"
                                name="transportMethod"
                                id="transportMethod"
                                divClass="form-group col-md-3"
                                :label="txt.fields.transportMethod"
                                :placeholder="txt.form.selectAnOption"
                                :value="movement.transportMethodId"
                                :disabled="(isPending && (hasVehiclesLoaded || hasVehiclesUnloaded)) || isInProgress"
                                required
                                :options="selectList.transportMethodList"
                            />

                            <!-- Vehicle units -->
                            <input-number
                                @updatedInputNumber="checkVehicleUnits($event)"
                                @onBlurInputNumber="checkAutomaticCostNeedFields()"
                                ref="vehicleUnits"
                                name="vehicleUnits"
                                id="vehicleUnits"
                                divClass="form-group col-md-3"
                                :min="movement.vehicleUnits ? 1 : undefined"
                                :max="vehicleUnitsLimit"
                                :step="1"
                                :label="txt.fields.units"
                                :value="movement.vehicleUnits"
                                input-group
                            >
                                <template #apend>
                                    <button
                                        @click="
                                            movement.vehicleUnits = null;
                                            checkAutomaticCostNeedFields();
                                        "
                                        type="button"
                                        class="btn btn-outline-secondary"
                                        :title="txt.form.deleteVehicleUnits"
                                        :disabled="['', null, undefined].includes(movement.vehicleUnits)"
                                    >
                                        <i class="fas fa-trash" style="padding: 0;"></i>
                                    </button>
                                </template>
                            </input-number>
                            <!--  -->

                            <!-- Manual amount -->
                            <input-number
                                @updatedInputNumber="movement.manualAmount = $event"
                                @onBlurInputNumber="checkAmounts()"
                                @onChangeInputNumber="checkAmounts()"
                                ref="manualAmount"
                                name="manualAmount"
                                id="manualAmount"
                                divClass="form-group col-md-3"
                                :min="0"
                                :step="0.01"
                                :numOfDecimals="2"
                                :label="txt.fields.amount"
                                :required="['', null, undefined].includes(this.movement.automaticAmount)"
                                :value="movement.manualAmount"
                            />
                            <!--  -->

                            <!-- Automatic amount -->
                            <input-number
                                @updatedInputNumber="movement.automaticAmount = $event"
                                name="automaticAmount"
                                id="automaticAmount"
                                divClass="form-group col-md-3"
                                :min="0"
                                :numOfDecimals="2"
                                :label="txt.fields.automaticAmount"
                                readonly
                                :required="['', null, undefined].includes(movement.manualAmount)"
                                :value="movement.automaticAmount"
                                input-group
                            >
                                <template #apend>
                                    <button
                                        @click="movement.automaticAmount = null"
                                        type="button"
                                        class="btn btn-outline-secondary"
                                        :title="txt.form.deleteAutomaticCost"
                                        :disabled="['', null, undefined].includes(movement.automaticAmount)"
                                    >
                                        <i class="fas fa-trash" style="padding: 0;"></i>
                                    </button>
                                    <button
                                        @click="getAutomaticCost()"
                                        type="button"
                                        class="btn btn-outline-secondary"
                                        :title="txt.form.generateAutomaticCost"
                                        :disabled="fieldsToFill.length > 0"
                                    >
                                        <i v-if="rotateIcon" class="fas fa-rotate-right fa-spin" style="padding: 0;"></i>
                                        <i v-else class="fas fa-rotate-right" style="padding: 0;"></i>
                                    </button>
                                </template>
                            </input-number>
                            <!--  -->
                        </div>

                        <div class="row">
                            <!-- Provider -->
                            <single-select-picker
                                @updatedSelectPicker="movement.providerId = $event"
                                @onBlurSelectPicker="checkAutomaticCostNeedFields()"
                                ref="provider"
                                name="provider"
                                id="provider"
                                divClass="form-group col-md-3"
                                :label="txt.fields.provider"
                                :placeholder="txt.form.selectAnOption"
                                :value="movement.providerId"
                                :disabled="(isPending && (hasVehiclesLoaded || hasVehiclesUnloaded)) || isInProgress"
                                :options="selectList.supplierList"
                            />
                            <!-- 
                            FIXME lógica no gestionada, motivo aquí: 
                            https://recordgo.atlassian.net/wiki/spaces/DIS/pages/733872130/Crear+Movimiento+Transportista?focusedCommentId=2970058759 
                            -->
                            <!--  -->
                            <!-- :required="
                            ([constants.businessUnit.rentACar, constants.businessUnit.carSharing].includes(
                                movement.businessUnitId
                            ) &&
                                movement.businessUnitArticleId == constants.businessUnitArticle.transport.buyback) ||
                                isInProgress ||
                                isPending
                            " -->

                            <!-- Notes -->
                            <text-area
                                @updatedTextArea="movement.notes = $event"
                                name="notes"
                                id="notes"
                                divClass="form-group col-md-12"
                                :cols="30"
                                :rows="8"
                                :label="txt.fields.notes"
                                :value="movement.notes"
                            />
                            <!--  -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <alert
            v-if="showACFieldsWarnings && fieldsToFill.length > 0"
            @flush="showACFieldsWarnings = !showACFieldsWarnings"
            type="warning"
        >
            <template #text>
                <p v-text="txt.form.automaticCostNeedFields"></p>
                <ul>
                    <li v-for="field in fieldsToFill" v-text="field"></li>
                </ul>
                <small>
                    *{{ txt.form.locationMustHaveBranch }}
                    <a :href="routing.generate('location.list')" target="_blank" v-text="txt.form.locationList"></a>
                </small>
            </template>
        </alert>

        <alert v-if="showAmountWarning" @flush="showAmountWarning = !showAmountWarning" type="warning">
            <template #text>
                <p v-text="txt.form.notSameAmounts" style="margin: 0"></p>
            </template>
        </alert>

        <alert v-if="cannotChangeBusinessUnitArticle" type="danger" :closable="false">
            <template #text>
                <p v-text="txt.form.errorCannotChangeBusinessUnitArticle" style="margin: 0"></p>
            </template>
        </alert>

        <movement-carrier-vehicle-filter
            ref="filters"
            :select-list="selectList"
            :filters="movement.vehicleFilters"
            :sale-method-id="movement.saleMethodId"
        />

        <div v-if="action === EDIT_ACTION && movement.id !== null" class="row">
            <div class="col-md-12">
                <movement-carrier-assigned-vehicles
                    ref="assignedVehicles"
                    :movement-id="movement.id"
                    :title="`${txt.titles.assignedVehicles} ${movement.id}`"
                />
            </div>
        </div>

        <movement-carrier-preview-modal v-if="checkData" @closed="checkData = !checkData" ref="preview" :movement="movement" />

        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--bordered">
                    <div class="kt-portlet__foot">
                        <div class="kt-align-right">
                            <button
                                v-if="action === EDIT_ACTION"
                                @click="goToManageVehicles"
                                type="button"
                                class="btn btn-primary"
                            >
                                <i class="la la-car"></i>
                                {{ txt.form.manageVehicles }}
                            </button>
                            <button
                                type="submit"
                                class="btn btn-dark kt-label-bg-color-4"
                                :disabled="cannotChangeBusinessUnitArticle"
                            >
                                <i class="la la-eye"></i>
                                {{ txt.form.preview }}
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

import Loading from "../../../../../assets/js/utilities";
import { capitalize } from "../../../../../SharedAssets/js/utils";
import Alert from "../../../../../SharedAssets/vue/components/Alert.vue";
import DatePicker from "../../../../../SharedAssets/vue/components/base/inputs/DatePicker.vue";
import InputNumber from "../../../../../SharedAssets/vue/components/base/inputs/InputNumber.vue";
import SingleSelectPicker from "../../../../../SharedAssets/vue/components/base/inputs/SingleSelectPicker.vue";
import TextArea from "../../../../../SharedAssets/vue/components/base/inputs/TextArea.vue";

import MovementCarrierAssignedVehicles from "./MovementCarrierAssignedVehicles.vue";
import MovementCarrierVehicleFilter from "./MovementCarrierVehicleFilter.vue";
import MovementCarrierPreviewModal from "./MovementCarrierPreviewModal.vue";

export default {
    name: "MovementCarrierForm",
    components: {
        Alert,
        DatePicker,
        InputNumber,
        SingleSelectPicker,
        TextArea,
        MovementCarrierAssignedVehicles,
        MovementCarrierVehicleFilter,
        MovementCarrierPreviewModal,
    },
    props: {
        selectList: Object,
        movementTypeId: Number,
        movementData: Object,
        action: String,
    },
    data() {
        return {
            CREATE_ACTION,
            EDIT_ACTION,
            txt: {},
            constants: {},
            title: null,
            submitButton: null,
            submitButtonClass: null,
            showExternalOriginLocationForm: false,
            showExternalDestinationLocationForm: false,
            today: new Intl.DateTimeFormat("en-GB").format(new Date(Date.now())),
            movement: {
                id: null,
                movementTypeId: null,
                statusId: null,
                // locationTypeId: null,
                originBranchId: null,
                originLocation: {
                    id: null,
                    name: null,
                    branchId: null,
                },
                destinationBranchId: null,
                destinationLocation: {
                    id: null,
                    name: null,
                    branchId: null,
                },
                originExternalLocation: {
                    providerId: null,
                    location: {
                        id: null,
                        branchId: null,
                    },
                },
                destinationExternalLocation: {
                    providerId: null,
                    location: {
                        id: null,
                        branchId: null,
                    },
                },
                expectedDepartureDate: new Intl.DateTimeFormat("en-GB").format(new Date(Date.now())),
                expectedArrivalDate: null,
                businessUnitId: null,
                businessUnitArticleId: null,
                saleMethodId: null,
                providerId: null,
                transportMethodId: null,
                vehicleUnits: null,
                manualAmount: null,
                automaticAmount: null,
                notes: null,
                vehicleFilters: {},
                vehicleLines: [],
            },

            originLocationList: [],
            destinationLocationList: [],
            originExternalLocationList: [],
            destinationExternalLocationList: [],

            isPending: false,
            isInProgress: false,
            hasVehiclesLoaded: false,
            hasVehiclesUnloaded: false,
            cannotChangeBusinessUnitArticle: false,
            vehicleUnitsLimit: undefined,
            showACFieldsWarnings: false,
            fieldsToFill: [],
            showAmountWarning: false,
            sameAmounts: false,
            rotateIcon: false,
            checkData: false,
        };
    },
    created() {
        this.txt = txtTrans;
        this.constants = constants;
    },
    mounted() {
        this.initForm();
    },
    methods: {
        goToManageVehicles() {
            window.location.href = this.routing.generate("movement.vehicleLine.assigned.list", {
                id: this.movement.id,
            });
        },
        loadLocationList: async function(branchId = null, target) {
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
        },
        loadExternalLocationList: async function(providerId = null, target) {
            if (providerId != null) {
                Loading.starLoading();
                this[`${target}ExternalLocationList`] = [];
                this.movement[`${target}ExternalLocation`].location.id = null;
                this.movement[`${target}ExternalLocation`].location.branchId = null;

                let url = this.routing.generate("movement.get.externalLocations", {
                    providerId: providerId,
                });

                this.axios
                    .get(url)
                    .then((response) => {
                        Loading.endLoading();
                        this[`${target}ExternalLocationList`] = response.data;
                    })
                    .catch((error) => {
                        console.log(error.response);
                        Loading.endLoading();
                        if (error.response.status === 404) {
                            this.$notify({
                                type: "error",
                                text: this.txt.form.noExternalLocations,
                            });
                        }
                    });
            }
        },
        initForm: function() {
            // this.movement.locationTypeId = this.constants.locationType.campaOA;
            // this.loadLocationList(this.movement.locationTypeId);

            switch (this.action) {
                case CREATE_ACTION:
                    this.title = this.txt.titles.createMovement;
                    this.submitButton = this.txt.form.create;
                    this.submitButtonClass = "la-plus";
                    // this.movement.movementTypeId = this.movementTypeId;
                    this.movement.movementTypeId = this.constants.movementType.carrier;
                    this.movement.statusId = this.constants.movementStatus.pending;
                    break;
                case EDIT_ACTION:
                    this.title = this.txt.titles.editMovement;
                    this.submitButton = this.txt.form.update;
                    this.submitButtonClass = "la-edit";
                    this.fillMovementData();
                    this.isPending = this.movement.statusId === this.constants.movementStatus.pending;
                    this.isInProgress = this.movement.statusId === this.constants.movementStatus.progress;
                    this.hasVehiclesLoaded = this.movement.vehicleLines?.some(
                        (vehicle) => !["", null, undefined].includes(vehicle.actualLoadDate)
                    );
                    this.hasVehiclesUnloaded = this.movement.vehicleLines?.some(
                        (vehicle) => !["", null, undefined].includes(vehicle.actualUnloadDate)
                    );
                    break;
            }
        },
        fillMovementData: function() {
            this.movement.id = this.movementData.id;
            this.movement.movementTypeId = this.movementData.movementTypeId;
            this.movement.statusId = this.movementData.movementStatus?.id;
            // this.movement.locationTypeId = this.movementData.locationType?.id;

            // Origin location
            if (this.movementData.originLocation != null) {
                this.movement.originBranchId = this.movementData.originLocation.branchId;
                this.loadLocationList(this.movement.originBranchId, "origin");

                this.movement.originLocation.id = this.movementData.originLocation.id;
                this.movement.originLocation.name = this.movementData.originLocation.name;
                this.movement.originLocation.branchId = this.movementData.originLocation.branchId;
            }

            // Destination location
            if (this.movementData.destinationLocation != null) {
                this.movement.destinationBranchId = this.movementData.destinationLocation.branchId;
                this.loadLocationList(this.movement.destinationBranchId, "destination");

                this.movement.destinationLocation.id = this.movementData.destinationLocation.id;
                this.movement.destinationLocation.name = this.movementData.destinationLocation.name;
                this.movement.destinationLocation.branchId = this.movementData.destinationLocation.branchId;
            }

            // Origin external location
            if (this.movementData.originExternalSupplier != null && this.movementData.originExternalLocation != null) {
                this.movement.originLocation.id = constants.locations.location.id;
                this.movement.originExternalLocation.providerId = this.movementData.originExternalSupplier.id;
                this.loadExternalLocationList(this.movement.originExternalLocation.providerId, "origin");
                this.movement.originExternalLocation.location.id = this.movementData.originExternalLocation.id;
                this.movement.originExternalLocation.location.branchId = this.movementData.originExternalLocation.branchId;
                this.showExternalOriginLocationForm = true;
            }

            // Destination external location
            if (this.movementData.destinationExternalSupplier != null && this.movementData.destinationExternalLocation != null) {
                this.movement.destinationLocation.id = constants.locations.location.id;
                this.movement.destinationExternalLocation.providerId = this.movementData.destinationExternalSupplier.id;
                this.loadExternalLocationList(this.movement.destinationExternalLocation.providerId, "destination");
                this.movement.destinationExternalLocation.location.id = this.movementData.destinationExternalLocation.id;
                this.movement.destinationExternalLocation.location.branchId = this.movementData.destinationExternalLocation.branchId;
                this.showExternalDestinationLocationForm = true;
            }

            this.movement.expectedDepartureDate = this.movementData.expectedLoadDate;
            this.movement.expectedArrivalDate = this.movementData.expectedUnloadDate;

            this.movement.businessUnitId = this.movementData.businessUnit?.id;
            this.movement.businessUnitArticleId = this.movementData.businessUnitArticle?.id;
            this.movement.saleMethodId = getSaleMethodOfBusinessUnitArticle(this.movement.businessUnitArticleId);
            this.movement.providerId = this.movementData.providerId;
            this.movement.transportMethodId = this.movementData.transportMethodId;
            this.movement.vehicleUnits = this.movementData.vehicleUnits;

            this.movement.manualAmount = this.movementData.manualCost;
            this.movement.automaticAmount = this.movementData.automaticCost;

            this.movement.notes = this.movementData.notes;

            this.movement.vehicleLines = this.movementData.vehicleList;

            // Filters
            if (this.movementData.vehicleFilters) {
                this.movement.vehicleFilters.vehicleTypeIdIn = this.movementData.vehicleFilters?.vehicleType;
                this.movement.vehicleFilters.brandIdIn = this.movementData.vehicleFilters?.brand;
                this.movement.vehicleFilters.modelIdIn = this.movementData.vehicleFilters?.model;
                this.movement.vehicleFilters.carGroupIdIn = this.movementData.vehicleFilters?.carGroup;
                this.movement.vehicleFilters.kilometersFrom = this.movementData.vehicleFilters?.kilometersFrom;
                this.movement.vehicleFilters.kilometersTo = this.movementData.vehicleFilters?.kilometersTo;
                this.movement.vehicleFilters.rentingEndDateFrom = this.movementData.vehicleFilters?.rentingEndDateFrom;
                this.movement.vehicleFilters.rentingEndDateTo = this.movementData.vehicleFilters?.rentingEndDateTo;
                this.movement.vehicleFilters.checkInDateFrom = this.movementData.vehicleFilters?.checkInDateFrom;
                this.movement.vehicleFilters.saleMethodIdIn = this.movementData.vehicleFilters?.saleMethod;
                this.movement.vehicleFilters.vehicleStatusIdIn = this.movementData.vehicleFilters?.vehicleStatus;
                this.movement.vehicleFilters.connectedVehicle = this.movementData.vehicleFilters?.connectedVehicle;
            }
        },
        onChangeLocation: function(value, target) {
            if (value == this.constants.locations.location.id) {
                this[`showExternal${capitalize(target)}LocationForm`] = true;
                this.movement[`${target}Location`].branchId = null;
            } else {
                this.movement[`${target}Location`].branchId = this.selectList.locationList.find(
                    (item) => item.id == value
                )?.branchId;
                this[`showExternal${capitalize(target)}LocationForm`] = false;
                this.movement[`${target}ExternalLocation`].providerId = null;
                this.movement[`${target}ExternalLocation`].location.id = null;
                this.movement[`${target}ExternalLocation`].location.branchId = null;
            }
        },
        onChangeExternalLocation: function(value, target) {
            this.movement[`${target}ExternalLocation`].location.branchId = this[`${target}ExternalLocationList`].find(
                (item) => item.id == value
            )?.branchId;
        },
        onChangeBusinessUnitArticle(businessUnitArticleId) {
            this.movement.saleMethodId = getSaleMethodOfBusinessUnitArticle(businessUnitArticleId);
            this.cannotChangeBusinessUnitArticle =
                this.action === EDIT_ACTION &&
                this.movement.vehicleLines.filter(
                    (line) =>
                        this.movement.saleMethodId &&
                        line.actualLoadDate !== null &&
                        line.saleMethodId !== this.movement.saleMethodId
                ).length > 0;
        },
        onChangeTransportMethod: function(value) {
            if (value == this.constants.transportMethod.road) {
                this.vehicleUnitsLimit = 10;
                if (this.movement.vehicleUnits > 10) {
                    this.movement.vehicleUnits = null;
                    this.$refs.vehicleUnits.$refs.input.focus();
                }
            } else {
                this.vehicleUnitsLimit = undefined;
            }
        },
        checkVehicleUnits: function(value) {
            this.movement.vehicleUnits = value < 1 ? 1 : value;
        },
        checkAmounts: function() {
            if (this.movement.manualAmount == null || this.movement.automaticAmount == null) {
                this.showAmountWarning = false;
            } else {
                this.sameAmounts = this.movement.manualAmount == this.movement.automaticAmount;
                this.showAmountWarning = !this.sameAmounts;
            }
        },
        checkAutomaticCostNeedFields: function() {
            this.fieldsToFill = [];

            if (
                ["", null, undefined].includes(this.movement.originLocation.branchId) &&
                ["", null, undefined].includes(this.movement.originExternalLocation.location.branchId)
            ) {
                this.fieldsToFill.push(`${this.txt.fields.originLocation} / ${this.txt.fields.originExternalLocation}*`);
            }
            if (
                ["", null, undefined].includes(this.movement.destinationLocation.branchId) &&
                ["", null, undefined].includes(this.movement.destinationExternalLocation.location.branchId)
            ) {
                this.fieldsToFill.push(
                    `${this.txt.fields.destinationLocation} / ${this.txt.fields.destinationExternalLocation}*`
                );
            }
            if (["", null, undefined].includes(this.movement.providerId)) this.fieldsToFill.push(this.txt.fields.provider);
            if (["", null, undefined].includes(this.movement.transportMethodId))
                this.fieldsToFill.push(this.txt.fields.transportMethod);
            if (["", null, undefined].includes(this.movement.vehicleUnits)) this.fieldsToFill.push(this.txt.fields.units);

            this.showACFieldsWarnings = this.fieldsToFill.length > 0;

            if (this.fieldsToFill.length == 0) this.getAutomaticCost();
        },
        getAutomaticCost: function() {
            Loading.starLoading();
            this.rotateIcon = true;

            this.axios
                .get(
                    this.routing.generate("movement.automatic.cost", {
                        originBranchId:
                            this.movement.originLocation.branchId || this.movement.originExternalLocation.location.branchId,
                        destinationBranchId:
                            this.movement.destinationLocation.branchId ||
                            this.movement.destinationExternalLocation.location.branchId,
                        providerId: this.movement.providerId,
                        transportMethodId: this.movement.transportMethodId,
                        vehicleUnits: this.movement.vehicleUnits,
                    })
                )
                .then((response) => {
                    Loading.endLoading();
                    this.rotateIcon = false;

                    this.movement.automaticAmount = typeof response.data === "number" ? response.data : null;

                    if (this.movement.manualAmount !== null && this.movement.automaticAmount !== null) {
                        this.checkAmounts();
                    }

                    if (this.movement.automaticAmount < 0) {
                        this.checkAutomaticCostNeedFields();
                    } else if (this.movement.automaticAmount == null) {
                        window.swal
                            .fire({
                                title: this.txt.form.automaticCostCreateRouteQuestion,
                                text: "",
                                type: "warning",
                                confirmButtonText: this.txt.form.yes,
                                confirmButtonColor: "#48465b",
                                showCancelButton: true,
                                cancelButtonText: this.txt.form.no,
                                cancelButtonColor: "#d33",
                            })
                            .then((result) => {
                                if (result.value) {
                                    const createRoutePage = window.open(this.routing.generate("routes.create.excel"), "_blank");

                                    // Verificar periódicamente si la ventana secundaria se ha cerrado
                                    const interval = window.setInterval(() => {
                                        if (createRoutePage.closed) {
                                            window.clearInterval(interval);

                                            window.swal
                                                .fire({
                                                    title: this.txt.form.automaticCostFinishCreateRouteQuestion,
                                                    text: "",
                                                    type: "question",
                                                    confirmButtonText: this.txt.form.yes,
                                                    confirmButtonColor: "#48465b",
                                                    showCancelButton: true,
                                                    cancelButtonText: this.txt.form.no,
                                                    cancelButtonColor: "#d33",
                                                })
                                                .then((result) => {
                                                    if (result.value) {
                                                        this.getAutomaticCost();
                                                    } else {
                                                        /**
                                                         * INFO: es necesario establecer un timeout porque el foco al campo no se aplica correctamente
                                                         *  ebido a la animación de cierre de SweetAlert.
                                                         */
                                                        setTimeout(() => {
                                                            this.$refs.manualAmount.$refs.input.focus();
                                                        }, 300);
                                                    }
                                                });
                                        }
                                    }, 1000);
                                } else {
                                    /**
                                     * INFO: es necesario establecer un timeout porque el foco al campo no se aplica correctamente
                                     *  ebido a la animación de cierre de SweetAlert.
                                     */
                                    setTimeout(() => {
                                        this.$refs.manualAmount.$refs.input.focus();
                                    }, 300);
                                }
                            });
                    }
                })
                .catch((error) => {
                    console.log(error.response);
                    Loading.endLoading();
                    this.rotateIcon = false;
                });
        },
        checkMovement: function() {
            this.movement.vehicleFilters = this.$refs.filters.vehicleFilters;
            this.checkData = true;
            this.$nextTick(() => {
                $("#previewModal").modal("show");
            });
        },
        submitMovement: async function() {
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
                        formData.set("movementStatusId", this.movement.statusId);
                        formData.set("locationTypeId", this.movement.locationTypeId );
                        formData.set("originLocationId", this.movement.originLocation.id);
                        formData.set("originExternalProviderId", this.movement.originExternalLocation.providerId);
                        formData.set("originExternalLocationId", this.movement.originExternalLocation.location.id);
                        formData.set("destinationLocationId", this.movement.destinationLocation.id);
                        formData.set("destinationExternalProviderId", this.movement.destinationExternalLocation.providerId);
                        formData.set("destinationExternalLocationId", this.movement.destinationExternalLocation.location.id);
                        formData.set("expectedLoadDate", this.movement.expectedDepartureDate);
                        formData.set("expectedUnloadDate", this.movement.expectedArrivalDate);
                        formData.set("businessUnitId", this.movement.businessUnitId);
                        formData.set("businessUnitArticleId", this.movement.businessUnitArticleId);
                        formData.set("saleMethodId", this.movement.saleMethodId);
                        formData.set("transportMethodId", this.movement.transportMethodId);
                        formData.set("vehicleUnits", this.movement.vehicleUnits);
                        formData.set("manualCost", this.movement.manualAmount);
                        formData.set("automaticCost", this.movement.automaticAmount);
                        formData.set("providerId", this.movement.providerId);
                        formData.set("notes", this.movement.notes);

                        // Filters
                        if (Object.values(this.movement.vehicleFilters).some((value) => value !== null)) {
                            this.movement.vehicleFilters.vehicleTypeIdIn.forEach((item) => {
                                formData.append("vehicleTypeIdIn[]", item.id);
                            });
                            this.movement.vehicleFilters.brandIdIn.forEach((item) => {
                                formData.append("brandIdIn[]", item.id);
                            });
                            this.movement.vehicleFilters.modelIdIn.forEach((item) => {
                                formData.append("modelIdIn[]", item.id);
                            });
                            this.movement.vehicleFilters.carGroupIdIn.forEach((item) => {
                                formData.append("carGroupIdIn[]", item.id);
                            });
                            formData.set("kilometersFrom", this.movement.vehicleFilters.kilometersFrom.value);
                            formData.set("kilometersTo", this.movement.vehicleFilters.kilometersTo.value);
                            formData.set("rentingEndDateFrom", this.movement.vehicleFilters.rentingEndDateFrom.value);
                            formData.set("rentingEndDateTo", this.movement.vehicleFilters.rentingEndDateTo.value);
                            formData.set("checkInDateFrom", this.movement.vehicleFilters.checkInDateFrom.value);
                            this.movement.vehicleFilters.saleMethodIdIn.forEach((item) => {
                                formData.append("saleMethodIdIn[]", item.id);
                            });
                            this.movement.vehicleFilters.vehicleStatusIdIn.forEach((item) => {
                                formData.append("vehicleStatusIdIn[]", item.id);
                            });
                            let connectedVehicleValue = this.movement.vehicleFilters.connectedVehicle.value;
                            if (connectedVehicleValue !== null && connectedVehicleValue !== undefined) {
                                if (parseInt(connectedVehicleValue) === 1) {
                                    connectedVehicleValue = true;
                                } else if (parseInt(connectedVehicleValue) === 2) {
                                    connectedVehicleValue = false;
                                }
                            }
                            formData.set("connectedVehicle", connectedVehicleValue);
                        }

                        let url = this.movement.id
                            ? this.routing.generate("movement.update", { id: this.movement.id })
                            : this.routing.generate("movement.store");

                        this.axios
                            .post(url, formData)
                            .then((response) => {
                                // console.log("Create Movement: ", response);
                                Loading.endLoading();

                                if (response.status === 200) {
                                    let message = this.movement.id
                                        ? this.txt.form.movementUpdatedSuccessNotification
                                        : this.txt.form.movementCreatedSuccessNotification;
                                    this.$notify({
                                        type: "success",
                                        text: message,
                                    });

                                    setTimeout(() => {
                                        window.location.href = this.routing.generate("movement.show", {
                                            id: response.data.id,
                                        });
                                    }, 2000);
                                } else {
                                    let errorMessage = this.movement.id
                                        ? this.txt.form.errorUpdatingMovementNotification
                                        : this.txt.form.errorCreatingMovementNotification;
                                    this.$notify({
                                        type: "error",
                                        text: errorMessage,
                                    });
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

                                this.$notify({
                                    type: "error",
                                    text: errorMessage,
                                });
                            });
                    }
                });
        },
    },
};
</script>

<style scoped>
/* Form */
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
