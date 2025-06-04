<template>
    <fragment>
        <table class="table table-striped table-bordered table-hover table-checkable no-footer dtr-inline">
            <tr>
                <!-- <th v-text="txt.fields.modelCode"></th> -->
                <th v-text="txt.fields.provider"></th>
                <th v-text="txt.fields.licensePlate"></th>
                <th v-text="txt.fields.vin"></th>
                <th v-text="txt.fields.brand"></th>
                <th v-text="txt.fields.model"></th>
                <th v-text="txt.fields.trim"></th>
            </tr>
            <tr>
                <!-- <td v-text="Formatter.formatField(vehicle.modelCode)"></td> -->
                <td v-text="Formatter.formatField(vehicle.supplier)"></td>
                <td v-text="Formatter.formatField(vehicle.licensePlate)"></td>
                <td v-text="Formatter.formatField(vehicle.vin)"></td>
                <td v-text="Formatter.formatField(vehicle.brand)"></td>
                <td v-text="Formatter.formatField(vehicle.model)"></td>
                <td v-text="Formatter.formatField(vehicle.trim)"></td>
            </tr>
        </table>

        <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>

        <table class="table table-striped table-bordered table-hover table-checkable no-footer dtr-inline">
            <tr>
                <th v-text="txt.fields.carClass"></th>
                <th v-text="txt.fields.carGroup"></th>
                <th v-text="txt.fields.acriss"></th>
                <th v-text="txt.fields.vehicleType"></th>
                <!-- <th v-text="txt.fields.connectedVehicle"></th> -->
                <th v-text="txt.fields.motorizationType"></th>
            </tr>
            <tr>
                <td v-text="Formatter.formatField(vehicle.carClass)"></td>
                <td v-text="Formatter.formatField(vehicle.vehicleGroup)"></td>
                <td v-text="Formatter.formatField(vehicle.acriss)"></td>
                <td v-text="Formatter.formatField(vehicle.vehicleType)"></td>
                <!-- <td v-text="Formatter.formatField(vehicle.connectedVehicle)"></td> -->
                <td v-text="Formatter.formatField(vehicle.motorizationType)"></td>
            </tr>
        </table>

        <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>

        <table class="table table-striped table-bordered table-hover table-checkable no-footer dtr-inline">
            <tr>
                <th v-show="showFuel" v-text="txt.fields.tankCapacity"></th>
                <th v-show="showBattery" v-text="txt.fields.batteryCapacity"></th>
                <th v-text="txt.fields.gearBox"></th>
                <th v-text="txt.fields.co2"></th>
            </tr>
            <tr>
                <td
                    v-show="showFuel"
                    v-text="
                        `${Formatter.formatField(vehicle.tankActualOctaves)}/8 ${txt.form.of} ${Formatter.formatField(
                            vehicle.tankCapacity
                        )}`
                    "
                ></td>
                <td
                    v-show="showBattery"
                    v-text="
                        `${Formatter.formatField(vehicle.batteryActual)}% ${txt.form.of} ${Formatter.formatField(
                            vehicle.batteryCapacity
                        )}`
                    "
                ></td>
                <td v-text="Formatter.formatField(vehicle.gearBox)"></td>
                <td v-text="Formatter.formatField(vehicle.co2)"></td>
            </tr>
        </table>

        <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>

        <table class="table table-striped table-bordered table-hover table-checkable no-footer dtr-inline">
            <tr>
                <th v-text="txt.fields.region"></th>
                <th v-text="txt.fields.area"></th>
                <th v-text="txt.fields.branch"></th>
                <th v-text="txt.fields.branchIATA"></th>
                <th v-text="txt.fields.location"></th>
                <th v-text="txt.fields.status"></th>
            </tr>
            <tr>
                <td v-text="Formatter.formatField(vehicle.region)"></td>
                <td v-text="Formatter.formatField(vehicle.area)"></td>
                <td v-text="Formatter.formatField(vehicle.branch)"></td>
                <td v-text="Formatter.formatField(branchIATA)"></td>
                <td v-text="Formatter.formatField(vehicle.location)"></td>
                <td v-text="Formatter.formatField(vehicle.status)"></td>
            </tr>
        </table>

        <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>

        <table class="table table-striped table-bordered table-hover table-checkable no-footer dtr-inline">
            <tr>
                <th v-text="txt.fields.contractEndDate"></th>
                <th v-text="txt.fields.deliveryDate"></th>
                <th v-text="txt.fields.byeByeDate"></th>
                <th v-text="txt.fields.kilometers"></th>
                <th v-text="txt.fields.kilometersLimit"></th>
                <th v-show="showFuel" v-text="txt.fields.fuel"></th>
                <th v-show="showBattery" v-text="txt.fields.battery"></th>
            </tr>
            <tr>
                <td v-text="Formatter.formatDate(vehicle.rentalAgreementDropOffDate)"></td>
                <td v-text="Formatter.formatDate(vehicle.deliveryConfirmationDate)"></td>
                <td v-text="Formatter.formatDate(vehicle.byeByeDate)"></td>
                <td v-text="Formatter.formatField(vehicle.actualKms)"></td>
                <td v-text="Formatter.formatField(vehicle.maxKms)"></td>
                <td v-show="showFuel" v-text="`${Formatter.formatField(vehicle.tankActualOctaves)}/8`"></td>
                <td v-show="showBattery" v-text="Formatter.formatField(vehicle.batteryActual)"></td>
            </tr>
        </table>

        <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>

        <table class="table table-striped table-bordered table-hover table-checkable no-footer dtr-inline">
            <tr>
                <th v-text="txt.fields.exteriorHeight"></th>
                <th v-text="txt.fields.exteriorWidth"></th>
                <th v-text="txt.fields.exteriorLength"></th>
                <th v-text="txt.fields.interiorHeight"></th>
                <th v-text="txt.fields.interiorWidth"></th>
                <th v-text="txt.fields.interiorLength"></th>
            </tr>
            <tr>
                <td v-text="Formatter.formatField(vehicle.height)"></td>
                <td v-text="Formatter.formatField(vehicle.width)"></td>
                <td v-text="Formatter.formatField(vehicle.length)"></td>
                <td v-text="Formatter.formatField(vehicle.interiorHeight)"></td>
                <td v-text="Formatter.formatField(vehicle.interiorWidth)"></td>
                <td v-text="Formatter.formatField(vehicle.interiorLength)"></td>
            </tr>
        </table>

        <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>

        <table class="table table-striped table-bordered table-hover table-checkable no-footer dtr-inline">
            <tr>
                <th v-text="txt.fields.numberOfSeats"></th>
                <th v-text="txt.fields.numOfDoors"></th>
                <th v-text="txt.fields.volume"></th>
                <th v-text="txt.fields.trunkCapacity"></th>
                <th v-text="txt.fields.color"></th>
            </tr>
            <tr>
                <td
                    v-text="
                        Formatter.formatField(
                            typeof vehicle.numberOfSeats === 'object' ? vehicle.numberOfSeats.value : vehicle.numberOfSeats
                        )
                    "
                ></td>
                <td v-text="Formatter.formatField(vehicle.numberOfDoors)"></td>
                <td v-text="Formatter.formatField(vehicle.volume)"></td>
                <td v-text="Formatter.formatField(vehicle.trunkCapacity)"></td>
                <td v-text="Formatter.formatField(vehicle.color)"></td>
            </tr>
        </table>

        <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
    </fragment>
</template>

<script>
import Formatter from "../../../../../SharedAssets/js/formatter";

export default {
    name: "VehicleGeneralInfoTab",
    props: {
        vehicle: Object,
    },
    data() {
        return {
            Formatter,
            txt: {},
            branchIATA: null,
        };
    },
    created() {
        this.txt = txtTrans;
        this.branchIATA = this.vehicle.branch?.branchIATA;
    },
    computed: {
        showFuel() {
            return [
                constants.motorizationType.unespecifiedPowerAir,
                constants.motorizationType.unespecifiedPowerNoAir,
                constants.motorizationType.dieselAir,
                constants.motorizationType.dieselNoAir,
                constants.motorizationType.hybrid,
                constants.motorizationType.hybridPlugin,
                constants.motorizationType.lpgAir,
                constants.motorizationType.lpgNoAir,
                constants.motorizationType.hydrogenAir,
                constants.motorizationType.hydrogenNoAir,
                constants.motorizationType.multiFuelAir,
                constants.motorizationType.multiFuelNoAir,
                constants.motorizationType.petrolAir,
                constants.motorizationType.petrolNoAir,
                constants.motorizationType.ethanolAir,
                constants.motorizationType.ethanolNoAir,
            ].includes(this.vehicle.motorizationType.id);
        },
        showBattery() {
            return [
                constants.motorizationType.unespecifiedPowerAir,
                constants.motorizationType.unespecifiedPowerNoAir,
                constants.motorizationType.hybrid,
                constants.motorizationType.hybridPlugin,
                constants.motorizationType.electricE,
                constants.motorizationType.electricC,
                constants.motorizationType.multiFuelAir,
                constants.motorizationType.multiFuelNoAir,
            ].includes(this.vehicle.motorizationType.id);
        },
    },
    methods: {},
};
</script>

<style scoped></style>
