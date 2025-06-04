<template>
    <div class="row">
        <div class="col-12">
            <div id="kt_portlet" class="kt-portlet">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{ this.txt.title}}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="form-group form-group-last row">
                        <div class="col-3">
                            <label><strong> {{ this.txt.bookingNumber }} </strong> </label>
                            <p class="form-control-static">
                                {{this.booking.bookingNumber}}
                            </p>
                        </div>
                        <div class="col-3">
                            <label><strong> {{ this.txt.brokerBookingNumber }} </strong> </label>
                            <p class="form-control-static">
                                {{this.booking.brokerNumber}}
                            </p>
                        </div>
                        <div class="col-3">
                            <label><strong> {{ this.txt.bookingStatus }} </strong> </label>
                            <p class="form-control-static">
                                {{this.booking.bookingStatus.name}}
                            </p>
                        </div>
                    </div>
                    <div class="row form-group form-group-last">
                        <div class="col-12">
                            <h3> {{ this.txt.titleInformation}}</h3>
                        </div>
                        <div class="form-group col-3">
                            <p><strong>{{this.txt.startRental}}</strong></p>
                            <p>{{this.booking.pickUpDate.location}}</p>
                            <p>{{this.booking.pickUpDate.date}}</p>
                            <p>{{this.booking.pickUpDate.hour}}</p>
                        </div>
                        <div class="form-group col-3">
                            <p><strong>{{this.txt.endRental}}</strong></p>
                            <p>{{this.booking.dropOffDate.location}}</p>
                            <p>{{this.booking.dropOffDate.date}}</p>
                            <p>{{this.booking.dropOffDate.hour}}</p>
                        </div>
                    </div>
                    <div class="form-group form-group-last row">
                        <div class="col-12">
                            <h3> {{ this.txt.titleVehicle}}</h3>
                        </div>
                        <div class="col-3">
                            <label><b> {{ this.txt.carClass }} </b> </label>
                            <p class="form-control-static">
                                {{this.booking.vehicle.carClass}}
                            </p>
                        </div>
                        <div class="col-3">
                            <label><strong> {{ this.txt.acriss }} </strong> </label>
                            <p class="form-control-static">
                                {{this.booking.vehicle.acriss}}
                            </p>
                        </div>
                        <div class="col-3">
                            <label><strong> {{ this.txt.model }} </strong> </label>
                            <p class="form-control-static">
                                {{this.booking.vehicle.model}}
                            </p>
                        </div>
                    </div>
                    <div class="form-group form-group-last row">
                        <button type="button" class="btn btn-primary form-group" data-toggle="modal" data-target="#bookingModalNotes">{{ this.txt.notes }}</button>
                    </div>
                    <div class="form-group form-group-last row">
                        <summary-booking
                             :summary-data="this.booking.summary.summaryBooking"
                             :coin="this.booking.summary.coin">
                        </summary-booking>
                    </div>
                </div>
            </div>
        </div>

        <modal-notes
            :title="txt.notes"
            :note-data="this.booking.notes">
        </modal-notes>

    </div>
</template>

<script>
    import ModalNotes from "../booking/modal/NotesModal";
    import SummaryBooking from "../booking/SummaryBooking";

    export default {
        name: "VehicleBooking",
        components: {SummaryBooking, ModalNotes},
        props: {
            booking: Object,
        },
        data(){
            return {
                txt: Array
            }
        },
        mounted() {
            this.txt = txtTrans.txtForm;
        },
    }
</script>

<style scoped>
    .form-group{
        margin-bottom: 2rem;
    }
    .complements-item{
        color: #707070;
        font-weight: lighter;
    }
    .align-center{
        text-align: center;
    }
    .align-right{
        text-align: right;
    }
</style>