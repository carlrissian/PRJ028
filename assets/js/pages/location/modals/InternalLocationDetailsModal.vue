<template>
    <erp-modal
        id="internal-location-details-modal"
        :title="`${txt.titles.locationDetails} ${Formatter.formatField(location.id)}`"
    >
        <template #body>
            <div class="row">
                <div class="col-3">
                    <h6 v-text="txt.fields.locationCode"></h6>
                    <p v-text="Formatter.formatField(location.id)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.locationName"></h6>
                    <p v-text="Formatter.formatField(location.name)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.locationType"></h6>
                    <p
                        v-text="
                            `${Formatter.formatField(location.locationType.id)} - ${Formatter.formatField(location.locationType)}`
                        "
                    ></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.branchIATA"></h6>
                    <p v-text="Formatter.formatField(location.branchIATA)"></p>
                </div>
            </div>

            <div class="row">
                <div class="col-3">
                    <h6 v-text="txt.fields.officeManager"></h6>
                    <p v-text="Formatter.formatField(location.officeManager)"></p>
                </div>
                <div class="col-6">
                    <h6 v-text="txt.fields.address"></h6>
                    <p v-text="Formatter.formatField(location.address)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.gpsCoordinates"></h6>
                    <p v-text="Formatter.formatField(location.gpsCoordinates)"></p>
                </div>
            </div>

            <div class="row">
                <div class="col-3">
                    <h6 v-text="txt.fields.postalCode"></h6>
                    <p v-text="Formatter.formatField(location.postalCode)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.city"></h6>
                    <p v-text="Formatter.formatField(location.city)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.state"></h6>
                    <p v-text="Formatter.formatField(location.state)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.country"></h6>
                    <p v-text="Formatter.formatField(location.country)"></p>
                </div>
            </div>

            <div class="row">
                <div class="col-3">
                    <h6 v-text="txt.fields.deskCount"></h6>
                    <p v-text="Formatter.formatField(location.deskCount)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.totemCount"></h6>
                    <p v-text="Formatter.formatField(location.totemCount)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.parkingSpots"></h6>
                    <p v-text="Formatter.formatField(location.parkingSpots)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.stockLimit"></h6>
                    <p v-text="Formatter.formatField(location.stockLimit)"></p>
                </div>
            </div>

            <div class="row">
                <div class="col-3">
                    <h6 v-text="txt.fields.area"></h6>
                    <p v-text="Formatter.formatField(location.area)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.phone"></h6>
                    <p v-text="Formatter.formatField(location.phone)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.email"></h6>
                    <p v-text="Formatter.formatField(location.email)"></p>
                </div>
            </div>

            <div class="row">
                <div class="col-3">
                    <h6 v-text="txt.fields.frontOfficeSchedule"></h6>
                    <p v-text="Formatter.formatField(location.frontOfficeSchedule)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.fleetReceptionSchedule"></h6>
                    <p v-text="Formatter.formatField(location.fleetReceptionSchedule)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.parkingSituation"></h6>
                    <p v-text="Formatter.formatField(location.parkingSituation)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.parkingDryCleaning"></h6>
                    <p
                        v-text="
                            location.parkingDryCleaning !== null
                                ? location.parkingDryCleaning
                                    ? txt.form.yes
                                    : txt.form.no
                                : '-'
                        "
                    ></p>
                </div>
            </div>
        </template>
    </erp-modal>
</template>

<script>
import Formatter from "../../../../SharedAssets/js/formatter";
import ErpModal from "../../../../SharedAssets/vue/components/modal/ErpModal";

export default {
    name: "InternalLocationDetailsModal",
    components: {
        ErpModal,
    },
    props: {
        locationData: {
            type: Object,
            default: null,
        },
    },
    watch: {
        locationData: function(data) {
            this.location.id = data?.id;
            this.location.name = data?.name;
            this.location.locationType = data?.locationType;
            this.location.branchIATA = data?.branch.branchIATA;
            this.location.officeManager = data?.officeManager;
            this.location.address = data?.address;
            this.location.gpsCoordinates = data?.gPSCoordinates;
            this.location.postalCode = data?.postalCode;
            this.location.city = data?.city;
            this.location.state = data?.state;
            this.location.country = data?.country;
            this.location.deskCount = data?.deskCount;
            this.location.totemCount = data?.totemCount;
            this.location.stockLimit = data?.stockLimit;
            this.location.area = data?.area;
            this.location.parkingSpots = data?.parkingSpots;
            this.location.phone = data?.phone;
            this.location.email = data?.email;
            this.location.frontOfficeSchedule = data?.frontOfficeSchedule;
            this.location.fleetReceptionSchedule = data?.fleetReceptionSchedule;
            this.location.parkingSituation = data?.parkingSituation;
            this.location.parkingDryCleaning = data?.parkingDryCleaning;
        },
    },
    data() {
        return {
            Formatter,
            txt: {},
            location: {
                id: null,
                name: null,
                locationType: {
                    id: null,
                    name: null,
                },
                branchIATA: null,
                officeManager: null,
                address: null,
                gpsCoordinates: null,
                postalCode: null,
                city: null,
                state: null,
                country: null,
                deskCount: null,
                totemCount: null,
                stockLimit: null,
                area: null,
                parkingSpots: null,
                phone: null,
                email: null,
                frontOfficeSchedule: null,
                fleetReceptionSchedule: null,
                parkingSituation: null,
                parkingDryCleaning: null,
            },
        };
    },
    created() {
        this.txt = txtTrans;
    },
};
</script>

<style scoped></style>
