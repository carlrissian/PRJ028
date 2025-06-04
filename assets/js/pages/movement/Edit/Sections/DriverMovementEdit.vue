<template>
    <fragment>
        <movement-driver-vehicle-data :vehicle="movement.vehicle" />

        <movement-driver-form
            :selectList="selectList"
            :movementTypeId="movementTypeId"
            :movementData="movement"
            :vehicle="movement.vehicle"
            :action="EDIT_ACTION"
        ></movement-driver-form>
    </fragment>
</template>

<script>
import MovementDriverVehicleData from "../../components/driver/MovementDriverVehicleData";
import { EDIT_ACTION } from "../../components/driver/MovementDriverForm";
import MovementDriverForm from "../../components/driver/MovementDriverForm";

export default {
    name: "DriverMovementEdit",
    components: {
        MovementDriverVehicleData,
        MovementDriverForm,
    },
    props: {
        movement: Object,
        movementTypeId: Number,
        selectList: Object,
    },
    data() {
        return {
            EDIT_ACTION,
        };
    },
    methods: {},
};
</script>

<style scoped></style>
