<template>
    <fragment>
        <vehicle-search @onSuccessSearch="onSuccessSearch" @reset="showForm = false"></vehicle-search>

        <movement-driver-form
            v-show="showForm"
            :selectList="selectList"
            :movementTypeId="movementTypeId"
            :vehicle="vehicleData"
            :action="CREATE_ACTION"
        ></movement-driver-form>
    </fragment>
</template>

<script>
import { CREATE_ACTION } from "../../components/driver/MovementDriverForm";
import MovementDriverForm from "../../components/driver/MovementDriverForm";
import VehicleSearch from "../../components/driver/VehicleSearch";

export default {
    name: "DriverMovementCreate",
    components: {
        MovementDriverForm,
        VehicleSearch,
    },
    props: {
        movementTypeId: Number,
        selectList: Object,
    },
    data() {
        return {
            CREATE_ACTION,
            vehicleData: null,
            showForm: false,
        };
    },
    methods: {
        onSuccessSearch(data) {
            this.vehicleData = data;
            this.showForm = true;
        },
    },
};
</script>

<style scoped></style>
