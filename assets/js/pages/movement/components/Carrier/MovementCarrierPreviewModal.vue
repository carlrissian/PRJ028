<template>
    <erp-modal @onCloseModal="$emit('closed')" id="previewModal" :title="txt.titles.previewMovement">
        <template #body>
            <h5 class="mb-4" v-text="txt.titles.movementData"></h5>
            <div class="group row">
                <div class="col-2">
                    <h6 v-text="txt.fields.status"></h6>
                    <p
                        v-text="
                            Formatter.formatField(
                                $parent.selectList.movementStatusList.find((item) => item.id == movement.statusId)
                            )
                        "
                    ></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.originBranch"></h6>
                    <p
                        v-text="
                            Formatter.formatField(
                                $parent.selectList.branchList.find((item) => item.id == movement.originBranchId)
                            )
                        "
                    ></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.originLocation"></h6>
                    <p
                        v-if="
                            !['', null, undefined, $parent.constants.locations.location.name].includes(movement.originLocation.id)
                        "
                        v-text="
                            Formatter.formatField(
                                $parent.selectList.locationList.find((item) => item.id == movement.originLocation.id)
                            )
                        "
                    ></p>
                    <p
                        v-else
                        v-text="
                            Formatter.formatField(
                                $parent.originExternalLocationList.find(
                                    (item) => item.id == movement.originExternalLocation.location.id
                                )
                            )
                        "
                    ></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.destinationBranch"></h6>
                    <p
                        v-text="
                            Formatter.formatField(
                                $parent.selectList.branchList.find((item) => item.id == movement.destinationBranchId)
                            )
                        "
                    ></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.destinationLocation"></h6>
                    <p
                        v-if="
                            !['', null, undefined, $parent.constants.locations.location.name].includes(
                                movement.destinationLocation.id
                            )
                        "
                        v-text="
                            Formatter.formatField(
                                $parent.selectList.locationList.find((item) => item.id == movement.destinationLocation.id)
                            )
                        "
                    ></p>
                    <p
                        v-else
                        v-text="
                            Formatter.formatField(
                                $parent.destinationExternalLocationList.find(
                                    (item) => item.id == movement.destinationExternalLocation.location.id
                                )
                            )
                        "
                    ></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.expectedDepartureDate"></h6>
                    <p v-text="formatDate(movement.expectedDepartureDate)"></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.expectedArrivalDate"></h6>
                    <p v-text="formatDate(movement.expectedArrivalDate)"></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.businessUnit"></h6>
                    <p
                        v-text="
                            Formatter.formatField(
                                $parent.selectList.businessUnitList.find((item) => item.id == movement.businessUnitId)
                            )
                        "
                    ></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.businessUnitArticle"></h6>
                    <p
                        v-text="
                            Formatter.formatField(
                                $parent.selectList.businessUnitArticleList.find(
                                    (item) => item.id == movement.businessUnitArticleId
                                )
                            )
                        "
                    ></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.transportMethod"></h6>
                    <p
                        v-text="
                            Formatter.formatField(
                                $parent.selectList.transportMethodList.find((item) => item.id == movement.transportMethodId)
                            )
                        "
                    ></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.units"></h6>
                    <p v-text="Formatter.formatField(movement.vehicleUnits)"></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.amount"></h6>
                    <p v-text="Formatter.formatField(movement.manualAmount)"></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.automaticAmount"></h6>
                    <p v-text="Formatter.formatField(movement.automaticAmount)"></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.provider"></h6>
                    <p
                        v-text="
                            Formatter.formatField($parent.selectList.supplierList.find((item) => item.id == movement.providerId))
                        "
                    ></p>
                </div>
                <div class="col-12">
                    <h6 v-text="txt.fields.notes"></h6>
                    <p v-html="Formatter.formatField(movement.notes).replace(/\n/g, '<br>')"></p>
                </div>
            </div>

            <h5 v-if="movement.vehicleFilters !== null" class="mt-4 mb-4" v-text="txt.titles.filters"></h5>
            <div v-if="movement.vehicleFilters !== null" class="group row">
                <div class="col-3">
                    <h6 v-text="txt.fields.vehicleType"></h6>
                    <p v-text="Formatter.formatArray(movement.vehicleFilters.vehicleTypeIdIn)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.brand"></h6>
                    <p v-text="Formatter.formatArray(movement.vehicleFilters.brandIdIn)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.model"></h6>
                    <p v-text="Formatter.formatArray(movement.vehicleFilters.modelIdIn)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.carGroup"></h6>
                    <p v-text="Formatter.formatArray(movement.vehicleFilters.carGroupIdIn)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.kilometersFrom"></h6>
                    <p v-text="Formatter.formatField(movement.vehicleFilters.kilometersFrom.value)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.kilometersTo"></h6>
                    <p v-text="Formatter.formatField(movement.vehicleFilters.kilometersTo.value)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.rentingEndDateFrom"></h6>
                    <p v-text="formatDate(movement.vehicleFilters.rentingEndDateFrom.value)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.rentingEndDateTo"></h6>
                    <p v-text="formatDate(movement.vehicleFilters.rentingEndDateTo.value)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.checkInDueDateFrom"></h6>
                    <p v-text="formatDate(movement.vehicleFilters.checkInDateFrom.value)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.saleMethod"></h6>
                    <p v-text="Formatter.formatArray(movement.vehicleFilters.saleMethodIdIn)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.vehicleStatus"></h6>
                    <p v-text="Formatter.formatArray(movement.vehicleFilters.vehicleStatusIdIn)"></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.connectedVehicle"></h6>
                    <p v-text="Formatter.formatBoolean(movement.vehicleFilters.connectedVehicle.value)"></p>
                </div>
            </div>
        </template>

        <template #footer>
            <div class="kt-align-right">
                <button @click="confirm" type="button" class="btn btn-dark kt-label-bg-color-4">
                    <i :class="`la ${$parent.submitButtonClass}`"></i>
                    {{ $parent.submitButton }}
                </button>
            </div>
        </template>
    </erp-modal>
</template>

<script>
import Formatter from "../../../../../SharedAssets/js/formatter";

import ErpModal from "../../../../../SharedAssets/vue/components/modal/ErpModal";

export default {
    name: "MovementCarrierPreviewModal",
    components: {
        ErpModal,
    },
    props: {
        movement: Object,
    },
    data() {
        return {
            Formatter,
            txt: {},
        };
    },
    created() {
        this.txt = txtTrans;
    },
    methods: {
        formatDate(date) {
            return !["", null, undefined].includes(date) ? moment(date, "DD/MM/YYYY").format("DD/MM/YYYY") : "-";
        },
        confirm() {
            $("#previewModal").modal("hide");
            this.$parent.submitMovement();
        },
    },
};
</script>

<style></style>
