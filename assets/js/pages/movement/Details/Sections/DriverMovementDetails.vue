<template>
    <fragment>
        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--bordered">
                    <div class="kt-portlet__body">
                        <!-- Movement general data -->
                        <div class="kt-portlet kt-portlet--bordered">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title" v-text="txt.titles.movementDriverDetails"></h3>
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
                                        <h6 v-text="txt.fields.category"></h6>
                                        <p v-text="Formatter.formatField(movement.category)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.status"></h6>
                                        <p v-text="Formatter.formatField(movement.status)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.driverType"></h6>
                                        <p v-text="movement.externalTransport ? txt.fields.external : txt.fields.internal"></p>
                                    </div>
                                </div>

                                <div class="group row">
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
                                        <p
                                            v-if="movement.manualOriginLocation"
                                            v-text="
                                                `${Formatter.formatField(
                                                    movement.manualOriginLocation.state
                                                )} | ${Formatter.formatField(movement.manualOriginLocation.country)}`
                                            "
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
                                        <p
                                            v-if="movement.manualDestinationLocation"
                                            v-text="
                                                `${Formatter.formatField(
                                                    movement.manualDestinationLocation.state
                                                )} | ${Formatter.formatField(movement.manualDestinationLocation.country)}`
                                            "
                                        ></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.locationType"></h6>
                                        <p v-text="Formatter.formatField(movement.locationType)"></p>
                                    </div>
                                </div>

                                <div class="group row">
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
                                        <h6 v-text="txt.fields.authDepartment"></h6>
                                        <p v-text="Formatter.formatField(movement.department)"></p>
                                    </div>
                                </div>

                                <!-- Ordinario, no ordinario -->
                                <div
                                    v-if="
                                        [constants.category.ordinary, constants.category.notOrdinary].includes(
                                            movement.category.id
                                        )
                                    "
                                    class="group row"
                                >
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.businessUnit"></h6>
                                        <p v-text="Formatter.formatField(movement.businessUnit)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.businessUnitArticle"></h6>
                                        <p v-text="Formatter.formatField(movement.businessUnitArticle)"></p>
                                    </div>

                                    <div class="col-2">
                                        <h6 v-text="txt.fields.providerType"></h6>
                                        <p v-text="Formatter.formatField(movement.providerType)"></p>
                                    </div>

                                    <div class="col-2">
                                        <h6 v-text="txt.fields.provider"></h6>
                                        <p v-text="Formatter.formatField(movement.provider)"></p>
                                    </div>

                                    <div class="col-2" v-if="movement.category.id == constants.category.notOrdinary">
                                        <h6 v-text="txt.fields.movementAmount"></h6>
                                        <p v-text="Formatter.formatField(movement.manualCost)"></p>
                                    </div>
                                </div>
                                <!--  -->

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
                        <!--  -->

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
                                        <h6 v-text="txt.fields.actualKms"></h6>
                                        <p v-text="Formatter.formatField(movement.actualKms)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.tankActualOctaves"></h6>
                                        <p v-text="Formatter.formatField(movement.tankActualOctaves)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.batteryActual"></h6>
                                        <p v-text="Formatter.formatField(movement.batteryActual)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.amount"></h6>
                                        <p v-text="Formatter.formatField(movement.manualCost)"></p>
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
                                        <p
                                            v-if="movement.manualDestinationLocation"
                                            v-text="
                                                `${Formatter.formatField(
                                                    movement.manualDestinationLocation.state
                                                )} | ${Formatter.formatField(movement.manualDestinationLocation.country)}`
                                            "
                                        ></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.actualArrivalDate"></h6>
                                        <p v-text="Formatter.formatDateTime(movement.actualUnloadDate)"></p>
                                    </div>
                                    <div class="col-2">
                                        <h6 v-text="txt.fields.closingDate"></h6>
                                        <p v-text="Formatter.formatDateTime(movement.closingDate)"></p>
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
                                        <p v-text="Formatter.formatDateTime(movement.cancellationDate)"></p>
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

        <!-- Driver data -->
        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--bordered">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title" v-text="txt.titles.driverData"></h3>
                        </div>
                    </div>

                    <div class="kt-portlet__body">
                        <div class="group row">
                            <div class="col-2">
                                <h6 v-text="txt.fields.driverName"></h6>
                                <p v-text="Formatter.formatField(movement.driver.name)"></p>
                            </div>
                            <div class="col-2">
                                <h6 v-text="txt.fields.driverLastName"></h6>
                                <p v-text="Formatter.formatField(movement.driver.lastName)"></p>
                            </div>
                            <div class="col-2">
                                <h6 v-text="txt.fields.driverIdNumber"></h6>
                                <p v-text="Formatter.formatField(movement.driver.idNumber)"></p>
                            </div>
                            <div class="col-2">
                                <h6 v-text="txt.fields.driverLicense"></h6>
                                <p v-text="Formatter.formatField(movement.driver.driverLicense)"></p>
                            </div>
                            <div class="col-2">
                                <h6 v-text="txt.fields.licenseIssueDate"></h6>
                                <p v-text="Formatter.formatField(movement.driver.driverLicenseIssueDate)"></p>
                            </div>
                            <div class="col-2"></div>
                            <div class="col-2">
                                <h6 v-text="txt.fields.address"></h6>
                                <p v-text="Formatter.formatField(movement.driver.address)"></p>
                            </div>
                            <div class="col-2">
                                <h6 v-text="txt.fields.city"></h6>
                                <p v-text="Formatter.formatField(movement.driver.city)"></p>
                            </div>
                            <div class="col-2">
                                <h6 v-text="txt.fields.state"></h6>
                                <p v-text="Formatter.formatField(movement.driver.state)"></p>
                            </div>
                            <div class="col-2">
                                <h6 v-text="txt.fields.postalCode"></h6>
                                <p v-text="Formatter.formatField(movement.driver.postalCode)"></p>
                            </div>
                            <div class="col-2">
                                <h6 v-text="txt.fields.country"></h6>
                                <p v-text="Formatter.formatField(movement.driver.country)"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->

        <movement-driver-vehicle-data :vehicle="movement.vehicle" />

        <div
            v-if="[constants.movementStatus.pending, constants.movementStatus.progress].includes(movement.status.id)"
            class="row"
        >
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--bordered">
                    <div class="kt-portlet__foot">
                        <div class="kt-align-right">
                            <button @click="goEdit" type="button" class="btn btn-primary">
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
import MovementDriverVehicleData from "../../components/driver/MovementDriverVehicleData";

export default {
    name: "DriverMovementDetails",
    components: {
        MovementDriverVehicleData,
    },
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
    },
};
</script>

<style scoped></style>
