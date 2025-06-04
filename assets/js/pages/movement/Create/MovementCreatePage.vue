<template>
    <fragment>
        <notifications position="top right" />

        <!--DRIVER-->
        <driver-movement-create
            v-if="movementTypeId === constants.movementType.driver"
            :movementTypeId="movementTypeId"
            :select-list="selectList"
        />
        <!--CARRIER-->
        <carrier-movement-create
            v-if="movementTypeId === constants.movementType.carrier"
            :movementTypeId="movementTypeId"
            :select-list="selectList"
        />
        <!--OPERATION-->
        <operation-movement-create
            v-if="movementTypeId === constants.movementType.operation"
            :movementTypeId="movementTypeId"
            :select-list="selectList"
        />
    </fragment>
</template>

<script>
import DriverMovementCreate from "./Sections/DriverMovementCreate";
import CarrierMovementCreate from "./Sections/CarrierMovementCreate";
import OperationMovementCreate from "./Sections/OperationMovementCreate";

export default {
    name: "MovementCreatePage",
    components: {
        DriverMovementCreate,
        CarrierMovementCreate,
        OperationMovementCreate,
    },
    props: {
        selectList: Object,
        movementTypeId: Number,
    },
    data() {
        return {
            constants,
        };
    },
    methods: {},
};
</script>
