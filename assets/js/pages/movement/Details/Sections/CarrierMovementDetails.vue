<template>
    <fragment>
        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--bordered">
                    <div class="kt-portlet__body">
                        <div class="kt-portlet kt-portlet--bordered">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title" v-text="txt.titles.movementCarrierDetails"></h3>
                                </div>
                            </div>

                            <div class="kt-portlet__body">
                                <div class="group row">
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.movementId"></h6>
                                        <p v-text="Formatter.formatField(movement.id)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.orderNumber"></h6>
                                        <p v-text="Formatter.formatField(movement.orderNumber)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.status"></h6>
                                        <p v-text="Formatter.formatField(movement.status)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.originLocation"></h6>
                                        <p
                                            v-if="movement.originLocation"
                                            v-text="Formatter.formatField(movement.originLocation)"
                                        ></p>
                                        <p
                                            v-if="movement.externalOriginLocation"
                                            v-text="Formatter.formatField(movement.externalOriginLocation)"
                                        ></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.destinationLocation"></h6>
                                        <p
                                            v-if="movement.destinationLocation"
                                            v-text="Formatter.formatField(movement.destinationLocation)"
                                        ></p>
                                        <p
                                            v-if="movement.externalDestinationLocation"
                                            v-text="Formatter.formatField(movement.externalDestinationLocation)"
                                        ></p>
                                    </div>
                                </div>

                                <div class="group row">
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.expectedDepartureDate"></h6>
                                        <p v-text="Formatter.formatDate(movement.expectedLoadDate)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.actualDepartureDate"></h6>
                                        <p v-text="Formatter.formatDate(movement.actualLoadDate)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.expectedArrivalDate"></h6>
                                        <p v-text="Formatter.formatDate(movement.expectedUnloadDate)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.actualArrivalDate"></h6>
                                        <p v-text="Formatter.formatDate(movement.actualUnloadDate)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.provider"></h6>
                                        <p v-text="Formatter.formatField(movement.provider)"></p>
                                    </div>
                                </div>

                                <div class="group row">
                                    <div class="col-2">
                                        <h6 v-text="`${txt.fields.businessUnit} - ${txt.fields.businessUnitArticle}`"></h6>
                                        <p
                                            v-text="
                                                `${Formatter.formatField(movement.businessUnit)} - ${Formatter.formatField(
                                                    movement.businessUnitArticle
                                                )}`
                                            "
                                        ></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.transportMethod"></h6>
                                        <p v-text="Formatter.formatField(movement.transportMethod)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.vehicleUnits"></h6>
                                        <p v-text="Formatter.formatField(movement.vehicleUnits)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.amount"></h6>
                                        <p v-text="Formatter.formatField(movement.manualCost)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.automaticAmount"></h6>
                                        <p v-text="Formatter.formatField(movement.automaticCost)"></p>
                                    </div>
                                </div>

                                <div class="group row">
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.creationUser"></h6>
                                        <p v-text="Formatter.formatField(movement.creationUser)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.creationDate"></h6>
                                        <p v-text="Formatter.formatField(movement.creationDate)"></p>
                                    </div>
                                    <div class="col-12">
                                        <h6 v-text="txt.fields.notes"></h6>
                                        <p v-html="Formatter.formatField(movement.notes).replace(/\n/g, '<br>')"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status: Finalized -->
                        <div
                            v-if="movement.status.id === constants.movementStatus.finalized"
                            class="kt-portlet kt-portlet--bordered"
                        >
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title" v-text="txt.titles.movementClosureData"></h3>
                                </div>
                            </div>

                            <div class="kt-portlet__body">
                                <div class="group row">
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.closingDate"></h6>
                                        <p v-text="Formatter.formatDate(movement.closingDate)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.closingUser"></h6>
                                        <p v-text="Formatter.formatField(movement.closingUser)"></p>
                                    </div>
                                    <div class="col-12">
                                        <h6 v-text="txt.fields.closingNotes"></h6>
                                        <p v-html="Formatter.formatField(movement.closingNotes).replace(/\n/g, '<br>')"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  -->

                        <!-- Status: Cancelled -->
                        <div
                            v-if="movement.status.id === constants.movementStatus.cancelled"
                            class="kt-portlet kt-portlet--bordered"
                        >
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title" v-text="txt.titles.movementCancelationData"></h3>
                                </div>
                            </div>

                            <div class="kt-portlet__body">
                                <div class="group row">
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.cancelationDate"></h6>
                                        <p v-text="Formatter.formatDate(movement.cancellationDate)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.cancelationUser"></h6>
                                        <p v-text="Formatter.formatField(movement.cancellationUser)"></p>
                                    </div>
                                    <div class="col-12">
                                        <h6 v-text="txt.fields.cancelationNotes"></h6>
                                        <p v-html="Formatter.formatField(movement.cancellationNotes).replace(/\n/g, '<br>')"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--bordered">
                    <div class="kt-portlet__body">
                        <!-- Vehicle filters -->
                        <div class="kt-portlet kt-portlet--bordered">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title" v-text="txt.titles.filters"></h3>
                                </div>
                            </div>

                            <div class="kt-portlet__body">
                                <div class="group row">
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.vehicleType"></h6>
                                        <p v-text="Formatter.formatField(movement.filters.vehicleType)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.brand"></h6>
                                        <p v-text="Formatter.formatField(movement.filters.brand)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.model"></h6>
                                        <p v-text="Formatter.formatField(movement.filters.model)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.carGroup"></h6>
                                        <p v-text="Formatter.formatField(movement.filters.carGroup)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.kmFrom"></h6>
                                        <p v-text="Formatter.formatField(movement.filters.kilometersFrom)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.kmTo"></h6>
                                        <p v-text="Formatter.formatField(movement.filters.kilometersTo)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.rentingEndDateFrom"></h6>
                                        <p v-text="Formatter.formatDate(movement.filters.rentingEndDateFrom)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.rentingEndDateTo"></h6>
                                        <p v-text="Formatter.formatDate(movement.filters.rentingEndDateTo)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.checkInDueDate"></h6>
                                        <p v-text="Formatter.formatDate(movement.filters.checkInDateFrom)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.saleMethod"></h6>
                                        <p v-text="Formatter.formatField(movement.filters.saleMethod)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.vehicleStatus"></h6>
                                        <p v-text="Formatter.formatField(movement.filters.vehicleStatus)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.connectedVehicle"></h6>
                                        <p
                                            v-text="
                                                movement.filters.connectedVehicle != null
                                                    ? movement.filters.connectedVehicle
                                                        ? txt.form.yes
                                                        : txt.form.no
                                                    : '-'
                                            "
                                        ></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  -->

                        <!-- Assigned vehicles -->
                        <movement-carrier-assigned-vehicles
                            ref="assignedVehicles"
                            :movement-id="movement.id"
                            :assigned-license-plate-units="movement.assignedLicensePlateUnits"
                            :title="txt.titles.assignedVehicles"
                        />
                        <!--  -->
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--bordered">
                    <div class="kt-portlet__foot">
                        <div class="kt-align-right">
                            <button
                                v-if="
                                    ![constants.movementStatus.finalized, constants.movementStatus.cancelled].includes(
                                        movement.status.id
                                    )
                                "
                                @click="goToManageVehicles"
                                type="button"
                                class="btn btn-primary"
                            >
                                <i class="la la-car"></i>
                                {{ txt.form.manageVehicles }}
                            </button>
                            <button @click="exportCSV(movement.id)" type="button" class="btn btn-primary">
                                <i class="la la-file"></i>
                                {{ txt.form.downloadExcel }}
                            </button>
                            <button
                                v-if="
                                    [constants.movementStatus.pending, constants.movementStatus.progress].includes(
                                        movement.status.id
                                    )
                                "
                                @click="goEdit"
                                type="button"
                                class="btn btn-primary"
                            >
                                <i class="la la-edit"></i>
                                {{ txt.form.edit }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fragment>
</template>

<script>
import Formatter from "../../../../../SharedAssets/js/formatter";
import MovementCarrierAssignedVehicles from "../../components/Carrier/MovementCarrierAssignedVehicles.vue";

export default {
    components: {
        MovementCarrierAssignedVehicles,
    },
    name: "CarrierMovementDetails",
    props: {
        movement: Object,
        movementTypeId: Number,
    },
    data() {
        return {
            Formatter,
            txt: {},
            constants: {},
        };
    },
    created() {
        this.txt = txtTrans;
        this.constants = constants;
    },
    methods: {
        goEdit() {
            window.location.href = this.routing.generate("movement.edit", { id: this.movement.id });
        },
        goToManageVehicles() {
            window.location.href = this.routing.generate("movement.vehicleLine.assigned.list", {
                id: this.movement.id,
            });
        },
        exportCSV(id) {
            location.href = this.routing.generate("movement.details.excel", {
                movementId: id,
                movementTypeId: this.movementTypeId,
            });
        },
    },
};
</script>

<style scoped>
table thead {
    text-align: center;
}
table tbody tr {
    text-align: center;
}
</style>
