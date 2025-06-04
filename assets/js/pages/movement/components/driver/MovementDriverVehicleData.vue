<template>
    <div v-if="this.vehicle !== null" class="row">
        <div class="col-md-12">
            <div class="kt-portlet kt-portlet--bordered">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title" v-text="this.txt.titles.vehicleData"></h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="group row">
                        <div class="col-2">
                            <h6 v-text="this.txt.fields.licensePlate"></h6>
                            <p v-text="Formatter.formatField(vehicle.licensePlate)"></p>
                        </div>
                        <div class="col-2">
                            <h6 v-text="this.txt.fields.vin"></h6>
                            <p v-text="Formatter.formatField(vehicle.vin)"></p>
                        </div>
                        <div class="col-2">
                            <h6 v-text="this.txt.fields.carClass"></h6>
                            <p v-text="Formatter.formatField(vehicle.carClass)"></p>
                        </div>
                        <div class="col-2">
                            <h6 v-text="this.txt.fields.carGroup"></h6>
                            <p v-text="Formatter.formatField(vehicle.vehicleGroup)"></p>
                        </div>
                        <div class="col-2">
                            <h6 v-text="this.txt.fields.acriss"></h6>
                            <p v-text="Formatter.formatField(vehicle.acriss)"></p>
                        </div>
                        <div class="col-2">
                            <h6 v-text="this.txt.fields.actualKms"></h6>
                            <p v-text="Formatter.formatField(vehicle.actualKms)"></p>
                        </div>
                        <div class="col-2">
                            <h6 v-text="this.txt.fields.brand"></h6>
                            <p v-text="Formatter.formatField(vehicle.brand)"></p>
                        </div>
                        <div class="col-2">
                            <h6 v-text="this.txt.fields.model"></h6>
                            <p v-text="Formatter.formatField(vehicle.model)"></p>
                        </div>
                        <div class="col-2">
                            <h6 v-text="this.txt.fields.trim"></h6>
                            <p v-text="Formatter.formatField(vehicle.trim)"></p>
                        </div>
                        <div class="col-2">
                            <h6 v-text="this.txt.fields.status"></h6>
                            <p v-text="Formatter.formatField(vehicle.status)"></p>
                        </div>
                        <div class="col-2">
                            <h6 v-text="this.txt.fields.rentingEndDate"></h6>
                            <p v-text="formatDate(vehicle.rentingEndDate)"></p>
                        </div>
                        <div class="col-2">
                            <h6 v-text="this.txt.fields.state"></h6>
                            <p v-text="Formatter.formatField(vehicle.region)"></p>
                        </div>
                        <div class="col-2">
                            <h6 v-text="this.txt.fields.area"></h6>
                            <p v-text="Formatter.formatField(vehicle.area)"></p>
                        </div>
                        <div class="col-2">
                            <h6 v-text="this.txt.fields.branch"></h6>
                            <p v-text="Formatter.formatField(vehicle.branch)"></p>
                        </div>
                        <div class="col-2">
                            <h6 v-text="this.txt.fields.location"></h6>
                            <p v-text="Formatter.formatField(vehicle.location)"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Formatter from "../../../../../SharedAssets/js/formatter";

export default {
    name: "MovementDriverVehicleData",
    props: {
        vehicle: Object,
    },
    created() {
        this.txt = txtTrans;
    },
    data() {
        return {
            Formatter,
            txt: {},
        };
    },
    methods: {
        formatDate(date) {
            return !["", null, undefined].includes(date) ? moment(date, "DD/MM/YYYY").format("DD/MM/YYYY") : "-";
        },
    },
};
</script>

<style scoped></style>
