<template>
    <erp-filter>
        <erp-input-filter class-number="col-md-4" name="id" id="codeId" :label="translations.fields.code" />
        <erp-input-filter class-number="col-md-4" name="name" id="nameId" :label="translations.fields.name" />
        <erp-input-filter class-number="col-md-4" name="vatNumber" id="vatNumberId" :label="translations.fields.cif" />
        <!-- FIXME aquí debería de haber un filtro de país para filtrado local de provincicas -->
        <erp-select-filter class-number="4" name="province" id="provinceId" :label="translations.fields.state">
            <option v-for="item in provinces" :value="item.ID" v-text="item.STATENAME" :key="item.id"></option>
        </erp-select-filter>
    </erp-filter>
</template>

<script>
import ErpFilter from "../../components/filter/ErpFilter";
import ErpInputFilter from "../../components/filter/form/ErpInputFilter";
import Axios from "axios";
import ErpSelectFilter from "../../components/filter/form/ErpSelectFilter";

export default {
    name: "SupplierListFilter",
    components: {
        ErpSelectFilter,
        ErpInputFilter,
        ErpFilter,
    },
    data() {
        return {
            translations: {},
            provinces: [],
            cities: [],
        };
    },
    created() {
        this.translations = txtTrans;
    },
    async mounted() {
        await Axios.get(this.routing.generate("supplier.selectors"))
            .then((response) => {
                this.provinces = response.data.provinces;
                this.cities = response.data.cities;
            })
            .catch((e) => {
                console.error(e);
            });
    },
};
</script>

<style scoped></style>
