<template>
    <fragment>
        <notifications position="top right" />

        <list-acriss v-if="selectList" :select-list="selectList" />
    </fragment>
</template>

<script>
import Loading from "../../../assets/js/utilities";
import ListAcriss from "../../components/acriss/ListAcriss.vue";

export default {
    name: "AcrissListPage",
    components: {
        ListAcriss,
    },
    data() {
        return {
            txt: txtTrans,
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
                const [
                    commercialGroupList,
                    carGroupList,
                    carClassList,
                    acrissTypeList,
                    motorizationTypeList,
                    gearBoxList,
                ] = await Promise.all([
                    this.axios.get(this.routing.generate("commercialGroup.selectList")),
                    this.axios.get(this.routing.generate("cargroup.selectList")),
                    this.axios.get(this.routing.generate("carClass.selectList")),
                    this.axios.get(this.routing.generate("acrissType.selectList")),
                    this.axios.get(this.routing.generate("motorizationType.selectList")),
                    this.axios.get(this.routing.generate("gearBox.selectList")),
                ]);

                this.selectList = {
                    commercialGroupList: commercialGroupList.data,
                    carGroupList: carGroupList.data,
                    carClassList: carClassList.data,
                    acrissTypeList: acrissTypeList.data,
                    gearBoxList: gearBoxList.data,
                    motorizationTypeList: motorizationTypeList.data,
                };

                this.selectList.statusList = [
                    {
                        id: true,
                        name: this.txt.form.enabled,
                    },
                    {
                        id: false,
                        name: this.txt.form.disabled,
                    },
                ];
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
