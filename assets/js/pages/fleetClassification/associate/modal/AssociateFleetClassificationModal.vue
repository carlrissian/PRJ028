<template>
    <erp-modal :title="translations.associate" modal-id="associateFleetClassificationModal">
        <template slot="body">
            <div  v-if="row" class="kt-portlet__head-toolbar">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>{{ translations.acrissParent }}</h5>
                            <p><strong>{{ row.acrissName }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <h5>{{ translations.acrissChilds }}</h5>
                            <p><strong>{{ formatterAcrissChilds(row.acrissChildList) }}</strong></p>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>{{ translations.selectAcrissToDissasociate }}</h5>
                                <div v-for="acriss in acrissToAssociate" class="col-md-12">
                                    <label class="kt-checkbox control-label">
                                        <input type="checkbox" @click="updateCheckBox" class="form-control"  name="acrissToAssociate" :value="acriss.id.toString()" id="acrissToAssociate"> {{ acriss.acrissName.acriss1+acriss.acrissName.acriss2+acriss.acrissName.acriss3+acriss.acrissName.acriss4 }}
                                        <span></span>
                                    </label>
                                </div>
                                <p id="info-text"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </template>
        <template slot="footer">
            <div class="kt-align-right">
                <button id="sendButton" :disabled="true" type="submit" @click="sendData" style="" class="btn btn-dark kt-label-bg-color-4">{{translations.associate}}</button>
            </div>
        </template>
    </erp-modal>
</template>
<script>
    import ErpModal from "../../../../components/modal/ErpModal";
    import Axios from "axios";
    import Loading from "../../../../../assets/js/utilities";
    import ErpCheckboxStaticFilter from "../../../../components/filterStatic/form/ErpCheckboxStaticFilter";

    export default {
        name: "AssociateFleetClassificationModal",
        components: {ErpCheckboxStaticFilter, ErpModal },
        props: {
            row: {},
        },
        data () {
            return {
                translations: {},
                acrissToAssociate: [],
            }
        },
        mounted() {
            this.translations = txtTrans.txtAssociateModal;

        },
        methods: {
            async sendData(e){
                e.preventDefault();
                Loading.starLoading();
                $('#sendButton').attr('disabled', true);

                //Enviar datos formulario
                var acrissCheckboxes = document.getElementsByName('acrissToAssociate');
                let acrissIdsToAssociate = Array();
                for (var checkbox of acrissCheckboxes) {
                    if (checkbox.checked){
                        acrissIdsToAssociate.push(checkbox.value);
                    }
                }
                let resp = await Axios.post(this.routing.generate('acriss.associate.set',
                    {
                        acrissId: this.row.id,
                        acrissToAssociate: acrissIdsToAssociate
                    }
                ));
                if(resp.data.response === 'ok'){
                    this.showNotification('success', this.translations.successAssociate)
                    location.href = this.routing.generate('fleetclassification.associate.list');
                }else{
                    this.showNotification('error', this.translations.errorAssociate);
                    $('#sendButton').removeAttr('disabled');
                    Loading.endLoading();
                }
            },
            updateCheckBox(){
                var acrissCheckboxes = document.getElementsByName('acrissToAssociate');
                let isChecked = false;
                for (var checkbox of acrissCheckboxes) {
                    if (checkbox.checked){
                        isChecked = true;
                    }
                }
                if(isChecked){
                    $('#sendButton').removeAttr('disabled');
                }else{
                    $('#sendButton').attr('disabled', true);
                }
            },
            formatterAcrissChilds(acrissChildList){
                let acrissChildsName = '';

                if(acrissChildList){
                    for(let i=0; i< acrissChildList.length; i++){
                           acrissChildsName+= acrissChildList[i].name+ ", ";
                    }
                    if(acrissChildList.length>0){
                        acrissChildsName = acrissChildsName.slice(0, -2);
                    }
                }
                return acrissChildsName;
            },
            showNotification (type = '', text = '') {
                this.$notify({
                    text,
                    type
                });
            },
        },
        watch: {
           async row(){
               console.log(this.row);

               $('#sendButton').attr('disabled', true);
               document.getElementById("info-text").innerHTML = this.translations.searchAcrissToAssociate;
               this.acrissToAssociate = [];
               Loading.starLoading();
                //Petición para recibir acriss con 3 primeras letras de Acriss superior
                let resp = await Axios.get(this.routing.generate('acriss.associate.get',
                    {
                        acrissId: this.row.id,
                    }
                ));
                this.acrissToAssociate = resp.data.response;

                if(this.acrissToAssociate.length==0){
                    document.getElementById("info-text").innerHTML = this.translations.cantFindAcrissToAssociate;
                }else{
                    document.getElementById("info-text").innerHTML = "";
                }
               Loading.endLoading();

           }
        }
    }
</script>
<style scoped>
</style>