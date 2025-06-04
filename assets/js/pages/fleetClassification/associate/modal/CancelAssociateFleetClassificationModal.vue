<template>
    <erp-modal :title="translations.disassociateAcriss" modal-id="cancelAssociateFleetClassificationModal">
        <template slot="body">
            <div class="kt-portlet__head-toolbar">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>{{ translations.acriss }}</h5>
                            <p><strong>{{ row.acrissName }}</strong></p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>{{ translations.selectAcrissToDissasociate }}</h5>
                                <div v-for="acriss in acrissToDisassociate" class="col-md-12">
                                    <label class="kt-checkbox control-label">
                                        <input type="checkbox" @click="updateCheckBox" class="form-control"  name="acrissToDissasociate" :value="acriss.id.toString()" id="acrissToDissasociate"> {{ acriss.name }}
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
                <button id="cancelAssociateButton" type="submit" @click="sendData" style="" class="btn btn-dark kt-label-bg-color-4">{{translations.cancelAssociate}}</button>
            </div>
        </template>

    </erp-modal>
</template>
<script>
    import ErpModal from "../../../../components/modal/ErpModal";
    import Loading from "../../../../../assets/js/utilities";
    import Axios from "axios";

    export default {
        name: "CancelAssociateFleetClassificationModal",
        components: { ErpModal },
        props: {
            row: {},
        },
        data () {
            return {
                translations: {},
                acrissToDisassociate: [],
            }
        },
        mounted() {
            this.translations = txtTrans.txtCancelAssociateModal;
        },
        methods: {
            async sendData(e){
                e.preventDefault();
                Loading.starLoading();
                $('#cancelAssociateButton').attr('disabled', true);

                //Enviar datos formulario
                var acrissCheckboxes = document.getElementsByName('acrissToDissasociate');
                let acrissIdsToDisassociate = Array();
                for (var checkbox of acrissCheckboxes) {
                    if (checkbox.checked){
                        acrissIdsToDisassociate.push(checkbox.value);
                    }
                }
                let resp = await Axios.post(this.routing.generate('acriss.disassociate.set',
                    {
                        acrissId: this.row.id,
                        acrissToDisassociate: acrissIdsToDisassociate
                    }
                ));
                if(resp.data.response === 'ok'){
                    this.showNotification('success', this.translations.successDisssociate)
                    location.href = this.routing.generate('fleetclassification.associate.list');
                }else{
                    this.showNotification('error', this.translations.errorDisassociate);
                    $('#cancelAssociateButton').removeAttr('disabled');
                    Loading.endLoading();
                }
            },
            updateCheckBox(){
                var acrissCheckboxes = document.getElementsByName('acrissToDissasociate');

                let isChecked = false;
                for (var checkbox of acrissCheckboxes) {
                    if (checkbox.checked){
                        isChecked = true;
                    }
                }
                if(isChecked){
                    $('#cancelAssociateButton').removeAttr('disabled');
                }else{
                    $('#cancelAssociateButton').attr('disabled', true);
                }
            },
            showNotification (type = '', text = '') {
                this.$notify({
                    text,
                    type
                });
            },
        },
        watch: {
            row(){
                $('#cancelAssociateButton').attr('disabled', true);
                this.acrissToDisassociate = this.row.acrissChildList;
            }
        }
    }
</script>
<style scoped>
</style>