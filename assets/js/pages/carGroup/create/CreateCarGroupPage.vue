<template>
    <div>
        <notifications position="top right"></notifications>

        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet__body">
                    <div class="kt-portlet kt-portlet--bordered">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">{{ txtTranslations.addTitle}}</h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="row">
                                <erp-input-static-filter @changeUpdateInput="onChangeValue" class-number="4" name="carGroupName" id="carGroupName" :label="txtTranslations.name"/>

                                <erp-select2-static-filter @changeValue="onChangeValue" class-number="4" id="acrissId" name="acrissId"
                                                           :label="txtTranslations.acriss">
                                    <option value="">{{ txtTranslations.selectAnOption }}</option>
                                    <option v-for="item in acrissList" :value="item.id" v-text="item.name" :key="item.id"></option>
                                </erp-select2-static-filter>
                                <div class="col-md-12">
                                    <div class="kt-align-right">
                                        <button @click="storeCarGroup"  id="btn-create" class="btn btn-dark kt-label-bg-color-4" v-text="txtTranslations.create"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ErpSelect2StaticFilter from "../../../components/filterStatic/form/ErpSelect2StaticFilter";
import ErpInputStaticFilter from "../../../components/filterStatic/form/ErpInputStaticFilter";
import Loading from "../../../../assets/js/utilities";
import Axios from "axios";

export default {
    name: "CreateCarGroupPage",
    components: { ErpSelect2StaticFilter, ErpInputStaticFilter},
    props:{
        selectList: {},
    },
    data() {
        return {
            txtTranslations : txtTrans.txtCarGroup,
            acrissList: [],
            acrissSelected: Number,
        }
    },
    mounted() {
        this.acrissList = this.selectList.acrissList;
        $('#btn-create').attr("disabled","disabled");

    },
    methods: {
        onChangeValue(e){
            if(document.getElementsByName("acrissId")[0].value !== '' && document.getElementsByName("carGroupName")[0].value !== '')
                $('#btn-create').removeAttr("disabled","disabled");
            else
                $('#btn-create').attr("disabled","disabled");

        },
        async storeCarGroup(){

            Loading.starLoading();
            let resp = await Axios.post(this.routing.generate('cargroup.store',
                {
                    acrissId: $('#acrissId').val(),
                    carGroupName: $('#carGroupName').val()
                }
            ));

            Loading.endLoading();

            this.showNotification(resp.data.status, resp.data.message);

            if(resp.data.status === 'success'){
                location.href = this.routing.generate('cargroup.list');
            }

        },
        showNotification (type = '', text = '') {
            this.$notify({
                text,
                type
            });
        }
    }
}
</script>

<style scoped>
td a{
    display: inline;
}
</style>