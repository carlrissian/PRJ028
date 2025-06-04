<template>
    <movement-carrier-form
        :selectList="selectList"
        :movementData="movement"
        :movementTypeId="movementTypeId"
        :action="EDIT_ACTION"
    ></movement-carrier-form>
</template>

<script>
import { EDIT_ACTION } from "../../components/Carrier/MovementCarrierForm";
import MovementCarrierForm from "../../components/Carrier/MovementCarrierForm";

export default {
    name: "CarrierMovementEdit",
    components: {
        MovementCarrierForm,
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
