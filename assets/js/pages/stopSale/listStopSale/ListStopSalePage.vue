<template>
    <fragment>
        <!-- STANDARD -->
        <div v-if="stopSaleCategoryId === constants.category.standard">
            <list-stop-sale-standard-filter :select-list="selectList" :stopSaleCategoryId="stopSaleCategoryId" />
            <list-stop-sale-standard
                :select-list="selectList"
                :stopSaleCategoryId="stopSaleCategoryId"
                :stop-sale-name="stopSaleName"
            />
        </div>
        <!--  -->

        <!-- ONEWAY -->
        <div v-if="stopSaleCategoryId === constants.category.oneway">
            <list-stop-sale-oneway-filter :select-list="selectList" :stopSaleCategoryId="stopSaleCategoryId" />
            <list-stop-sale-oneway
                :select-list="selectList"
                :stopSaleCategoryId="stopSaleCategoryId"
                :stop-sale-name="stopSaleName"
            />
        </div>
        <!--  -->
    </fragment>
</template>

<script>
import ListStopSaleStandard from "./ListStopSaleStandard";
import ListStopSaleStandardFilter from "./ListStopSaleStandardFilter";
import ListStopSaleOneway from "./ListStopSaleOneway";
import ListStopSaleOnewayFilter from "./ListStopSaleOnewayFilter";

export default {
    name: "ListStopSalePage",
    components: {
        ListStopSaleStandard,
        ListStopSaleStandardFilter,
        ListStopSaleOneway,
        ListStopSaleOnewayFilter,
    },
    props: {
        selectList: Object,
        stopSaleCategoryId: Number,
        stopSaleName: String,
    },
    data() {
        return {
            constants,
        };
    },
};
</script>

<style scoped></style>
