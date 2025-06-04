<template>
    <movement-operation-form
        :selectList="selectList"
        :movementData="movement"
        :movementTypeId="movementTypeId"
        :action="EDIT_ACTION"
    ></movement-operation-form>
</template>

<script>
import { EDIT_ACTION } from "../../components/operation/MovementOperationForm";
import MovementOperationForm from "../../components/operation/MovementOperationForm";

export default {
    name: "OperationMovementEdit",
    components: {
        MovementOperationForm,
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
