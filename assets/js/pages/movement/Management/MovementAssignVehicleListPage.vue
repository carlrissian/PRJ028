<template>
    <fragment>
        <notifications position="top right"></notifications>

        <div v-if="typeIsDriver || cannotAssign || cannotAssignMoreVehicles" class="fullscreen-overlay"></div>

        <movement-carrier-assign-vehicles
            v-if="movement.movementTypeId === constants.movementType.carrier"
            :select-list="selectList"
            :movement="movement"
        />

        <movement-operation-assign-vehicles
            v-if="movement.movementTypeId === constants.movementType.operation"
            :select-list="selectList"
            :movement="movement"
        />
    </fragment>
</template>

<script>
import Loading from "../../../../assets/js/utilities";

import MovementCarrierAssignVehicles from "./Sections/Carrier/MovementCarrierAssignVehicles.vue";
import MovementOperationAssignVehicles from "./Sections/Operation/MovementOperationAssignVehicles.vue";

export default {
    name: "MovementAssignVehicleListPage",
    components: {
        MovementCarrierAssignVehicles,
        MovementOperationAssignVehicles,
    },
    props: {
        selectList: Object,
        movement: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            txt: {},
            constants,
        };
    },
    created() {
        this.txt = txtTrans;
    },
    mounted() {
        if (this.typeIsDriver || this.cannotAssign || this.cannotAssignMoreVehicles) {
            window.swal
                .fire({
                    title: this.getTriggerMessage(true),
                    text: "",
                    type: "warning",
                    confirmButtonColor: "#48465b",
                })
                .then((result) => {
                    Loading.starLoading();
                    setTimeout(() => {
                        window.location.href = this.routing.generate("movement.show", {
                            id: this.movement.id,
                        });
                    }, 300);
                });
        }
    },
    computed: {
        typeIsDriver() {
            return this.movement.movementTypeId === constants.movementType.driver;
        },
        cannotAssign() {
            return (
                this.movement.movementTypeId !== constants.movementType.driver &&
                [constants.movementStatus.finalized, constants.movementStatus.cancelled].includes(this.movement.movementStatusId)
            );
        },
        cannotAssignMoreVehicles() {
            return (
                this.movement.movementTypeId === constants.movementType.carrier &&
                this.movement.transportMethodId === constants.transportMethod.road &&
                this.movement.assignedLicensePlateUnits.total >= constants.transportMethodRoadMaxVehicles
            );
        },
    },
    methods: {
        getTriggerMessage(trigger) {
            const messages = {
                [this.typeIsDriver]: this.txt.form.movementIsDriver,
                [this.cannotAssign]: this.txt.form.movementFinalizedOrCancelled,
                [this.cannotAssignMoreVehicles]: this.txt.form.warnCannotAssignMoreVehicles,
            };
            return messages[trigger] || "";
        },
    },
};
</script>

<style scoped></style>
