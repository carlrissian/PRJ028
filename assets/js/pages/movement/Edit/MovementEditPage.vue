<template>
    <fragment>
        <notifications position="top right" />

        <div v-if="cannotEdit" class="fullscreen-overlay"></div>

        <!--DRIVER-->
        <driver-movement-edit
            :id="id"
            :movement="movement"
            :movementTypeId="movementTypeId"
            :select-list="selectList"
            v-if="movementTypeId === constants.movementType.driver"
        />
        <!--CARRIER-->
        <carrier-movement-edit
            :id="id"
            :movement="movement"
            :movementTypeId="movementTypeId"
            :select-list="selectList"
            v-if="movementTypeId === constants.movementType.carrier"
        />
        <!--OPERATION-->
        <operation-movement-edit
            :id="id"
            :movement="movement"
            :movementTypeId="movementTypeId"
            :select-list="selectList"
            v-if="movementTypeId === constants.movementType.operation"
        />
    </fragment>
</template>

<script>
import Loading from "../../../../assets/js/utilities";

import DriverMovementEdit from "./Sections/DriverMovementEdit";
import CarrierMovementEdit from "./Sections/CarrierMovementEdit";
import OperationMovementEdit from "./Sections/OperationMovementEdit";

export default {
    name: "MovementEditPage",
    components: {
        DriverMovementEdit,
        CarrierMovementEdit,
        OperationMovementEdit,
    },
    props: {
        id: Number,
        movementTypeId: Number,
        movement: Object,
        selectList: Object,
    },
    data() {
        return {
            constants,
        };
    },
    mounted() {
        if (this.cannotEdit) {
            window.swal
                .fire({
                    title: txtTrans.form.movementFinalizedOrCancelled,
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
        cannotEdit() {
            return (
                this.movement &&
                [constants.movementStatus.finalized, constants.movementStatus.cancelled].includes(this.movement.movementStatus.id)
            );
        },
    },
    methods: {},
};
</script>

<style scoped></style>
