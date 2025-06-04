<template>
    <fragment>
        <notifications position="top right" />

        <list-route :select-list="selectList" />
    </fragment>
</template>

<script>
import ListRoute from "./ListRoute.vue";
export default {
    name: "RoutesListPage",
    components: {
        ListRoute,
    },
    props: {
        selectList: {
            type: Object,
            required: true,
        },
    },
    methods: {},
};
</script>

<style scoped></style>
