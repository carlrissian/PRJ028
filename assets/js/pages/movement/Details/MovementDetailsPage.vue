<template>
    <fragment>
        <notifications position="top right" />

        <!--DRIVER-->
        <driver-movement-details
            v-if="movementTypeId === constants.movementType.driver"
            :movementTypeId="movementTypeId"
            :movement="movement"
        />
        <!--CARRIER-->
        <carrier-movement-details
            v-if="movementTypeId === constants.movementType.carrier"
            :movementTypeId="movementTypeId"
            :movement="movement"
        />
        <!--OPERATION-->
        <operation-movement-details
            v-if="movementTypeId === constants.movementType.operation"
            :movementTypeId="movementTypeId"
            :movement="movement"
        />
    </fragment>
</template>

<script>
import DriverMovementDetails from "./Sections/DriverMovementDetails";
import CarrierMovementDetails from "./Sections/CarrierMovementDetails";
import OperationMovementDetails from "./Sections/OperationMovementDetails";

export default {
    name: "MovementDetailsPage",
    components: {
        DriverMovementDetails,
        CarrierMovementDetails,
        OperationMovementDetails,
    },
    props: {
        movement: Object,
        movementTypeId: Number,
    },
    data() {
        return {
            constants: {},
        };
    },
    created() {
        this.constants = constants;
    },
    methods: {},
};
</script>
