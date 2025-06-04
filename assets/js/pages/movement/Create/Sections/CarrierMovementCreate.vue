<template>
    <movement-carrier-form
        :selectList="selectList"
        :movementTypeId="movementTypeId"
        :action="CREATE_ACTION"
    ></movement-carrier-form>
</template>

<script>
import { CREATE_ACTION } from "../../components/Carrier/MovementCarrierForm";
import MovementCarrierForm from "../../components/Carrier/MovementCarrierForm";

export default {
    name: "CarrierMovementCreate",
    components: {
        MovementCarrierForm,
    },
    props: {
        movementTypeId: Number,
        selectList: Object,
    },
    data() {
        return {
            CREATE_ACTION,
        };
    },
    methods: {},
};
</script>

<style scoped></style>
