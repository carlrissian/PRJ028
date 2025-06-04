<template>
    <fragment>
        <movement-carrier-assigned-vehicles
            @onTableCheck="check($event)"
            ref="assignedVehicles"
            :movement-id="movement.id"
            :assigned-license-plate-units="movement.assignedLicensePlateUnits"
            :title="txt.titles.assignedVehiclesTo + movement.id"
            title-class="kt-section__title"
            selectable
        >
            <template #action-buttons-head>
                <div class="kt-align-right mb-4">
                    <button
                        type="button"
                        data-toggle="modal"
                        data-target="#modal-assign-vehicle-excel"
                        class="btn btn-dark kt-label-bg-color-4"
                    >
                        <i class="flaticon-add"></i> {{ txt.form.assignVehiclesExcel }}
                    </button>
                    <button
                        @click="assignVehiclesPage"
                        class="btn btn-dark kt-label-bg-color-4"
                        :title="cannotAssignMoreVehicles ? txt.form.warnCannotAssignMoreVehicles : ''"
                        :disabled="cannotAssignMoreVehicles"
                    >
                        <i class="flaticon-add"></i> {{ txt.form.assignVehicles }}
                    </button>
                </div>
            </template>

            <template #action-buttons-foot>
                <div v-if="isVehicleChecked" class="col-md-12">
                    <button
                        type="button"
                        data-toggle="modal"
                        :data-target="`#modal-change-date-vehicle-line-${LOAD_ACTION}`"
                        class="btn btn-dark kt-label-bg-color-4"
                        v-text="txt.titles.editLoadDates"
                        :disabled="cannotEditLoadDates"
                    ></button>
                    <button
                        type="button"
                        data-toggle="modal"
                        :data-target="`#modal-change-date-vehicle-line-${UNLOAD_ACTION}`"
                        class="btn btn-dark kt-label-bg-color-4"
                        v-text="txt.titles.editUnloadDates"
                        :disabled="cannotEditUnloadDates"
                    ></button>

                    <button
                        type="button"
                        data-toggle="modal"
                        data-target="#modal-delete-vehicle-assigned"
                        class="btn btn-dark kt-label-bg-color-4"
                        v-text="txt.form.deleteVehicles"
                    ></button>
                </div>

                <div v-if="movement.assignedLicensePlateUnits.total > 0" class="col-md-12 mt-3">
                    <button
                        type="button"
                        data-toggle="modal"
                        data-target="#modal-validation-movement"
                        class="btn btn-dark kt-label-bg-color-4"
                        v-text="txt.form.validateVehicles"
                    ></button>
                </div>
            </template>
        </movement-carrier-assigned-vehicles>

        <alert v-if="cannotEditLoadDates || cannotEditUnloadDates" type="info">
            <template #text>
                <p v-text="txt.form.warnCannotEditWithoutValidate" style="margin: 0"></p>
            </template>
        </alert>

        <modal-change-date-vehicle-line :action="LOAD_ACTION" :movement="movement" :vehicleList="vehicleSelectedList" />
        <modal-change-date-vehicle-line :action="UNLOAD_ACTION" :movement="movement" :vehicleList="vehicleSelectedList" />

        <modal-delete-vehicle-assigned :movement-id="movement.id" :vehicleList="vehicleSelectedList" />

        <modal-excel-assign-vehicle @closed="eventBus.$emit('refreshAssignedVehiclesTable')" :movement-id="movement.id" />

        <modal-validation-movement :movement="movement" />
    </fragment>
</template>

<script>
import Alert from "../../../../../../SharedAssets/vue/components/Alert.vue";
import MovementCarrierAssignedVehicles from "../../../components/Carrier/MovementCarrierAssignedVehicles.vue";
import { LOAD_ACTION, UNLOAD_ACTION } from "../../../components/modals/ModalChangeDateVehicleLine.vue";
import ModalChangeDateVehicleLine from "../../../components/modals/ModalChangeDateVehicleLine.vue";
import ModalDeleteVehicleAssigned from "../../../components/modals/ModalDeleteVehicleAssigned.vue";
import ModalExcelAssignVehicle from "../../../components/modals/ModalExcelAssignVehicle.vue";
import ModalValidationMovement from "../../../components/modals/ModalValidationMovement.vue";

export default {
    name: "MovementCarrierAssignedVehiclesList",
    components: {
        MovementCarrierAssignedVehicles,
        ModalChangeDateVehicleLine,
        ModalDeleteVehicleAssigned,
        ModalExcelAssignVehicle,
        ModalValidationMovement,
        Alert,
    },
    props: {
        movement: Object,
    },
    data() {
        return {
            LOAD_ACTION,
            UNLOAD_ACTION,
            txt: txtTrans,
            vehicleSelectedList: [],
        };
    },
    computed: {
        cannotEditLoadDates() {
            return this.vehicleSelectedList.some((vehicle) => ["", null, undefined].includes(vehicle.actualLoadDate));
        },
        cannotEditUnloadDates() {
            return this.vehicleSelectedList.some((vehicle) => ["", null, undefined].includes(vehicle.actualUnloadDate));
        },
        cannotAssignMoreVehicles() {
            return (
                this.movement.transportMethodId === constants.transportMethod.road &&
                this.movement.assignedLicensePlateUnits.total >= constants.transportMethodRoadMaxVehicles
            );
        },
        isVehicleChecked() {
            return this.vehicleSelectedList.length > 0;
        },
    },
    methods: {
        assignVehiclesPage() {
            location.href = this.routing.generate("movement.vehicleLine.assign.list", {
                id: this.movement.id,
            });
        },
        check(table) {
            this.vehicleSelectedList = table.getAllSelections();
        },
    },
};
</script>

<style scoped>
/* table thead {
    text-align: center;
}
table tbody tr {
    text-align: center;
} */
</style>
