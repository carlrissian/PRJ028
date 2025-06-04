<template>
    <fragment>
        <notifications position="top right" />

        <acriss-form :action="CREATE_ACTION" />
    </fragment>
</template>

<script>
import AcrissForm from "../components/AcrissForm.vue";
import { CREATE_ACTION } from "../components/AcrissForm.vue";

export default {
    name: "AcrissCreatePage",
    components: {
        AcrissForm,
    },
    data() {
        return {
            CREATE_ACTION,
        };
    },
};
</script>

<style scoped></style>
