<template>
    <erp-modal
        @onCloseModal="flush"
        :id="`modal-change-date-vehicle-line-${action}`"
        :title="action === LOAD_ACTION ? txt.titles.editLoadDates : txt.titles.editUnloadDates"
        use-form
        :submit-prevent="changeDateVehicleLine"
    >
        <template slot="body">
            <div class="row">
                <div class="col-md-12">
                    <p v-text="`${vehicleList.length} ${txt.form.selectedVehicles}`"></p>
                </div>

                <date-picker
                    v-if="action === LOAD_ACTION"
                    @updatedDatePicker="dates.actualLoadDate = $event"
                    name="actualLoadDate"
                    id="actualLoadDate"
                    div-class="col-md-6"
                    :label="txt.fields.actualLoadDate"
                    v-model:value="dates.actualLoadDate"
                    :limit-start-day="movement.expectedLoadDate"
                    :limit-end-day="movement.expectedUnloadDate"
                    required
                />

                <date-picker
                    v-if="action === UNLOAD_ACTION"
                    @updatedDatePicker="dates.actualUnloadDate = $event"
                    name="actualUnloadDate"
                    id="actualUnloadDate"
                    div-class="col-md-6"
                    :label="txt.fields.actualUnloadDate"
                    v-model:value="dates.actualUnloadDate"
                    :limit-start-day="movement.expectedLoadDate"
                    :limit-end-day="movement.expectedUnloadDate"
                    required
                />
            </div>

            <alert v-if="errors !== null" @flush="errors = null" type="warning" class="mt-5">
                <template #text>
                    <p v-html="errors" style="margin: 0"></p>
                </template>
            </alert>
        </template>

        <template slot="footer">
            <div class="kt-align-right">
                <button type="submit" class="btn btn-dark kt-label-bg-color-4" v-text="txt.form.editDates"></button>
            </div>
        </template>
    </erp-modal>
</template>

<script>
export const LOAD_ACTION = "load";
export const UNLOAD_ACTION = "unload";

import Axios from "axios";
import Loading from "../../../../../assets/js/utilities";
import Alert from "../../../../../SharedAssets/vue/components/Alert.vue";
import ErpModal from "../../../../../SharedAssets/vue/components/modal/ErpModal";
import DatePicker from "../../../../../SharedAssets/vue/components/base/inputs/DatePicker";

export default {
    name: "ModalChangeDateVehicleLine",
    components: {
        ErpModal,
        DatePicker,
        Alert,
    },
    props: {
        action: String,
        movement: Object,
        vehicleList: Array,
    },
    data() {
        return {
            LOAD_ACTION,
            UNLOAD_ACTION,
            txt: {},
            dates: {
                actualLoadDate: null,
                actualUnloadDate: null,
            },
            errors: null,
        };
    },
    created() {
        this.txt = txtTrans;
    },
    methods: {
        flush() {
            this.dates.actualLoadDate = null;
            this.dates.actualUnloadDate = null;
            this.errors = null;
        },
        showNotification(type = "", text = "") {
            this.$notify({
                text,
                type,
            });
        },
        async changeDateVehicleLine() {
            this.errors = null;
            let errors = "";

            let vehicleIdList = this.vehicleList.map((vehicle) => vehicle.id);
            this.vehicleList.forEach((vehicle) => {
                let vehicleLoadDate = Date.parse(moment(vehicle.actualLoadDate, "DD/MM/YYYY"));
                let vehicleUnloadDate = Date.parse(moment(vehicle.actualUnloadDate, "DD/MM/YYYY"));

                if (
                    this.dates.actualUnloadDate &&
                    vehicleLoadDate > Date.parse(moment(this.dates.actualUnloadDate, "DD/MM/YYYY"))
                ) {
                    errors += `${this.txt.form.errorUpdateUnloadDateVehicle} - ${vehicle.licensePlate.name}\n`;
                }

                if (
                    this.dates.actualLoadDate &&
                    Date.parse(moment(this.dates.actualLoadDate, "DD/MM/YYYY")) > vehicleUnloadDate
                ) {
                    errors += `${this.txt.form.errorUpdateLoadDateVehicle} - ${vehicle.licensePlate.name}\n`;
                }
            });

            if (errors.length > 0) {
                this.errors = errors;
            } else {
                Loading.starLoading();

                let url = this.routing.generate("movement.vehicleLine.updateDate", {
                    movementId: this.movement.id,
                    actualLoadDate: this.dates.actualLoadDate,
                    actualUnloadDate: this.dates.actualUnloadDate,
                    vehicleIdList: vehicleIdList,
                });
                Axios.post(url)
                    .then((response) => {
                        // console.log("Update Vehicle Dates: ", response);
                        Loading.endLoading();

                        if (response.data.datesUpdated) {
                            this.showNotification(
                                "success",
                                this.action === LOAD_ACTION
                                    ? this.txt.form.loadDatesUpdatedSuccessNotification
                                    : this.txt.form.unloadDatesUpdatedSuccessNotification
                            );

                            setTimeout(() => {
                                window.location.href = this.routing.generate("movement.vehicleLine.assigned.list", {
                                    id: this.movement.id,
                                });
                            }, 2000);
                        } else {
                            this.showNotification("error", this.txt.form.errorUpdatingDatesNotification);
                        }
                    })
                    .catch((error) => {
                        console.log(error.response);
                        Loading.endLoading();
                        this.showNotification("error", this.txt.form.errorUpdatingDatesNotification);
                    });
            }
        },
    },
};
</script>

<style scoped></style>
