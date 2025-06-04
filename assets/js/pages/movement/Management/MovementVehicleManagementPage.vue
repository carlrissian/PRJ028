<template>
    <fragment>
        <notifications position="top right" />

        <div v-if="typeIsDriver || cannotManage" class="fullscreen-overlay"></div>

        <movement-carrier-assigned-vehicles-list
            v-if="movement.movementTypeId === constants.movementType.carrier"
            :movement="movement"
        />

        <movement-operation-assigned-vehicles-list
            v-if="movement.movementTypeId === constants.movementType.operation"
            :movement="movement"
        />
    </fragment>
</template>

<script>
import Loading from "../../../../assets/js/utilities";

import MovementCarrierAssignedVehiclesList from "./Sections/Carrier/MovementCarrierAssignedVehiclesList.vue";
import MovementOperationAssignedVehiclesList from "./Sections/Operation/MovementOperationAssignedVehiclesList.vue";

export default {
    name: "MovementVehicleManagementPage",
    components: {
        MovementCarrierAssignedVehiclesList,
        MovementOperationAssignedVehiclesList,
    },
    props: {
        movement: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            constants,
            txt: txtTrans,
        };
    },
    mounted() {
        if (this.typeIsDriver || this.cannotManage) {
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
        cannotManage() {
            return (
                this.movement.movementTypeId !== constants.movementType.driver &&
                [constants.movementStatus.finalized, constants.movementStatus.cancelled].includes(this.movement.movementStatusId)
            );
        },
    },
    methods: {
        getTriggerMessage(trigger) {
            const messages = {
                [this.typeIsDriver]: this.txt.form.movementIsDriver,
                [this.cannotManage]: this.txt.form.movementFinalizedOrCancelled,
            };
            return messages[trigger] || "";
        },
    },
};
</script>

<style scoped></style>
