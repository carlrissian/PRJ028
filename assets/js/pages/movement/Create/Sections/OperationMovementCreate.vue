<template>
    <movement-operation-form
        :selectList="selectList"
        :movementTypeId="movementTypeId"
        :action="CREATE_ACTION"
    ></movement-operation-form>
</template>

<script>
import { CREATE_ACTION } from "../../components/operation/MovementOperationForm";
import MovementOperationForm from "../../components/operation/MovementOperationForm";

export default {
    name: "OperationMovementCreate",
    components: {
        MovementOperationForm,
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
