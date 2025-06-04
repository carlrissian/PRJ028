<template>
    <erp-modal @onCloseModal="warningMessages = null" id="modal-delete-vehicle-assigned" :title="txt.titles.deleteVehicles">
        <template slot="body">
            <p v-text="txt.form.deleteVehiclesQuestion"></p>
            <ul v-for="vehicle in vehicleList" :key="vehicle.id">
                <li
                    v-text="
                        `${Formatter.formatField(vehicle.brand)} ${Formatter.formatField(
                            vehicle.model
                        )} - ${Formatter.formatField(vehicle.licensePlate)}`
                    "
                ></li>
            </ul>

            <alert v-if="warningMessages !== null" @flush="warningMessages = null" type="warning">
                <template #text>
                    <p v-text="warningMessages" style="margin: 0;"></p>
                </template>
            </alert>
        </template>
        <template slot="footer">
            <div class="kt-align-right">
                <button
                    @click.prevent="deleteVehicles"
                    type="button"
                    id="btn-create-modal"
                    class="btn btn-dark kt-label-bg-color-4"
                    v-text="txt.form.delete"
                ></button>
            </div>
        </template>
    </erp-modal>
</template>

<script>
import Axios from "axios";
import Loading from "../../../../../assets/js/utilities";
import Formatter from "../../../../../SharedAssets/js/formatter";
import Alert from "../../../../../SharedAssets/vue/components/Alert";
import ErpModal from "../../../../../SharedAssets/vue/components/modal/ErpModal";

export default {
    name: "ModalDeleteVehicleAssigned",
    components: {
        ErpModal,
        Alert,
    },
    props: {
        movementId: Number,
        vehicleList: Array,
    },
    data() {
        return {
            Formatter,
            txt: {},
            warningMessages: null,
        };
    },
    created() {
        this.txt = txtTrans;
    },
    methods: {
        async deleteVehicles() {
            this.warningMessages = null;

            let vehicleIdList = this.vehicleList.map((vehicle) => vehicle.id);
            let licenses = this.vehicleList
                .filter((vehicle) => vehicle.actualUnloadDate || vehicle.actualLoadDate)
                .map((vehicle) => vehicle.licensePlate.name);

            if (licenses.length > 0) {
                this.warningMessages = this.txt.form.errorExistingLoadUnladDateVehicle + licenses.join(", ");
            } else {
                Loading.starLoading();

                let url = this.routing.generate("movement.vehicleLine.delete", {
                    movementId: this.movementId,
                    vehicleIdList: vehicleIdList,
                });
                Axios.post(url)
                    .then((response) => {
                        // console.log("Delete VehicleLines: ", response);
                        Loading.endLoading();

                        if (response.data.deleted) {
                            this.$notify({
                                text: this.txt.form.vehicleLinesDeletedSuccessNotification,
                                type: "success",
                            });

                            setTimeout(() => {
                                window.location.href = this.routing.generate("movement.vehicleLine.assigned.list", {
                                    id: this.movementId,
                                });
                            }, 2000);
                        } else {
                            this.$notify({
                                text: this.txt.form.errorDeletingVehicleLinesNotification,
                                type: "error",
                            });
                        }
                    })
                    .catch((error) => {
                        console.log(error.response);
                        Loading.endLoading();

                        let errorMessage = this.txt.form.errorDeletingVehicleLinesNotification;
                        if (error.response.status === 460) errorMessage += error.response.data.message;

                        this.$notify({
                            type: "error",
                            text: errorMessage,
                        });
                    });
            }
        },
    },
};
</script>

<style scoped></style>
