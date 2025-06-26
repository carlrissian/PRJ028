<template>
    <div class="row">
        <div class="col-md-12">
            <div class="kt-portlet kt-portlet--bordered">
                <div class="kt-portlet__body">
                    <div class="kt-portlet kt-portlet--bordered">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title" v-text="txt.titles.vehicleFile"></h3>
                            </div>
                        </div>

                        <!-- Details summary module -->
                        <div v-if="vehicle != null" class="kt-portlet__body">
                            <div class="group row mt-3">
                                <div class="col-2">
                                    <h6 v-text="txt.fields.licensePlate"></h6>
                                    <p v-text="Formatter.formatField(vehicle.licensePlate)"></p>
                                </div>
                                <div class="col-2">
                                    <h6 v-text="txt.fields.vin"></h6>
                                    <p v-text="Formatter.formatField(vehicle.vin)"></p>
                                </div>
                                <div class="col-2">
                                    <h6 v-text="txt.fields.brand"></h6>
                                    <p v-text="Formatter.formatField(vehicle.brand)"></p>
                                </div>
                                <div class="col-2">
                                    <h6 v-text="txt.fields.model"></h6>
                                    <p v-text="Formatter.formatField(vehicle.model)"></p>
                                </div>
                                <div class="col-2">
                                    <h6 v-text="txt.fields.carGroup"></h6>
                                    <p v-text="Formatter.formatField(vehicle.vehicleGroup)"></p>
                                </div>
                                <div class="col-2">
                                  <h6 v-text="txt.fields.salesMethod"></h6>
                                  <p v-text="Formatter.formatField(vehicle.saleMethod)"></p>
                                </div>
                            </div>

                            <div class="group row mt-3">
                                <div class="col-2">
                                    <h6 v-text="txt.fields.firstRentDate"></h6>
                                    <p v-text="Formatter.formatDate(vehicle.firstRentDate)"></p>
                                </div>
                                <div class="col-2">
                                    <h6 v-text="txt.fields.rentingEndDate"></h6>
                                    <p v-text="Formatter.formatDate(vehicle.rentingEndDate)"></p>
                                </div>
                                <div class="col-2">
                                    <h6 v-text="txt.fields.returnDate"></h6>
                                    <p v-text="Formatter.formatDate(vehicle.returnDate)"></p>
                                </div>
                                <div class="col-2">
                                    <h6 v-text="txt.fields.status"></h6>
                                    <p v-text="Formatter.formatField(vehicle.status)"></p>
                                </div>
                                <div class="col-2">
                                    <h6 v-text="txt.fields.contractEndDate"></h6>
                                    <p v-text="Formatter.formatDate(vehicle.rentalAgreementDropOffDate)"></p>
                                </div>
                                <div class="col-2">
                                    <h6 v-text="txt.fields.blocking"></h6>
                                    <p
                                        style="white-space: pre-line;"
                                        v-text="vehicle.dateBlockage ? txt.form.yes : txt.form.no"
                                        :title="vehicle.dateBlockage ? getBlockDetails() : ''"
                                    ></p>
                                </div>
                            </div>
                        </div>
                        <!--  -->

                        <!-- Vehicle tabs -->
                        <div class="kt-portlet__body">
                            <div class="kt-portlet__head-toolbar">
                                <ul
                                    class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-left nav-tabs-line-primary"
                                    role="tablist"
                                >
                                    <li class="nav-item">
                                        <a
                                            class="nav-link active"
                                            data-toggle="tab"
                                            href="#general-tab"
                                            role="tab"
                                            aria-selected="false"
                                            v-text="txt.tabs.generalInfo"
                                        >
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a
                                            class="nav-link"
                                            data-toggle="tab"
                                            href="#images-tab"
                                            role="tab"
                                            aria-selected="false"
                                            v-text="txt.tabs.images"
                                        >
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a
                                            class="nav-link"
                                            data-toggle="tab"
                                            href="#damages-tab"
                                            role="tab"
                                            aria-selected="false"
                                            v-text="txt.tabs.damages"
                                        >
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a
                                            class="nav-link"
                                            data-toggle="tab"
                                            href="#history-tab"
                                            role="tab"
                                            aria-selected="false"
                                            v-text="txt.tabs.history"
                                        >
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a
                                            class="nav-link"
                                            data-toggle="tab"
                                            href="#anticipations-tab"
                                            role="tab"
                                            aria-selected="false"
                                            v-text="txt.tabs.anticipations"
                                        >
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a
                                            class="nav-link"
                                            data-toggle="tab"
                                            href="#insurance-tab"
                                            role="tab"
                                            aria-selected="false"
                                            v-text="txt.tabs.insurance"
                                        >
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a
                                            class="nav-link"
                                            data-toggle="tab"
                                            href="#annexe-tab"
                                            role="tab"
                                            aria-selected="false"
                                            v-text="txt.tabs.annexes"
                                        >
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane active" id="general-tab" role="tabpanel">
                                    <vehicle-general-info-tab :vehicle="vehicle" />
                                </div>
                                <div class="tab-pane" id="images-tab" role="tabpanel">
                                    <vehicle-images-tab :image-list="vehicle.images" />
                                </div>
                                <div class="tab-pane" id="damages-tab" role="tabpanel">
                                    <vehicle-damages-tab
                                        :vehicle-id="vehicle.id"
                                        :vehicle-type-id="String(vehicle.vehicleType.id)"
                                        :number-of-seats="getNumberOfSeats"
                                    />
                                </div>
                                <div class="tab-pane" id="history-tab" role="tabpanel">
                                    <vehicle-history-tab :vehicle="vehicle" />
                                </div>
                                <div class="tab-pane" id="anticipations-tab" role="tabpanel">
                                    <vehicle-anticipations-tab :vehicle-id="vehicle.id" />
                                </div>
                                <div class="tab-pane" id="insurance-tab" role="tabpanel">
                                    <vehicle-insurance-tab :vehicle-id="vehicle.id" />
                                </div>
                                <div class="tab-pane" id="annexe-tab" role="tabpanel">
                                    <vehicle-annexe-tab :vehicle-id="vehicle.id" />
                                </div>
                            </div>
                        </div>
                        <!--  -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Formatter from "../../../../SharedAssets/js/formatter";

import VehicleGeneralInfoTab from "./tabs/VehicleGeneralInfoTab.vue";
import VehicleImagesTab from "./tabs/VehicleImagesTab.vue";
import VehicleDamagesTab from "./tabs/VehicleDamagesTab.vue";
import VehicleHistoryTab from "./tabs/VehicleHistoryTab.vue";
import VehicleAnticipationsTab from "./tabs/VehicleAnticipationsTab.vue";
import VehicleInsuranceTab from "./tabs/VehicleInsuranceTab.vue";
import VehicleAnnexeTab from "./tabs/VehicleAnnexeTab.vue";

export default {
    name: "VehicleDetailsPage",
    components: {
        VehicleGeneralInfoTab,
        VehicleImagesTab,
        VehicleDamagesTab,
        VehicleHistoryTab,
        VehicleAnticipationsTab,
        VehicleInsuranceTab,
        VehicleAnnexeTab,
    },
    props: {
        vehicle: Object,
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
    computed: {
        getBlockDetails() {
            let begin = `${this.txt.form.begin}: ${Formatter.formatDate(this.vehicle.dateBlockage)}\n`;
            let end = `${this.txt.form.end}: ${Formatter.formatDate(this.vehicle.dateBlockageEnd)}\n`;
            let reason = `${this.txt.form.reason}: ${Formatter.formatField(this.vehicle.blockageReason)}\n`;
            return begin + end + reason;
        },
        getNumberOfSeats() {
            return typeof this.vehicle.numberOfSeats === "object" ? this.vehicle.numberOfSeats.value : this.vehicle.numberOfSeats;
        },
    },
};
</script>

<style scoped></style>
