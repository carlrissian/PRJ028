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
                            >
                            </single-select-picker>
                            <!--  -->
                        </div>

                        <div class="row">
                            <!-- Origin branch -->
                            <single-select-picker
                                @updatedSelectPicker="
                                    movement.originLocation.branchId = $event;
                                    loadLocationList($event, 'origin');
                                "
                                name="originBranchId"
                                id="originBranchId"
                                divClass="form-group col-md-3"
                                :label="txt.fields.originBranch"
                                :placeholder="txt.form.selectAnOption"
                                :disabled="(isPending && (hasVehiclesLoaded || hasVehiclesUnloaded)) || isInProgress"
                                :value="movement.originLocation.branchId"
                                :options="selectList.branchList"
                            />
                            <!--  -->

                            <!-- Origin location -->
                            <single-select-picker
                                @updatedSelectPicker="
                                    movement.originLocation.id = $event;
                                    onChangeLocation($event, 'origin');
                                "
                                ref="originLocation"
                                name="originLocationId"
                                id="originLocationId"
                                :label="txt.fields.originLocation"
                                :placeholder="txt.form.selectAnOption"
                                divClass="form-group col-md-3"
                                :disabled="(isPending && (hasVehiclesLoaded || hasVehiclesUnloaded)) || isInProgress"
                                required
                                :value="movement.originLocation.id"
                            >
                                <option
                                    v-for="item in originLocationList"
                                    :key="item.id"
                                    :value="item.id"
                                    v-text="`${item.branchIATA} / ${item.name}`"
                                ></option>
                            </single-select-picker>
                            <!--  -->

                            <!-- Destination branch -->
                            <single-select-picker
                                @updatedSelectPicker="
                                    movement.destinationLocation.branchId = $event;
                                    loadLocationList($event, 'destination');
                                "
                                name="destinationBranchId"
                                id="destinationBranchId"
                                divClass="form-group col-md-3"
                                :label="txt.fields.destinationBranch"
                                :placeholder="txt.form.selectAnOption"
                                :disabled="(isPending && (hasVehiclesLoaded || hasVehiclesUnloaded)) || isInProgress"
                                :value="movement.destinationLocation.branchId"
                                :options="selectList.branchList"
                            />
                            <!--  -->

                            <!-- Destination location -->
                            <single-select-picker
                                @updatedSelectPicker="
                                    movement.destinationLocation.id = $event;
                                    onChangeLocation($event, 'destination');
                                "
                                ref="destinationLocation"
                                name="destinationLocationId"
                                id="destinationLocationId"
                                :label="txt.fields.destinationLocation"
                                :placeholder="txt.form.selectAnOption"
                                divClass="form-group col-md-3"
                                :disabled="(isPending && (hasVehiclesLoaded || hasVehiclesUnloaded)) || isInProgress"
                                required
                                :value="movement.destinationLocation.id"
                            >
                                <option
                                    v-for="item in destinationLocationList"
                                    :key="item.id"
                                    :value="item.id"
                                    v-text="`${item.branchIATA} / ${item.name}`"
                                ></option>
                            </single-select-picker>
                            <!--  -->
                        </div>

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
                                @updatedSelectPicker="(movement.businessUnitId = $event), onChangeBusinessUnit($event)"
                                name="businessUnit"
                                id="businessUnit"
                                divClass="form-group col-md-3"
                                :label="txt.fields.businessUnit"
                                :placeholder="txt.form.selectAnOption"
                                :value="movement.businessUnitId"
                                required
                                :options="selectList.businessUnitList"
                            >
                            </single-select-picker>
                            <!--  -->

                            <!-- Business unit article -->
                            <single-select-picker
                                @updatedSelectPicker="movement.businessUnitArticleId = $event"
                                name="businessUnitArticle"
                                id="businessUnitArticle"
                                divClass="form-group col-md-3"
                                :label="txt.fields.businessUnitArticle"
                                :placeholder="txt.form.selectAnOption"
                                :value="movement.businessUnitArticleId"
                                disabled
                                required
                                :options="selectList.businessUnitArticleList"
                            >
                            </single-select-picker>
                            <!--  -->
                        </div>

                        <div class="row">
                            <!-- Vehicle units -->
                            <input-number
                                @updatedInputNumber="movement.vehicleUnits = $event"
                                ref="vehicleUnits"
                                name="vehicleUnits"
                                id="vehicleUnits"
                                divClass="form-group col-md-3"
                                :min="1"
                                :label="txt.fields.units"
                                :value="movement.vehicleUnits"
                            />
                            <!--  -->

                            <!-- Provider -->
                            <!-- <single-select-picker
                                @updatedSelectPicker="movement.providerId = $event"
                                ref="provider"
                                name="provider"
                                id="provider"
                                divClass="form-group col-md-3"
                                :label="txt.fields.provider"
                                :placeholder="txt.form.selectAnOption"
                                :value="movement.providerId"
                                :disabled="(isPending && (hasVehiclesLoaded || hasVehiclesUnloaded)) || isInProgress"
                                :options="selectList.supplierList"
                            /> -->
                            <!--  -->
                        </div>

                        <div class="row">
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

        <div v-if="action === EDIT_ACTION && movement.id !== null" class="row">
            <div class="col-md-12">
                <movement-operation-assigned-vehicles
                    ref="assignedVehicles"
                    :movement-id="movement.id"
                    :title="`${txt.titles.assignedVehicles} ${movement.id}`"
                />
            </div>
        </div>

        <movement-operation-preview-modal v-if="checkData" @closed="checkData = !checkData" ref="preview" :movement="movement" />

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
                            <button type="submit" class="btn btn-dark kt-label-bg-color-4">
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
import DatePicker from "../../../../../SharedAssets/vue/components/base/inputs/DatePicker.vue";
import InputNumber from "../../../../../SharedAssets/vue/components/base/inputs/InputNumber.vue";
import MultipleSelectPicker from "../../../../../SharedAssets/vue/components/base/inputs/MultipleSelectPicker.vue";
import SingleSelectPicker from "../../../../../SharedAssets/vue/components/base/inputs/SingleSelectPicker.vue";
import TextArea from "../../../../../SharedAssets/vue/components/base/inputs/TextArea.vue";

import MovementOperationAssignedVehicles from "./MovementOperationAssignedVehicles.vue";
import MovementOperationPreviewModal from "./MovementOperationPreviewModal.vue";
export default {
    name: "MovementOperationForm",
    components: {
        DatePicker,
        InputNumber,
        MultipleSelectPicker,
        SingleSelectPicker,
        TextArea,
        MovementOperationAssignedVehicles,
        MovementOperationPreviewModal,
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
            constants,
            txt: {},
            title: null,
            submitButton: null,
            submitButtonClass: null,
            today: new Intl.DateTimeFormat("en-GB").format(new Date(Date.now())),
            movement: {
                id: null,
                movementTypeId: null,
                statusId: null,
                locationTypeId: [],
                originLocation: {
                    id: null,
                    name: null,
                    locationTypeId: null,
                    branchId: null,
                },
                destinationLocation: {
                    id: null,
                    name: null,
                    locationTypeId: null,
                    branchId: null,
                },
                expectedDepartureDate: new Intl.DateTimeFormat("en-GB").format(new Date(Date.now())),
                expectedArrivalDate: null,
                businessUnitId: null,
                businessUnitArticleId: null,
                providerId: null,
                vehicleUnits: null,
                notes: null,
                vehicleFilters: {},
                vehicleLines: [],
            },

            originLocationList: [],
            destinationLocationList: [],

            isPending: false,
            isInProgress: false,
            hasVehiclesLoaded: false,
            hasVehiclesUnloaded: false,
            checkData: false,
        };
    },
    created() {
        this.txt = txtTrans;
    },
    mounted() {
        this.$nextTick(() => {
            this.initForm();
        });
    },
    methods: {
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
        goToManageVehicles() {
            window.location.href = this.routing.generate("movement.vehicleLine.assigned.list", {
                id: this.movement.id,
            });
        },
        initForm: function() {
            switch (this.action) {
                case CREATE_ACTION:
                    this.title = this.txt.titles.createMovement;
                    this.submitButton = this.txt.form.create;
                    this.submitButtonClass = "la-plus";
                    this.movement.movementTypeId = constants.movementType.operation;
                    this.movement.statusId = constants.movementStatus.pending;
                    this.movement.businessUnitArticleId = constants.businessUnitArticle.operation.transport;
                    break;
                case EDIT_ACTION:
                    this.title = this.txt.titles.editMovement;
                    this.submitButton = this.txt.form.update;
                    this.submitButtonClass = "la-edit";
                    this.fillMovementData();
                    this.isPending = this.movement.statusId === constants.movementStatus.pending;
                    this.isInProgress = this.movement.statusId === constants.movementStatus.progress;
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

            // Location type
            this.movement.locationTypeId.push(this.movementData.locationType?.id);

            // Origin location
            if (this.movementData.originLocation != null) {
                this.movement.originLocation.branchId = this.movementData.originLocation.branchId;
                this.loadLocationList(this.movement.originLocation.branchId, "origin");
                this.movement.originLocation.id = this.movementData.originLocation.id;
                this.movement.originLocation.name = this.movementData.originLocation.name;
            }

            // Destination location
            if (this.movementData.destinationLocation != null) {
                this.movement.destinationLocation.branchId = this.movementData.destinationLocation.branchId;
                this.loadLocationList(this.movement.destinationLocation.branchId, "destination");
                this.movement.destinationLocation.id = this.movementData.destinationLocation.id;
                this.movement.destinationLocation.name = this.movementData.destinationLocation.name;
            }

            this.movement.expectedDepartureDate = this.movementData.expectedLoadDate;
            this.movement.expectedArrivalDate = this.movementData.expectedUnloadDate;

            this.movement.businessUnitId = this.movementData.businessUnit?.id;
            this.movement.businessUnitArticleId = this.movementData.businessUnitArticle?.id;
            this.movement.providerId = this.movementData.providerId;
            this.movement.vehicleUnits = this.movementData.vehicleUnits;

            this.movement.notes = this.movementData.notes;

            this.movement.vehicleLines = this.movementData.vehicleList;

            // Filters
            if (this.movementData.vehicleFilters) {
                this.movement.vehicleFilters.vehicleTypeIdIn = this.movementData.vehicleFilters?.vehicleType.map(
                    (item) => item.id
                );
                this.movement.vehicleFilters.saleMethodIdIn = this.movementData.vehicleFilters?.saleMethod.map((item) => item.id);
            }
        },
        onChangeLocation: function(value, target) {
            let location = this.selectList.locationList.find((item) => item.id == value);
            this.movement[`${target}Location`].id = location?.id;
            // this.movement[`${target}Location`].branchId = location?.branchId;
        },
        onChangeBusinessUnit(businessUnitId) {
            this.movement.vehicleFilters.vehicleTypeIdIn = [];
            this.movement.vehicleFilters.saleMethodIdIn = [];

            if ([constants.businessUnit.car, constants.businessUnit.van, constants.businessUnit.moto].includes(businessUnitId)) {
                this.movement.vehicleFilters.vehicleTypeIdIn.push(getFilterOfBusinessUnit(businessUnitId));
            }
            if ([constants.businessUnit.vob2c, constants.businessUnit.vob2b].includes(businessUnitId)) {
                this.movement.vehicleFilters.saleMethodIdIn.push(getFilterOfBusinessUnit(businessUnitId));
            }
        },
        checkMovement: function() {
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
                        // formData.set("locationTypeId", this.movement.locationTypeId);
                        formData.set("originLocationId", this.movement.originLocation.id);
                        formData.set("destinationLocationId", this.movement.destinationLocation.id);
                        formData.set("expectedLoadDate", this.movement.expectedDepartureDate);
                        formData.set("expectedUnloadDate", this.movement.expectedArrivalDate);
                        formData.set("businessUnitId", this.movement.businessUnitId);
                        formData.set("businessUnitArticleId", this.movement.businessUnitArticleId);
                        formData.set("vehicleUnits", this.movement.vehicleUnits);
                        formData.set("providerId", this.movement.providerId);
                        formData.set("notes", this.movement.notes);

                        // Filters
                        if (Object.values(this.movement.vehicleFilters).some((value) => value !== null)) {
                            this.movement.vehicleFilters.vehicleTypeIdIn.forEach((item) => {
                                formData.append("vehicleTypeIdIn[]", item);
                            });
                            this.movement.vehicleFilters.saleMethodIdIn.forEach((item) => {
                                formData.append("saleMethodIdIn[]", item);
                            });
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
