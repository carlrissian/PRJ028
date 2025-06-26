<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <erp-select-static @changeValue="selectBranch" :label="translations.branch" name="branch" id="branchId" class-number="4" style="display: inline-block">
                    <option value="">{{ translations.selectAnOption }}</option>
                    <option v-for="item in branchSelect" :value="item.id" v-text="item.name" :key="item.id"></option>
                </erp-select-static>
                <button type="button" style="display: inline-block" class="btn btn-primary" @click="addBranch(branchIdSelected)">{{ translations.addBranch }}</button>
                <button type="button" style="display: inline-block" class="btn btn-primary" @click="openModalCopyBranch(branchIdSelected)">{{ translations.copyBranch }}</button>

            </div>
        </div>
        <div class="kt-portlet__head">

            <div class="kt-portlet__head-toolbar">

                <ul class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
                    <li class="nav-item" v-for="(branch,index) in branchList" :id="'branchTranslations'+branch.branchId" v-model="branchList">
                        <a  class="nav-link" :class="index === 0 ? 'active' : ''" data-toggle="tab" :href="'#kt_widget_'+branch.branchId" :id="'branchLink'+branch.branchId" role="tab">
                            {{ branch.branchIATA }}
                        </a>
                        <input type="hidden" :name="'branch['+index+'][id]'" :value="branch.id">
                    </li>
                </ul>

            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="tab-content">

                <div v-if="branchList.length>0" v-for="(branch, index) in branchList" class="tab-pane" :class="index === 0 ? 'active' : ''" :id="'kt_widget_'+branch.branchId" v-model="branchList">

                    <div class="kt-align-right ml-6">
                        <button class="btn btn-primary " @click="removeBranchTranslation(index)">{{ translations.removeBranch }}</button>
                    </div>

                    <input type="hidden" :name="'branch['+index+'][id]'" v-model="branch.branchId">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label><strong>{{ translations.commercialName }}:</strong></label>
                            <erp-input-filter class-number="col-md-12" type="text" :name="'commercialName'+branch.branchId" v-model="branchList[index].commercialName"> </erp-input-filter>
                        </div>
                        <div class="col-md-8">
                            <div class="kt-checkbox-inline">
                                <label class="kt-checkbox control-label">
                                    <label><strong>{{ translations.defaultBranch }}</strong></label>
                                    <input @change="onBranchDefaultChange" class="defaultBranch" :id="'defaultBranch'+branch.branchId" :value="branch.branchId" type="checkbox" v-model="branchList[index].default" :checked="branch.default"/>
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label><strong>{{ translations.imageList }}:</strong></label>
                            <edit-acriss-image-lines :image-line-data="branch.imageLines" :branch-id="branch.branchId" />
                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label><strong>{{ translations.translationsList }}:</strong></label>
                            <edit-translations v-if="languageList.length>0" :translations-lines-data="branch.translations" :language-list="languageList" :branch-id="branch.branchId"/>
                        </div>
                    </div>
                </div>
            </div>
         </div>
         <modal-copy-branch-selector
            :branch-list="branchSelect"
            :source-branch-id="sourceBranchId"
            :onConfirm="handleCopyConfirm"
            @cancel="handleCopyCancel"
        />

    </div>
        

</template>
<script>

    import EditAcrissImageLines from "./EditAcrissImageLines";
    import EditTranslations from "./EditTranslations";
    import ErpSelectStatic from "../../../../components/filterStatic/form/ErpSelectStatic";
    import ErpInputFilter from "../../../../components/filter/form/ErpInputFilter";
    import Axios from "axios";
    import Loading from "../../../../../assets/js/utilities";
    import ModalCopyBranchSelector from "./ModalCopyBranchSelector.vue";

    export default {
        name: "EditBranchTranslations",
        components: {ErpInputFilter, ErpSelectStatic, EditAcrissImageLines, EditTranslations,ModalCopyBranchSelector},
        props:{
            branchTranslations: {},
            branchSelect: {},
        },
        data() {
            return {
                translations: txtTrans.txtAcriss,
                branchList: [],
                branchIdSelected: '',
                languageList: [],
                defaultBranchId: '',
                delegationsToCopy: [],
                sourceBranchId: null,

            }
        },
        mounted() {
            this.branchList = this.branchTranslations;

            if(this.defaultBranchId !== ''){
                for(let i=0; i<this.branchList.length; i++){
                    if(this.branchList[i].default){
                        this.defaultBranchId = this.branchList[i].id;
                        break;
                    }
                }
            }

            this.$nextTick(function (){
                this.disableCheckbox();
            });

        },
        async created() {
            let resp = await Axios.get(this.routing.generate('language.select.list'));
            this.languageList = resp.data;
        },
         methods: {
            async handleCopyConfirm(selectedBranches) {
                if (!selectedBranches?.length) {
                    return window.swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text:  this.translations.selectBranchesToCopy,
                    });
                }

                if (!this.sourceBranchId) {
                    $('#modal-copy-branch-selector').modal('hide');
                    return window.swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: this.translations.selectBranchFormCopy,
                    });
                }

                const sourceId = Number(this.sourceBranchId);
                const sourceBranch = this.branchList.find(branch => branch.branchId === sourceId);

                if (!sourceBranch) {
                    $('#modal-copy-branch-selector').modal('hide');
                    return window.swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: this.translations.branchNotFound,
                    });
                }

                const targets = selectedBranches.filter(b => b.id !== sourceId);

                const conflicts = targets.filter(target => {
                    const existing = this.branchList.find(b => b.branchId === target.id);
                    return existing && (existing.imageLines?.length || existing.translations?.length);
                });

                if (conflicts.length) {
                     await window.swal.fire({
                    icon: 'warning',
                    title: this.translations.branchAlreadyHasData,
                    html:  this.translations.confirmOverwrite,
                    showCancelButton: true,
                    confirmButtonText: this.translations.overrideAndSave,
                    cancelButtonText: this.translations.cancel,
                    confirmButtonColor: '#48465b',
                    cancelButtonColor: '#d33',
                     }).then(result => {
                         if (result.value) {
                            
                             this.copyBranchData({
                                 sourceBranch,
                                 targets,
                                 branchList: this.branchList,
                             });
                            
                        }
                    });
                        

                } else {
                    this.copyBranchData({
                        sourceBranch,
                        targets,
                        branchList: this.branchList,
                    });
                }

                
            },
            copyBranchData({ sourceBranch, targets, branchList }) {
                const success = [];
                const failed = [];

                targets.forEach(target => {
                    try {
                    const index = branchList.findIndex(branch => branch.branchId === target.id);

                    const newBranch = {
                        ...JSON.parse(JSON.stringify(sourceBranch)),
                        branchId: target.id,
                        branchIATA: target.branchIATA || '',
                        commercialName: target.commercialName || '',
                        default: false,
                        imageLines: sourceBranch.imageLines?.map((line, i) => ({
                        ...line,
                        id: '',
                        branchId: target.id,
                        index: i + 1,
                        })) || [],
                        translations: sourceBranch.translations?.map(t => ({
                        ...t,
                        id: '',
                        branchId: target.id,
                        })) || [],
                    };

                    if (index !== -1) {
                        branchList.splice(index, 1, newBranch);
                    } else {
                        branchList.push(newBranch);
                    }

                    success.push(target.branchIATA || `ID ${target.id}`);
                    } catch (e) {
                    failed.push(target.branchIATA || `ID ${target.id}`);
                    }
                });

                window.swal.fire({
                    icon: failed.length ? 'warning' : 'success',
                    title: failed.length ? this.translations.titleError : this.translations.titleSuccess,
                    text: failed.length ? this.translations.messageError : this.translations.messageSuccess,
                }).then(() => {
                    this.handleCopyCancel();
                });

                return { success, failed };
             },
            handleCopyCancel() {
                this.sourceBranchId = null;
                $('#modal-copy-branch-selector').modal('hide');
            },
            selectBranch(e){
                this.branchIdSelected = e.target.value;
            },
            addBranch(branchId){

                if(branchId == ''){
                     window.swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: this.translations.selectBranchToAdd
                    });
                    return;
                }else{

                    let branchIdExists = this.branchList.filter(function(arr){
                       return arr.branchId == branchId;
                    });
                    if(branchIdExists.length>0){
                         window.swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: this.translations.branchAlreadyExists
                        });
                    }else{
                          let branchToAdd = this.branchSelect.filter(function(arr){
                              return arr.id == branchId;
                          });

                          let branch = {};
                          branch.id = '';
                          branch.branchId = branchToAdd[0].id;
                          branch.branchIATA = branchToAdd[0].branchIATA;
                          branch.commercialName = branchToAdd[0].commercialName;
                          let imageLine = {};
                          imageLine.branchId = branch.branchId;
                          imageLine.index = 1;
                          imageLine.description = '';
                          imageLine.url = '';
                          branch.imageLines = [imageLine];
                          branch.translations = [];
                          branch.default = this.branchList.length === 0;

                          if(this.branchList.length === 0){
                                this.defaultBranchId = branch.branchId;
                          }

                          this.branchList.push(branch);

                          this.$nextTick(function () {
                              this.disableCheckbox();
                          });
                    }
                }
            },
            openModalCopyBranch(branchId) {
                if (!branchId) {
                    return window.swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: this.translations.selectBranchToCopy,
                    });
                }
                this.sourceBranchId = Number(branchId);
                this.$nextTick(() => {
                    $('#modal-copy-branch-selector').modal('show');
                });
            },
            onBranchDefaultChange(e){

                this.defaultBranchId = e.target.value;
                this.$nextTick(function () {
                    this.disableCheckbox();
                });
            },
            disableCheckbox(){

                for(let i=0; i<this.branchList.length; i++){

                    if(this.branchList[i].branchId == this.defaultBranchId){
                        this.branchList[i].default = true;
                        $('#defaultBranch'+this.defaultBranchId).checked = true;
                        $('#defaultBranch'+this.defaultBranchId).attr('disabled', 'disabled');

                    }else{
                        this.branchList[i].default = false;
                        $('#defaultBranch'+this.branchList[i].branchId).removeAttr('disabled');
                        $('#defaultBranch'+this.branchList[i].branchId).checked = false;
                    }
                }

            },
            async removeBranchTranslation(index) {

                Loading.starLoading();

                let branchToRemove = this.branchList[index];

                if (branchToRemove.default) {
                    alert(this.translations.selectAnotherDefaultBranchToDelete)
                } else {

                    if (branchToRemove.branchId !== '') {
                        if (confirm(this.translations.sureToDeleteBranch)) {

                            let resp = await Axios.post(this.routing.generate('acriss.translations.branch.delete', {id: branchToRemove.branchId}));

                            if (resp.data.status == "success") {
                                for (let i = 0; i < branchToRemove.imageLines.length; i++) {
                                    await this.removeImageLine(branchToRemove.imageLines[i].id);
                                }
                                for (let i = 0; i < branchToRemove.translations.length; i++) {
                                    await this.removeTranslation(branchToRemove.translations[i].id);
                                }
                            }
                        }
                    }
                    this.branchList = this.branchList.filter(function (arr) {
                        return arr.branchId !== branchToRemove.branchId;
                    });
                    this.$emit('onDeleteBranch', branchToRemove.branchId);

                    this.$nextTick(function () {
                        this.disableCheckbox();
                    });
                }
                Loading.endLoading();

            },
            async removeImageLine(id){
                let resp = await Axios.post(this.routing.generate('acriss.translations.imageline.delete', {id: id}));

                if(resp.data.status !== 'success'){
                    alert('Error al borrar línea de imágen '+id);
                }
            },
            async removeTranslation(id){
                let resp = await Axios.post(this.routing.generate('acriss.translations.translation.delete', {id: id}));
                if(resp.data.status !== 'success'){
                    alert('Error al borrar traduccion '+id);
                }
            }
        },

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
