<template>
    <div>
        <notifications position="top right"></notifications>
        <div class="col-md-12">
                <div class="kt-portlet__body">
                    <div class="kt-portlet kt-portlet--bordered">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">{{ translations.editCarGroup}}</h3>
                            </div>

                        </div>
                        <div class="kt-portlet__body">

                            <div class="form-group row">
                                    <div class="col-md-3">
                                        <erp-input-static-filter @changeUpdateInput="onChangeName" id="carGroupName" :value="carGroup.name" class-number="12" :label="translations.carGroup" />
                                    </div>

                                    <div class="col-md-3">
                                        <label><strong>{{translations.acriss }}</strong></label>
                                        <p>{{ carGroup.acrissName }}</p>
                                    </div>


                            </div>
                            <div class="kt-align-right mt-3">
                                <button @click="updateCarGroup" style="" id="btn-update" class="btn btn-dark kt-label-bg-color-4 mr-4" v-text="translations.update" />
                            </div>
                        </div>

                    </div>
                </div>
        </div>
    </div>
</template>
<script>

import Axios from "axios";
import Loading from "../../../../assets/js/utilities";
import ErpInputStaticFilter from "../../../components/filterStatic/form/ErpInputStaticFilter";
    export default {
        name: "EditCarGroupPage",
        components: {ErpInputStaticFilter},
        props:{
            carGroup: {}
        },
        data() {
            return {
                translations: txtTrans.txtCarGroup,
                carGroupName: this.carGroup.name
            }
        },
        methods: {
            onChangeName(e){
                this.carGroupName = e.target.value;
                if(this.carGroupName == ''){
                   $('#btn-update').attr('disabled', 'disabled');
                }else{
                    $('#btn-update').removeAttr('disabled');
                }
            },
            async updateCarGroup(){

                Loading.starLoading();
                let resp = await Axios.post(this.routing.generate('cargroup.update',
                    {
                        carGroupId: this.carGroup.id,
                        carGroupName:  this.carGroupName

                    }
                ));

                Loading.endLoading();

                this.showNotification(resp.data.status, resp.data.message);

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
#info-text{
    font-weight: bold;
}
/* The switch - the box around the slider */
.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
}

/* Hide default HTML checkbox */
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

/* The slider */
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: orangered;
    -webkit-transition: .4s;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked + .slider {
    background-color: #0abb87;
}

input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 24px;
}

.slider.round:before {
    border-radius: 80%;
}
</style>
