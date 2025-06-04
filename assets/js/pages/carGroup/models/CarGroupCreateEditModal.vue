<template>
    <erp-modal :title="row.id ? translations.editTitle : translations.addTitle" modal-id="modal-cargroup-create" :method="'POST'"
               :url="routing.generate(row.id ? 'cargroupEdit' : 'cargroupStore')">
        <template slot="body">
            <div class="row">
                <div class="card-body">
                    <div class="form-group row">

                        <erp-input-static-filter @changeUpdateInput="onChangeValue" class-number="6" name="carGroup" :label="translations.name" :value="row.id ? row.name : ''"/>

                        <erp-select2-static-filter @changeValue="onChangeValue" class-number="6" id="acrissId" name="acrissId"
                                                   :label="translations.carClass" :select="row.id ? row.acrissId : null">
                            <option value="">{{ translations.selectAnOption }}</option>
                            <option v-for="item in acrissList" :value="item.id" v-text="item.name"
                                    :key="item.id" :selected="row.id && item.id === row.acrissId"></option>
                        </erp-select2-static-filter>

                    </div>
                </div>
            </div>
        </template>
        <template slot="footer">
            <div class="kt-align-right">
                <button type="submit" style="" id="btn-create-modal" class="btn btn-dark kt-label-bg-color-4" v-text="row.id ? translations.edit: translations.add"></button>
            </div>
        </template>
    </erp-modal>
</template>

<script>
import ErpModal from "../../../components/modal/ErpModal";
import ErpInputStaticFilter from "../../../components/filterStatic/form/ErpInputStaticFilter";
import ErpSelect2StaticFilter from "../../../components/filterStatic/form/ErpSelect2StaticFilter";


export default {
    name: "CarGroupCreateEditModal",
    components: {ErpSelect2StaticFilter, ErpInputStaticFilter, ErpModal},
    props: {
        row: Object,
        selectList: Object,
    },
    data() {
        return {
            translations: txtTrans.txtCarGroup,
            acrissList: [],
            acrissSelected: Number,
        }
    },
    mounted() {
        this.acrissList = this.selectList.acrissList;
        $('#btn-create-modal').attr("disabled","disabled");
    },
    methods: {
        onChangeValue(e){
            if(document.getElementsByName("acrissId")[0].value !== '' && document.getElementsByName("carGroup")[0].value !== '')
                $('#btn-create-modal').removeAttr("disabled","disabled");
            else
                $('#btn-create-modal').attr("disabled","disabled");

        }
    },
    watch: {
        row(){
            if (Object.keys(this.row).length === 0) {
                $('#btn-create-modal').attr("disabled","disabled");
                document.getElementsByName("acrissId")[0].value="";
                document.getElementsByName("carGroup")[0].value="";

            }else{
                $('#btn-create-modal').attr("disabled","disabled");
                this.acrissSelected=this.row.acriss.id;
            }

        }
    }
}
</script>

<style scoped>

</style>