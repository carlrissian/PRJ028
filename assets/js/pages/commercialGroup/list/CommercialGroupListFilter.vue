<template>
    <erp-filter>
        <erp-multiple-select-filter
            class-number="4"
            :label="translation.fields.commercialGroup"
            name="commercialGroupIds"
            id="commercialGroupIds"
            :data-for-ajax="commercialGroupList"
        />

        <erp-input-filter
            class-number="col-md-4"
            :label="translation.fields.acriss"
            name="acrissName"
            id="acrissName"
        />

        <erp-select-filter
            class-number="4"
            :label="translation.fields.status"
            name="status"
            id="status"
        >
            <option value="true" v-text="translation.form.activated"></option>
            <option
                value="false"
                v-text="translation.form.deactivated"
            ></option>
        </erp-select-filter>
    </erp-filter>
</template>

<script>
import Axios from "axios";
import Loading from "../../../../assets/js/utilities";
import ErpFilter from "../../../components/filter/ErpFilter";
import ErpFilterColumn from "../../../components/filter/ErpFilterColumn";
import ErpInputFilter from "../../../components/filter/form/ErpInputFilter";
import ErpSelectFilter from "../../../components/filter/form/ErpSelectFilter";
import ErpMultipleSelectFilter from "../../../components/filter/form/ErpMultipleSelectFilter";

export default {
    name: "CommercialGroupListFilter",
    components: {
        ErpInputFilter,
        ErpFilter,
        ErpSelectFilter,
        ErpFilterColumn,
        ErpMultipleSelectFilter,
    },
    data() {
        return {
            translation: {},
            commercialGroupList: [],
        };
    },
    created() {
        this.translation = txtTrans;
    },
    async mounted() {
        Loading.starLoading();

        await Axios.get(this.routing.generate("commercialGroup.selectList"))
            .then((response) => {
                this.commercialGroupList = response.data;

                Loading.endLoading();
            })
            .catch((e) => {
                console.error(e);
                Loading.endLoading();
            });
    },
    methods: {},
};
</script>

<style scoped></style>
