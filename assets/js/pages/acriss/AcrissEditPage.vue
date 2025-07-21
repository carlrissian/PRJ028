<template>
    <fragment>
        <notifications position="top right" />

        <acriss-form v-if="selectList" :action="EDIT_ACTION" :select-list="selectList" :acriss="acriss" />
    </fragment>
</template>

<script>
import Loading from "../../../assets/js/utilities";
import AcrissForm from "../../components/acriss/form/AcrissForm.vue";
import { EDIT_ACTION } from "../../components/acriss/form/AcrissForm.vue";

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
            selectList: null,
        };
    },
    async created() {
        this.getSelectLists();
    },
    methods: {
        async getSelectLists() {
            Loading.starLoading();

            try {
                const [carClassList, acrissTypeList, gearBoxList, motorizationTypeList, vehicleSeatsList] = await Promise.all([
                    this.axios.get(this.routing.generate("carClass.selectList")),
                    this.axios.get(this.routing.generate("acrissType.selectList")),
                    this.axios.get(this.routing.generate("gearBox.selectList")),
                    this.axios.get(this.routing.generate("motorizationType.selectList")),
                    this.axios.get(this.routing.generate("vehicleSeats.selectList")),
                ]);

                this.selectList = {
                    carClassList: carClassList.data,
                    acrissTypeList: acrissTypeList.data,
                    gearBoxList: gearBoxList.data,
                    motorizationTypeList: motorizationTypeList.data,
                    vehicleSeatsList: vehicleSeatsList.data,
                };
            } catch (error) {
                console.error(error);
            } finally {
                Loading.endLoading();
            }
        },
    },
};
</script>

<style scoped></style>
