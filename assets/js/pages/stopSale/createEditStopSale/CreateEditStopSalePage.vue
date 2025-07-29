<template>
    <fragment>
        <notifications position="top right" />

        <!-- STANDARD -->
        <standard-stop-sale-form
            v-if="categoryId === constants.category.standard"
            :select-list="selectList"
            :stop-sale="stopSale"
        />
        <!--  -->

        <!-- ONEWAY -->
        <one-way-stop-sale-form v-if="categoryId === constants.category.oneway" :select-list="selectList" :stop-sale="stopSale" />
        <!--  -->
    </fragment>
</template>

<script>
import StandardStopSaleForm from "./StandardStopSaleForm";
import OneWayStopSaleForm from "./OneWayStopSaleForm";

export default {
    name: "CreateEditStopSalePage",
    components: {
        StandardStopSaleForm,
        OneWayStopSaleForm,
    },
    props: {
        categoryId: Number,
        selectList: Object,
        stopSale: Object,
    },
    data() {
        return {
            constants,
        };
    },
};
</script>

<style scoped></style>
