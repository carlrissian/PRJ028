<template>
    <erp-filter>
        <erp-multiple-select-filter class-number="4" :label="translation.carGroup"  name="carGroupId" id="carGroupId" :data-for-ajax="carGroupList" />
        <erp-input-filter :label="translation.acriss" name="acrissName" id="acrissName" />

          <erp-select-filter class-number="4" :label="translation.status" name="status" id="status">
            <option value="true" v-text="translation.activate"></option>
            <option value="false" v-text="translation.deactivate"></option>
          </erp-select-filter>

    </erp-filter>
</template>

<script>
    import ErpFilterColumn from "../../../components/filter/ErpFilterColumn";
    import Loading from "../../../../assets/js/utilities";
    import Axios from "axios";
    import ErpSelectFilter from "../../../components/filter/form/ErpSelectFilter";
    import ErpMultipleSelectFilter from "../../../components/filter/form/ErpMultipleSelectFilter";
    import ErpFilter from "../../../components/filter/ErpFilter";
    import ErpInputFilter from "../../../components/filter/form/ErpInputFilter";

    export default {
        name: "CarGroupListFilter",
        components: {ErpInputFilter, ErpFilter, ErpSelectFilter, ErpFilterColumn, ErpMultipleSelectFilter },
        data() {
          return{
              translation: {},
              carGroupList: [],
          }
        },
        async mounted() {
            this.translation = txtTrans.txtFilter;
            Loading.starLoading();
            try {
                let resp = await Axios.get(this.routing.generate('cargroup.selectList'));
                this.carGroupList = resp.data;

                Loading.endLoading();
            } catch (e) {
                Loading.endLoading();
                console.error(e);
            }

        }
    }
</script>

<style scoped>

</style>