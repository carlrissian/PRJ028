<template>
    <fragment>
        <h5 class="mb-5" v-text="txt.titles.translations"></h5>

        <div class="row flex-nowrap align-items-end mb-3">
            <single-select-picker
                @updatedSelectPicker="selectedBranch = $event"
                name="branchList"
                id="branchList"
                divClass="col-lg-3 col-md-6 col-sm-10"
                :label="txt.fields.branch"
                :placeholder="txt.form.selectAnOption"
                :value="selectedBranch"
                :url="routing.generate('branch.selectList')"
                returnObject
            />
            <div class="d-flex ">
                <button
                    @click="addTab"
                    type="button"
                    class="btn btn-icon btn-dark kt-label-bg-color-4"
                    :title="txt.form.addBranch"
                    :disabled="!selectedBranch"
                >
                    <i class="la la-plus"></i>
                </button>

                <button
                    @click="openModalCopyBranch"
                    type="button"
                    class="btn btn-icon btn-dark kt-label-bg-color-4 ml-2"
                    :title="txt.form.copyBranch"
                    :disabled="!selectedBranch"
                >
                    <i class="la la-copy"></i>
                </button>
            </div>
        </div>

        <div id="branchTranslationsList" class="d-flex flex-column">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-toolbar">
                    <ul class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
                        <li
                            v-for="(translation, index) in branchTranslations"
                            :id="`branchTranslations${translation.branch.id}`"
                            class="nav-item"
                            :key="index"
                        >
                            <a
                                :id="`branchLink${translation.branch.id}`"
                                class="nav-link"
                                :class="{ active: index === 0 }"
                                role="tab"
                                data-toggle="tab"
                                :href="`#kt_widget_${translation.branch.id}`"
                                :title="translation.branch.name"
                                v-text="translation.branch.branchIATA"
                            >
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="kt-portlet__body">
                <div class="tab-content">
                    <div
                        v-for="(translation, index) in branchTranslations"
                        :id="`kt_widget_${translation.branch.id}`"
                        class="tab-pane"
                        :class="{ active: index === 0 }"
                        :key="index"
                    >
                        <!-- Remove button -->
                        <!-- TODO V1.2 de momento se deshabilita para que el usuario no borre registros de BBDD -->
                        <div class="row col-md-12 justify-content-end mb-3">
                            <button
                                @click="removeTab(index)"
                                type="button"
                                class="btn btn-icon btn-dark kt-label-bg-color-4"
                                :title="txt.form.removeBranch"
                                :disabled="translation.hasOwnProperty('id')"
                            >
                                <i class="la la-trash"></i>
                            </button>
                        </div>
                        <!--  -->

                        <!-- Main data -->
                        <div class="row align-items-center">
                            <input-base
                                @updatedInput="translation.branch.name = $event"
                                :name="`branchName${index}`"
                                :id="`branchName${index}`"
                                divClass="form-group col-md-3"
                                :label="txt.fields.branchCommercialName"
                                :value="translation.branch.name"
                                required
                            />

                            <check-box
                                @updatedCheckBox="onChangeDefaultBranch(index, $event)"
                                :name="`branchByDefault${index}`"
                                :id="`branchByDefault${index}`"
                                divClass="form-group col-md-3"
                                :label="txt.fields.defaultBranch"
                                :value="translation.byDefault"
                                :checked="translation.byDefault"
                            />
                        </div>
                        <!--  -->

                        <div class="row">
                            <!-- Image list -->
                            <div class="col-lg-6 col-md-12 form-group">
                                <div class=" d-flex flex-column align-items-start mb-3">
                                    <label class="control-label font-weight-bold" v-text="txt.titles.imageList"></label>

                                    <button
                                        @click="addImageLine(index)"
                                        type="button"
                                        class="btn btn-dark kt-label-bg-color-4"
                                        :title="txt.form.addImageLine"
                                    >
                                        <i class="la la-plus"></i>
                                        {{ txt.form.addImageLine }}
                                    </button>
                                </div>

                                <div v-if="translation.imageLines.length > 0" class="kt-section d-flex flex-column">
                                    <!-- 
                                        FIXME vue-sortable-list no está funcionando porque el evento DOMNodeInserted está deprecated.
                                        La IA recomienda cambiar el evento por un MutationObserver. ¿Fork al repo y modificar su uso?
                                     -->
                                    <ul v-draggable="{ value: translation.imageLines, handle: 'handleImageLine' }" id="imageList">
                                        <li v-for="(imageLine, index) in translation.imageLines" :key="index" class="my-2">
                                            <div class="d-flex align-items-center justify-content-between list-group-item">
                                                <span
                                                    class="bullet bullet-bar bg-dark-gray flaticon2-setup handleImageLine"
                                                ></span>

                                                <input-base
                                                    @updatedInput="
                                                        (imageLine.url = $event),
                                                            (imageLine.viewImage = isValidURL($event)
                                                                ? imageLine.viewImage
                                                                : false)
                                                    "
                                                    :name="`imageLineURL${index}`"
                                                    :id="`imageLineURL${index}`"
                                                    divClass="col-md-5"
                                                    :placeholder="txt.fields.url"
                                                    :value="imageLine.url"
                                                    required
                                                    input-group
                                                >
                                                    <template #apend>
                                                        <button
                                                            type="button"
                                                            @click="imageLine.viewImage = !imageLine.viewImage"
                                                            class="btn btn-icon"
                                                            :title="txt.form.viewImage"
                                                            :disabled="!isValidURL(imageLine.url)"
                                                        >
                                                            <i class="flaticon-eye"></i>
                                                        </button>
                                                    </template>
                                                </input-base>

                                                <input-base
                                                    @updatedInput="imageLine.description = $event"
                                                    :name="`imageLineDescription${index}`"
                                                    :id="`imageLineDescription${index}`"
                                                    divClass="col-md-5"
                                                    :placeholder="txt.fields.description"
                                                    :value="imageLine.description"
                                                    required
                                                />

                                                <!-- TODO V1.2 de momento se deshabilita para que el usuario no borre registros de BBDD -->
                                                <button
                                                    type="button"
                                                    @click="removeImageLine(translation.branch.id, index)"
                                                    class="btn btn-icon"
                                                    :title="txt.form.removeImageLine"
                                                    :disabled="imageLine.hasOwnProperty('id')"
                                                >
                                                    <i class="fa fa-times btn-outline-hover-danger"></i>
                                                </button>
                                            </div>
                                            <div v-if="imageLine.viewImage">
                                                <img :src="imageLine.url" alt="Image" class="img-fluid" />
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--  -->

                            <!-- Translations list -->
                            <div class="col-lg-6 col-md-12 form-group">
                                <div class=" d-flex flex-column align-items-start mb-3">
                                    <label class="control-label font-weight-bold" v-text="txt.titles.translationList"></label>

                                    <div class="d-flex flex-nowrap align-items-end w-100 mb-3">
                                        <single-select-picker
                                            @updatedSelectPicker="translation.selectedLanguage = $event"
                                            :name="`languageList${index}`"
                                            :id="`languageList${index}`"
                                            divClass="col-md-6 col-sm-10"
                                            :label="txt.fields.language"
                                            :placeholder="txt.form.selectAnOption"
                                            :value="translation.selectedLanguage"
                                            :options="languageList"
                                            returnObject
                                        />
                                        <button
                                            @click="addLanguage(translation.branch.id, translation.selectedLanguage, index)"
                                            type="button"
                                            class="btn btn-icon btn-dark kt-label-bg-color-4"
                                            :title="txt.form.addLanguage"
                                            :disabled="!translation.selectedLanguage"
                                        >
                                            <i class="la la-plus"></i>
                                        </button>
                                    </div>

                                    <div v-if="translation.translations.length > 0" class="kt-section d-flex flex-column w-100">
                                        <label class="control-label font-weight-bold" v-text="txt.fields.defaultLanguage"></label>
                                        <div
                                            v-for="(trans, index) in translation.translations"
                                            class="d-flex flex-nowrap align-items-center my-2"
                                            :key="index"
                                        >
                                            <check-box
                                                @updatedCheckBox="onChangeDefaultLanguage(translation.branch.id, index, $event)"
                                                :name="`languageByDefault${index}`"
                                                :id="`languageByDefault${index}`"
                                                divClass="col-md-1"
                                                :value="trans.byDefault"
                                                :checked="trans.byDefault"
                                            />

                                            <span
                                                class="font-weight-bold text-uppercase"
                                                style="min-width: 2rem;"
                                                v-text="trans.language.code"
                                            ></span>

                                            <input-base
                                                @updatedInput="trans.name = $event"
                                                :name="`languageName${index}`"
                                                :id="`languageName${index}`"
                                                divClass="col-md-6"
                                                :placeholder="txt.fields.translation"
                                                :value="trans.name"
                                                required
                                            />

                                            <!-- TODO V1.2 de momento se deshabilita para que el usuario no borre registros de BBDD -->
                                            <button
                                                type="button"
                                                @click="removeLanguage(translation.branch.id, index)"
                                                class="btn btn-icon"
                                                :title="txt.form.removeLanguage"
                                                :disabled="trans.hasOwnProperty('id')"
                                            >
                                                <i class="fa fa-times btn-outline-hover-danger"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal-copy-branch-selector
            v-if="showModalCopyBranchSelector"
            :onConfirm="handleCopyConfirm"
            @cancel="handleCopyCancel"
        />
    </fragment>
</template>

<script>
import Loading from "../../../../assets/js/utilities";
import { isValidURL } from "../../../../SharedAssets/js/utils";

import CheckBox from "../../../../SharedAssets/vue/components/base/inputs/CheckBox.vue";
import InputBase from "../../../../SharedAssets/vue/components/base/inputs/InputBase.vue";
import SingleSelectPicker from "../../../../SharedAssets/vue/components/base/inputs/SingleSelectPicker.vue";
import ModalCopyBranchSelector from "../components/ModalCopyBranchSelector.vue";

export default {
    name: "AcrissBranchTranslationsForm",
    components: {
        CheckBox,
        InputBase,
        SingleSelectPicker,
        ModalCopyBranchSelector,
    },
    props: {
        translations: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            txt: {},
            constants,
            isValidURL,

            branchTranslations: [],
            selectedBranch: null,
            languageList: [],
            showModalCopyBranchSelector: false,
        };
    },
    created() {
        this.txt = txtTrans;
    },
    mounted() {
        this.loadLanguageList();
        this.loadBranchTranslations();
    },
    methods: {
        loadLanguageList: async function() {
            await this.axios
                .get(this.routing.generate("language.selectList"))
                .then((response) => {
                    this.languageList = response.data;
                })
                .catch((error) => {
                    console.log(error.response);
                    this.$notify({
                        type: "error",
                        text: this.txt.form.errorLoadingLanguages,
                    });
                });
        },
        loadBranchTranslations: function() {
            this.translations.forEach((translation) => {
                this.branchTranslations.push({
                    id: translation.id,
                    branch: translation.branch,
                    byDefault: translation.byDefault,
                    imageLines: translation.acrissImageLines,
                    translations: translation.acrissTranslations,
                    selectedLanguage: null,
                });
            });
        },
        addTab() {
            if (this.branchTranslations.some((translation) => translation.branch.id === this.selectedBranch.id)) {
                this.$notify({
                    type: "warn",
                    text: this.txt.form.branchAlreadyAdded,
                });
                return;
            }
            this.branchTranslations.push({
                branch: this.selectedBranch,
                byDefault: false,
                imageLines: [],
                translations: [],
                selectedLanguage: null,
            });
            this.selectedBranch = null;
        },
        removeTab: async function(index) {
            const branchToRemove = this.branchTranslations[index];

            if (branchToRemove.byDefault) {
                this.$notify({
                    type: "warn",
                    text: this.txt.form.cannotRemoveDefaultBranch,
                });
                return;
            }

            // if (this.translations.length > 0) {
            if (branchToRemove.hasOwnProperty("id")) {
                window.swal
                    .fire({
                        title: this.txt.form.removeBranch,
                        text: this.txt.form.removeBranchQuestion,
                        type: "warning",
                        confirmButtonText: this.txt.form.continue,
                        confirmButtonColor: "#5867dd",
                        showCancelButton: true,
                        cancelButtonText: this.txt.form.cancel,
                        cancelButtonColor: "#d33",
                    })
                    .then(async (result) => {
                        if (result.value) {
                            Loading.starLoading();
                            await this.axios
                                .post(this.routing.generate("acriss.translations.branch.delete", { id: branchToRemove.id }))
                                .then((response) => {
                                    if (response.data.success) {
                                        this.$notify({
                                            type: "success",
                                            text: this.txt.form.branchRemovedSuccessNotification,
                                        });
                                        this.branchTranslations.splice(index, 1);
                                    }
                                })
                                .catch((error) => {
                                    console.log(error.response);
                                    let errorMessage = this.txt.form.errorRemovingBranchNotification;
                                    if (error.response.status === 460) {
                                        errorMessage += error.response.data.message;
                                    }
                                    this.$notify({
                                        type: "error",
                                        text: errorMessage,
                                    });
                                });
                            Loading.endLoading();
                        }
                    });
            } else {
                this.branchTranslations.splice(index, 1);
            }
        },
        onChangeDefaultBranch(index, value) {
            this.branchTranslations.forEach((translation, i) => {
                if (value === true) {
                    translation.byDefault = index !== i ? false : value;
                } else {
                    translation.byDefault = value;
                }
            });
        },
        addImageLine(index) {
            this.branchTranslations[index].imageLines.push({
                // id: this.branchTranslations[index].imageLines.length + 1,
                url: null,
                description: null,
                byDefault: false,
                viewImage: false,
            });
        },
        removeImageLine(branchId, index) {
            const imageLineToRemove = this.branchTranslations.find((translation) => translation.branch.id === branchId)
                .imageLines[index];

            if (imageLineToRemove.byDefault) {
                this.$notify({
                    type: "warn",
                    text: this.txt.form.cannotRemoveDefaultImageLine,
                });
                return;
            }

            if (imageLineToRemove.hasOwnProperty("id")) {
                window.swal
                    .fire({
                        title: this.txt.form.removeImageLine,
                        text: this.txt.form.removeImageLineQuestion,
                        type: "warning",
                        confirmButtonText: this.txt.form.continue,
                        confirmButtonColor: "#5867dd",
                        showCancelButton: true,
                        cancelButtonText: this.txt.form.cancel,
                        cancelButtonColor: "#d33",
                    })
                    .then(async (result) => {
                        if (result.value) {
                            Loading.starLoading();
                            await this.axios
                                .post(this.routing.generate("acriss.translations.imageline.delete", { id: imageLineToRemove.id }))
                                .then((response) => {
                                    if (response.data.success) {
                                        this.$notify({
                                            type: "success",
                                            text: this.txt.form.imageLineRemovedSuccessNotification,
                                        });
                                        this.branchTranslations
                                            .find((translation) => translation.branch.id === branchId)
                                            .imageLines.splice(index, 1);
                                    }
                                })
                                .catch((error) => {
                                    console.log(error.response);
                                    let errorMessage = this.txt.form.errorRemovingImageLineNotification;
                                    if (error.response.status === 460) {
                                        errorMessage += error.response.data.message;
                                    }
                                    this.$notify({
                                        type: "error",
                                        text: errorMessage,
                                    });
                                });
                            Loading.endLoading();
                        }
                    });
            } else {
                this.branchTranslations.find((translation) => translation.branch.id === branchId).imageLines.splice(index, 1);
            }
        },
        addLanguage(branchId, language, index) {
            const tranlations = this.branchTranslations.find((translation) => translation.branch.id === branchId).translations;
            if (tranlations.some((translation) => translation.language.id === language.id)) {
                this.$notify({
                    type: "warn",
                    text: this.txt.form.languageAlreadyAdded,
                });
                return;
            }
            tranlations.push({ language: language, name: null, byDefault: false });
            this.branchTranslations.find((translation) => translation.branch.id === branchId).selectedLanguage = null;
        },
        removeLanguage(branchId, index) {
            const languageToRemove = this.branchTranslations.find((translation) => translation.branch.id === branchId)
                .translations[index];

            if (languageToRemove.byDefault) {
                this.$notify({
                    type: "warn",
                    text: this.txt.form.cannotRemoveDefaultLanguage,
                });
                return;
            }

            if (languageToRemove.hasOwnProperty("id")) {
                window.swal
                    .fire({
                        title: this.txt.form.removeLanguage,
                        text: this.txt.form.removeLanguageQuestion,
                        type: "warning",
                        confirmButtonText: this.txt.form.continue,
                        confirmButtonColor: "#5867dd",
                        showCancelButton: true,
                        cancelButtonText: this.txt.form.cancel,
                        cancelButtonColor: "#d33",
                    })
                    .then(async (result) => {
                        if (result.value) {
                            Loading.starLoading();
                            await this.axios
                                .post(
                                    this.routing.generate("acriss.translations.translation.delete", { id: languageToRemove.id })
                                )
                                .then((response) => {
                                    if (response.data.success) {
                                        this.$notify({
                                            type: "success",
                                            text: this.txt.form.languageRemovedSuccessNotification,
                                        });
                                        this.branchTranslations
                                            .find((translation) => translation.branch.id === branchId)
                                            .translations.splice(index, 1);
                                    }
                                })
                                .catch((error) => {
                                    console.log(error.response);
                                    let errorMessage = this.txt.form.errorRemovingLanguageNotification;
                                    if (error.response.status === 460) {
                                        errorMessage += error.response.data.message;
                                    }
                                    this.$notify({
                                        type: "error",
                                        text: errorMessage,
                                    });
                                });
                            Loading.endLoading();
                        }
                    });
            } else {
                this.branchTranslations.find((translation) => translation.branch.id === branchId).translations.splice(index, 1);
            }
        },
        onChangeDefaultLanguage(branchId, index, value) {
            this.branchTranslations
                .find((translation) => translation.branch.id === branchId)
                .translations.forEach((translation, i) => {
                    if (value === true) {
                        translation.byDefault = index !== i ? false : value;
                    } else {
                        translation.byDefault = value;
                    }
                });
        },
        openModalCopyBranch() {
            
            if (!this.selectedBranch) {
                return window.swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: this.txt.form.selectBranchToCopy,
                });
            }
            this.showModalCopyBranchSelector = true;
            this.$nextTick(() => {
                $('#modal-copy-branch-selector').modal('show');
            });
           
        },
        async handleCopyConfirm(branches) {
            if (!branches?.length) {
                return window.swal.fire({
                icon: 'error',
                title: 'Error',
                text:  this.txt.form.selectBranchesToCopy,
                });
            }

            if (!this.selectedBranch) {
                $('#modal-copy-branch-selector').modal('hide');
                return window.swal.fire({
                icon: 'error',
                title: 'Error',
                text: this.txt.form.selectBranchFormCopy,
                });
            }

            const targets = branches.filter(b => b.id !== this.selectedBranch.id);

            const conflicts = targets.filter(target => {
                const existing = this.branchTranslations.find(b => b.branch.id === target.id);
                return existing && (existing.imageLines?.length || existing.translations?.length);
            });

           

            if (conflicts.length) {
                await window.swal.fire({
                    icon: 'warning',
                    title:  this.txt.form.branchAlreadyHasData,
                    html:  this.txt.form.confirmOverwrite,
                    showCancelButton: true,
                    confirmButtonText: this.txt.form.overrideAndSave,
                    cancelButtonText: this.txt.form.cancel,
                    confirmButtonColor: '#48465b',
                    cancelButtonColor: '#d33',
                        }).then(result => {
                            if (result.value) {
                            
                                this.copyBranchData({
                                    sourceBranch: this.selectedBranch,
                                    targets,
                                });
                            
                        }
                });
                    

            } else {
                this.copyBranchData({
                    sourceBranch: this.selectedBranch,
                    targets,
                });
            }

            
        },
        copyBranchData({ sourceBranch, targets }) {
                const success = [];
                const failed = [];
                const originalBranch = this.branchTranslations.find(
                            item => Number(item.branch?.id) === Number(sourceBranch.id)
                );

                if (!originalBranch) {
                    return window.swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: this.txt.form.sourceBranchNotFound,
                    });
                }
                
                targets.forEach(target => {
                    try {
                          
                        const newBranch = {
                            branch: target,
                            byDefault: false,
                            selectedLanguage: originalBranch.selectedLanguage || null,
                            imageLines: originalBranch.imageLines || [],
                            translations: originalBranch.translations || []
                        };

                        // Aseguramos que ambos valores sean números para evitar errores de comparación
                        const index = this.branchTranslations.findIndex(
                            item => Number(item.branch?.id) === Number(target.id)
                        );
                        if (index !== -1) {
                            this.branchTranslations.splice(index, 1, newBranch); // reemplazar
                        } else {
                            this.branchTranslations.push(newBranch); // agregar nuevo
                        }

                        success.push(target.branchIATA || `ID ${target.id}`);
                    } catch (e) {
                        failed.push(target.branchIATA || `ID ${target.id}`);
                    }
                });

                window.swal.fire({
                    icon: failed.length ? 'warning' : 'success',
                    title: failed.length ? this.txt.form.titleError : this.txt.form.titleSuccess,
                    text: failed.length ? this.txt.form.messageError : this.txt.form.messageSuccess,
                }).then(() => {
                    this.handleCopyCancel();
                });

                return { success, failed };
            },

            handleCopyCancel() {
                this.selectedBranch = null;
                this.showModalCopyBranchSelector = false;
                $('#modal-copy-branch-selector').modal('hide');
            },
    },
};
</script>

<style scoped>
.nav-pills.nav-pills-label .nav-item .nav-link:active,
.nav-pills.nav-pills-label .nav-item .nav-link.active,
.nav-pills.nav-pills-label .nav-item .nav-link.active:hover {
    background-color: rgba(207, 45, 48, 0.1);
    color: #cf2d30;
}

ul#imageList {
    list-style: none;
    margin: 0;
    padding: 0;
    cursor: pointer;
}

ul#imageList li {
    border: 1px solid #e2e5ec;
}
</style>
