<template>
    <fragment>
        <notifications position="top right" />

        <acriss-form :action="EDIT_ACTION" :acriss-data="acriss" />
    </fragment>
</template>

<script>
import AcrissForm from "../components/AcrissForm.vue";
import { EDIT_ACTION } from "../components/AcrissForm.vue";

export default {
    name: "AcrissEditPage",
    components: {
        AcrissForm,
    },
    props: {
        acriss: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            EDIT_ACTION,
        };
    },
};
</script>

<style scoped></style>
