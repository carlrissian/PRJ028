<template>
    <fragment>
        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--bordered">
                    <div class="kt-portlet__body">
                        <div class="kt-portlet kt-portlet--bordered">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title" v-text="txt.titles.movementOperationDetails"></h3>
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
                                        <h6 v-text="txt.fields.expectedDepartureDate"></h6>
                                        <p v-text="formatDate(movement.expectedLoadDate)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.expectedArrivalDate"></h6>
                                        <p v-text="formatDate(movement.expectedUnloadDate)"></p>
                                    </div>
                                </div>

                                <div class="group row">
                                    <!-- <div class="col-2">
                                        <h6 v-text="txt.fields.locationType"></h6>
                                        <p v-text="Formatter.formatField(movement.locationType)"></p>
                                    </div> -->
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.originBranch"></h6>
                                        <p v-text="Formatter.formatField(movement.originBranch)"></p>
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
                                        <h6 v-text="txt.fields.destinationBranch"></h6>
                                        <p v-text="Formatter.formatField(movement.destinationBranch)"></p>
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
                                        <h6 v-text="txt.fields.provider"></h6>
                                        <p v-text="Formatter.formatField(movement.provider)"></p>
                                    </div>
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
                                        <h6 v-text="txt.fields.vehicleUnits"></h6>
                                        <p v-text="Formatter.formatField(movement.vehicleUnits)"></p>
                                    </div>
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

                        <!-- Status: finished -->
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
                                        <p v-text="formatDate(movement.closingDate)"></p>
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
                                        <p v-text="formatDate(movement.cancellationDate)"></p>
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
                        <!-- Assigned vehicles -->
                        <movement-operation-assigned-vehicles
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
import MovementOperationAssignedVehicles from "../../components/operation/MovementOperationAssignedVehicles.vue";

export default {
    components: {
        MovementOperationAssignedVehicles,
    },
    name: "OperationMovementDetails",
    props: {
        movement: Object,
        movementTypeId: Number,
    },
    data() {
        return {
            Formatter,
            txt: {},
            constants,
        };
    },
    created() {
        this.txt = txtTrans;
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
        formatDate(date) {
            return !["", null, undefined].includes(date) ? moment(date, "DD/MM/YYYY").format("DD/MM/YYYY") : "-";
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
