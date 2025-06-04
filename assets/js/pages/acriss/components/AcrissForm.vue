<template>
    <fragment>
        <form @submit.prevent="submitAcriss" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
                    <div class="kt-portlet kt-portlet--bordered">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title" v-text="title"></h3>
                            </div>
                        </div>

                        <div class="kt-portlet__body">
                            <div class="acriss-letters">
                                <!-- ACRISS letters -->
                                <div class="group row mb-3">
                                    <div class="col-md-3">
                                        <h6 v-text="`${txt.fields.first} ${txt.fields.acrissLetter}`"></h6>
                                        <p v-text="formatAcrissField('carClass')"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="`${txt.fields.second} ${txt.fields.acrissLetter}`"></h6>
                                        <p v-text="formatAcrissField('vehicleType')"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="`${txt.fields.third} ${txt.fields.acrissLetter}`"></h6>
                                        <p v-text="formatAcrissField('gearBox')"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="`${txt.fields.fourth} ${txt.fields.acrissLetter}`"></h6>
                                        <p v-text="formatAcrissField('motorizationType')"></p>
                                    </div>
                                </div>
                                <!--  -->

                                <!-- ACRISS letters selectors -->
                                <div class="row">
                                    <single-select-picker
                                        @updatedSelectPicker="acriss.carClass = $event"
                                        @onBlurSelectPicker="checkAcrissLetters"
                                        name="carClass"
                                        id="carClass"
                                        divClass="form-group col-md-3"
                                        :label="txt.fields.carClass"
                                        :placeholder="txt.form.selectAnOption"
                                        :value="acriss.carClass"
                                        :url="routing.generate('carClass.selectList')"
                                        required
                                        :disabled="acrissCreated"
                                        returnObject
                                    />

                                    <single-select-picker
                                        @updatedSelectPicker="acriss.vehicleType = $event"
                                        @onBlurSelectPicker="checkAcrissLetters"
                                        name="vehicleType"
                                        id="vehicleType"
                                        divClass="form-group col-md-3"
                                        :label="txt.fields.vehicleType"
                                        :placeholder="txt.form.selectAnOption"
                                        :value="acriss.vehicleType"
                                        :url="routing.generate('acrissType.selectList')"
                                        required
                                        :disabled="acrissCreated"
                                        returnObject
                                    />

                                    <single-select-picker
                                        @updatedSelectPicker="acriss.gearBox = $event"
                                        @onBlurSelectPicker="checkAcrissLetters"
                                        name="gearBox"
                                        id="gearBox"
                                        divClass="form-group col-md-3"
                                        :label="txt.fields.gearBox"
                                        :placeholder="txt.form.selectAnOption"
                                        :value="acriss.gearBox"
                                        :url="routing.generate('gearBox.selectList')"
                                        required
                                        :disabled="acrissCreated"
                                        returnObject
                                    />

                                    <single-select-picker
                                        @updatedSelectPicker="acriss.motorizationType = $event"
                                        @onBlurSelectPicker="checkAcrissLetters"
                                        name="motorizationType"
                                        id="motorizationType"
                                        divClass="form-group col-md-3"
                                        :label="txt.fields.motorizationType"
                                        :placeholder="txt.form.selectAnOption"
                                        :value="acriss.motorizationType"
                                        :url="routing.generate('motorizationType.selectList')"
                                        required
                                        :disabled="acrissCreated"
                                        returnObject
                                    />
                                </div>
                                <!--  -->
                            </div>

                            <alert v-show="acrissExists" type="danger">
                                <template #text>
                                    <p v-text="txt.form.errorAcrissAlreadyExists" style="margin: 0"></p>
                                </template>
                            </alert>

                            <div class="border-bottom mt-3 mb-5" />

                            <!-- Vehicle fields -->
                            <h5 class="mb-5" v-text="txt.titles.vehicleFields"></h5>

                            <div class="row">
                                <date-picker
                                    @updatedDatePicker="acriss.marketingStartDate = $event"
                                    name="marketingStartDate"
                                    id="marketingStartDate"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.marketingStartDate"
                                    :placeholder="txt.fields.marketingStartDate"
                                    :value="acriss.marketingStartDate"
                                    :limit-end-day="acriss.marketingEndDate"
                                />

                                <date-picker
                                    @updatedDatePicker="acriss.marketingEndDate = $event"
                                    name="marketingEndDate"
                                    id="marketingEndDate"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.marketingEndDate"
                                    :placeholder="txt.fields.marketingEndDate"
                                    :value="acriss.marketingEndDate"
                                    :limit-start-day="acriss.marketingStartDate"
                                />

                                <check-box
                                    @updatedCheckBox="acriss.commercialVehicle = $event"
                                    name="commercialVehicle"
                                    id="commercialVehicle"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.commercialVehicle"
                                    :value="acriss.commercialVehicle"
                                />

                                <check-box
                                    @updatedCheckBox="acriss.mediumTerm = $event"
                                    name="mediumTerm"
                                    id="mediumTerm"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.mediumTerm"
                                    :value="acriss.mediumTerm"
                                />
                            </div>

                            <div class="row">
                                <input-number
                                    @updatedInputNumber="acriss.numberOfSuitcases = $event"
                                    name="numberOfSuitcases"
                                    id="numberOfSuitcases"
                                    divClass="form-group col-md-3"
                                    :min="1"
                                    :step="1"
                                    :label="txt.fields.numberOfSuitcases"
                                    :value="acriss.numberOfSuitcases"
                                />

                                <input-number
                                    @updatedInputNumber="acriss.numberOfSeats = $event"
                                    name="numberOfSeats"
                                    id="numberOfSeats"
                                    divClass="form-group col-md-3"
                                    :min="1"
                                    :step="1"
                                    :label="txt.fields.numberOfSeats"
                                    :value="acriss.numberOfSeats"
                                />

                                <input-number
                                    @updatedInputNumber="acriss.numberOfDoors = $event"
                                    name="numberOfDoors"
                                    id="numberOfDoors"
                                    divClass="form-group col-md-3"
                                    :min="1"
                                    :step="1"
                                    :label="txt.fields.numberOfDoors"
                                    :value="acriss.numberOfDoors"
                                />
                            </div>

                            <div class="border-bottom mt-3 mb-5" />

                            <!-- Pernmission fields -->
                            <h5 class="mb-5" v-text="txt.titles.permissionFields"></h5>

                            <div class="row">
                                <input-number
                                    @updatedInputNumber="acriss.minAge = $event"
                                    name="minAge"
                                    id="minAge"
                                    divClass="form-group col-md-3"
                                    :min="1"
                                    :max="acriss.maxAge ? parseInt(acriss.maxAge) : undefined"
                                    :step="1"
                                    :label="txt.fields.minAge"
                                    :value="acriss.minAge"
                                    input-group
                                />

                                <input-number
                                    @updatedInputNumber="acriss.maxAge = $event"
                                    name="maxAge"
                                    id="maxAge"
                                    divClass="form-group col-md-3"
                                    :min="acriss.minAge ? parseInt(acriss.minAge) : 1"
                                    :step="1"
                                    :label="txt.fields.maxAge"
                                    :value="acriss.maxAge"
                                />

                                <multiple-select-picker
                                    @updatedMultipleSelectPicker="
                                        acriss.driverLicenseIds = $event;
                                        onChangeDriverlLicenses($event);
                                    "
                                    name="driverLicenseIds"
                                    id="driverLicenseIds"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.driverLicense"
                                    :placeholder="txt.form.selectAnOption"
                                    :value="acriss.driverLicenseIds"
                                    :options="driverLicenseList"
                                />
                            </div>

                            <div v-if="acriss.driverLicenseIds && acriss.driverLicenseIds.length > 0" class="row">
                                <input-number
                                    @updatedInputNumber="acriss[`minAgeDL${capitalize(dl, false)}`] = $event"
                                    v-for="dl in acriss.driverLicenseIds"
                                    :key="dl"
                                    :name="`minAgeDL${capitalize(dl, false)}`"
                                    :id="`minAgeDL${capitalize(dl, false)}`"
                                    divClass="form-group col-md-3"
                                    :min="
                                        ['', null, undefined].includes(acriss[`minAgeDL${capitalize(dl, false)}`]) ? 1 : undefined
                                    "
                                    :step="1"
                                    :label="`${txt.fields.minDriverLicenseX} ${txt.fields[dl]}`"
                                    :value="acriss[`minAgeDL${capitalize(dl, false)}`]"
                                />
                            </div>

                            <div v-if="action === EDIT_ACTION">
                                <div class="border-bottom mt-3 mb-5" />

                                <acriss-branch-translations-form
                                    ref="branchTranslationsForm"
                                    :translations="acrissData.branchTranslations"
                                />
                            </div>
                        </div>

                        <div class="kt-portlet__foot">
                            <div class="kt-align-right">
                                <button type="submit" class="btn btn-dark kt-label-bg-color-4" :disabled="canCreateAcriss">
                                    <i :class="`la ${submitButtonIcon}`"></i>
                                    {{ submitButtonText }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- <associate-acriss-modal-form v-if="associateAcriss" :acriss="acriss" :association-type="associationType" /> -->
    </fragment>
</template>

<script>
export const CREATE_ACTION = "create";
export const EDIT_ACTION = "edit";
export const SHOW_ACTION = "show";

import Loading from "../../../../assets/js/utilities";
import Formatter from "../../../../SharedAssets/js/formatter";
import { capitalize } from "../../../../SharedAssets/js/utils";

import Alert from "../../../../SharedAssets/vue/components/Alert.vue";
import CheckBox from "../../../../SharedAssets/vue/components/base/inputs/CheckBox.vue";
import DatePicker from "../../../../SharedAssets/vue/components/base/inputs/DatePicker.vue";
import InputNumber from "../../../../SharedAssets/vue/components/base/inputs/InputNumber.vue";
import MultipleSelectPicker from "../../../../SharedAssets/vue/components/base/inputs/MultipleSelectPicker.vue";
import SingleSelectPicker from "../../../../SharedAssets/vue/components/base/inputs/SingleSelectPicker.vue";

import AcrissBranchTranslationsForm from "./AcrissBranchTranslationsForm.vue";
// TODO V2: Implementar lógica para asociar acriss (superior o inferior)
// import AssociateAcrissModalForm from "./AssociateAcrissModalForm.vue";
// import { SUPERIOR, INFERIOR } from "./AssociateAcrissModalForm.vue";

export default {
    name: "AcrissForm",
    components: {
        AcrissBranchTranslationsForm,
        // AssociateAcrissModalForm,
        Alert,
        CheckBox,
        DatePicker,
        InputNumber,
        MultipleSelectPicker,
        SingleSelectPicker,
    },
    props: {
        action: {
            type: String,
            required: true,
        },
        acrissData: Object,
    },
    data() {
        return {
            EDIT_ACTION,
            Formatter,
            capitalize,
            txt: {},
            constants,

            associateAcriss: false,
            associationType: null,
            acrissExists: false,

            acriss: {
                id: null,
                acrissCode: null,
                carClass: null,
                vehicleType: null,
                gearBox: null,
                motorizationType: null,
                marketingStartDate: null,
                marketingEndDate: null,
                commercialVehicle: false,
                mediumTerm: false,
                numberOfSuitcases: null,
                numberOfSeats: null,
                numberOfDoors: null,
                minAge: null,
                maxAge: null,
                driverLicenseIds: null,
                minAgeDLClassB: null,
                minAgeDLClassA: null,
                minAgeDLClassA1: null,
                minAgeDLClassA2: null,
                enabled: null,
                branchTranslations: [],
            },

            driverLicenseList: [],
        };
    },
    created() {
        this.txt = txtTrans;
    },
    mounted() {
        this.driverLicenseList = [
            { id: constants.driverLicense.classB, name: this.txt.fields[constants.driverLicense.classB] },
            { id: constants.driverLicense.classA, name: this.txt.fields[constants.driverLicense.classA] },
            { id: constants.driverLicense.classA1, name: this.txt.fields[constants.driverLicense.classA1] },
            { id: constants.driverLicense.classA2, name: this.txt.fields[constants.driverLicense.classA2] },
        ];

        if ([EDIT_ACTION, SHOW_ACTION].includes(this.action)) this.fillAcrissData();
    },
    computed: {
        title() {
            const actionTitles = {
                [CREATE_ACTION]: this.txt.titles.createAcriss,
                [EDIT_ACTION]: this.txt.titles.editAcriss,
                [SHOW_ACTION]: this.txt.titles.showAcriss,
            };
            return actionTitles[this.action];
        },
        submitButtonText() {
            const submitButtonTexts = {
                [CREATE_ACTION]: this.txt.form.create,
                [EDIT_ACTION]: this.txt.form.update,
                [SHOW_ACTION]: this.txt.form.update,
            };
            const submitButtonSuccessTexts = {
                [CREATE_ACTION]: this.txt.form.created,
                [EDIT_ACTION]: this.txt.form.updated,
                [SHOW_ACTION]: this.txt.form.updated,
            };
            return this.acrissCreated ? submitButtonSuccessTexts[this.action] : submitButtonTexts[this.action];
        },
        submitButtonIcon() {
            const submitButtonIcons = {
                [CREATE_ACTION]: "la-plus",
                [EDIT_ACTION]: "la-edit",
                [SHOW_ACTION]: "la-edit",
            };
            return this.acrissCreated ? "flaticon2-check-mark" : submitButtonIcons[this.action];
        },
        acrissCode() {
            return `${this.acriss.carClass?.acrissLetter ?? ""}${this.acriss.vehicleType?.acrissLetter ?? ""}${this.acriss.gearBox
                ?.acrissLetter ?? ""}${this.acriss.motorizationType?.acrissLetter ?? ""}`.trim();
        },
        canCreateAcriss() {
            return this.action === CREATE_ACTION && (this.acrissExists || this.acrissCreated);
        },
        acrissCreated() {
            return this.action === CREATE_ACTION && this.acriss.id !== null;
        },
        successResponseMessage() {
            const successResponseMessages = {
                [CREATE_ACTION]: this.txt.form.acrissCreatedSuccessNotification,
                [EDIT_ACTION]: this.txt.form.acrissUpdatedSuccessNotification,
            };
            return successResponseMessages[this.action];
        },
        errorResponseMessage() {
            const errorResponseMessages = {
                [CREATE_ACTION]: this.txt.form.errorCreatingAcrissNotification,
                [EDIT_ACTION]: this.txt.form.errorUpdatingAcrissNotification,
            };
            return errorResponseMessages[this.action];
        },
    },
    methods: {
        fillAcrissData: function() {
            this.$nextTick(() => {
                this.acriss.id = this.acrissData?.data?.id;
                this.acriss.acrissCode = this.acrissData?.data?.name;
                if (this.acrissData?.data?.carClass?.name)
                    this.acrissData.data.carClass.name = capitalize(this.acrissData.data.carClass.name, true, true);
                this.acriss.carClass = this.acrissData?.data?.carClass;
                this.acriss.vehicleType = this.acrissData?.data?.acrissType;
                this.acriss.gearBox = this.acrissData?.data?.gearBox;
                this.acriss.motorizationType = this.acrissData?.data?.motorizationType;
                this.acriss.marketingStartDate = this.acrissData?.data?.startDate;
                this.acriss.marketingEndDate = this.acrissData?.data?.endDate;
                this.acriss.commercialVehicle = this.acrissData?.data?.commercialVehicle;
                this.acriss.mediumTerm = this.acrissData?.data?.mediumTerm;
                this.acriss.numberOfSuitcases = this.acrissData?.data?.numberOfSuitcases;
                this.acriss.numberOfSeats = this.acrissData?.data?.numberOfSeats;
                this.acriss.numberOfDoors = this.acrissData?.data?.numberOfDoors;
                this.acriss.minAge = this.acrissData?.data?.minAge;
                this.acriss.maxAge = this.acrissData?.data?.maxAge;

                this.acriss.driverLicenseIds = [];
                if (this.acrissData?.data?.isDriverLicenseClassB)
                    this.acriss.driverLicenseIds.push(constants.driverLicense.classB);
                if (this.acrissData?.data?.isDriverLicenseClassA)
                    this.acriss.driverLicenseIds.push(constants.driverLicense.classA);
                if (this.acrissData?.data?.isDriverLicenseClassA1)
                    this.acriss.driverLicenseIds.push(constants.driverLicense.classA1);
                if (this.acrissData?.data?.isDriverLicenseClassA2)
                    this.acriss.driverLicenseIds.push(constants.driverLicense.classA2);
                this.acriss.minAgeDLClassB = this.acrissData?.data?.minAgeExperienceDriverLicenseClassB;
                this.acriss.minAgeDLClassA = this.acrissData?.data?.minAgeExperienceDriverLicenseClassA;
                this.acriss.minAgeDLClassA1 = this.acrissData?.data?.minAgeExperienceDriverLicenseClassA1;
                this.acriss.minAgeDLClassA2 = this.acrissData?.data?.minAgeExperienceDriverLicenseClassA2;
                this.acriss.enabled = this.acrissData?.data?.enabled;
            });
        },
        formatAcrissField(field) {
            return this.acriss[field]?.acrissLetter ?? `${this.txt.form.select} ${String(this.txt.fields[field]).toLowerCase()}`;
        },
        checkAcrissLetters: function() {
            if (this.acriss.carClass && this.acriss.vehicleType && this.acriss.gearBox && this.acriss.motorizationType) {
                this.checkIfAcrissExists();
            }
        },
        checkIfAcrissExists: async function() {
            Loading.starLoading();

            let acriss = String("").concat(
                this.acriss.carClass.acrissLetter,
                this.acriss.vehicleType.acrissLetter,
                this.acriss.gearBox.acrissLetter,
                this.acriss.motorizationType.acrissLetter
            );

            let url = this.routing.generate("acriss.checkIfExists", { acriss: acriss });

            this.axios
                .get(url)
                .then((response) => {
                    // console.log("Check If Acriss Exists: ", response);
                    Loading.endLoading();
                    this.acrissExists = response.data.acrissExists;
                })
                .catch((error) => {
                    console.log(error.response);
                    Loading.endLoading();
                    this.$notify({
                        type: "error",
                        text: error.response.data.message,
                    });
                    this.acrissExists = false;
                });
        },
        onChangeDriverlLicenses: function(selection) {
            this.driverLicenseList.forEach((dl) => {
                if (!selection.includes(dl.id)) this.acriss[`minAgeDL${capitalize(dl.id, false)}`] = null;
            });
        },
        submitAcriss: async function() {
            Loading.starLoading();

            this.acriss.branchTranslations = this.$refs.branchTranslationsForm.branchTranslations;

            const formData = new FormData();
            // formData.set("acriss", JSON.stringify(this.acriss));
            formData.set("acrissCode", this.acriss.acrissCode);
            formData.set("carClassId", this.acriss.carClass.id);
            formData.set("vehicleTypeId", this.acriss.vehicleType.id);
            formData.set("gearBoxId", this.acriss.gearBox.id);
            formData.set("motorizationTypeId", this.acriss.motorizationType.id);
            formData.set("marketingStartDate", this.acriss.marketingStartDate);
            formData.set("marketingEndDate", this.acriss.marketingEndDate);
            formData.set("commercialVehicle", this.acriss.commercialVehicle);
            formData.set("mediumTerm", this.acriss.mediumTerm);
            formData.set("numberOfSuitcases", this.acriss.numberOfSuitcases);
            formData.set("numberOfSeats", this.acriss.numberOfSeats);
            formData.set("numberOfDoors", this.acriss.numberOfDoors);
            formData.set("minAge", this.acriss.minAge);
            formData.set("maxAge", this.acriss.maxAge);
            if (this.acriss.driverLicenseIds?.length > 0) {
                this.acriss.driverLicenseIds.forEach((dl) => {
                    const minAgeDLId = `minAgeDL${capitalize(dl, false)}`;
                    formData.set(minAgeDLId, this.acriss[minAgeDLId]);
                });
            }

            // Branch translations
            if (this.acriss.branchTranslations?.length > 0) {
                this.acriss.branchTranslations.forEach((item) => {
                    delete item.selectedLanguage;
                    item.imageLines.forEach((imageLine) => {
                        delete imageLine.viewImage;
                    });
                    formData.append("branchTranslations[]", JSON.stringify(item));
                });
            }

            const url = this.acriss.id
                ? this.routing.generate("acriss.update", { id: this.acriss.id })
                : this.routing.generate("acriss.store");

            this.axios
                .post(url, formData)
                .then((response) => {
                    // console.log("Create Acriss: ", response);
                    Loading.endLoading();

                    if ([200, 201].includes(response.status)) {
                        this.acriss.id = response.data.id;
                        this.$notify({
                            type: "success",
                            text: this.successResponseMessage,
                        });

                        this.goToDetailsPage();

                        // TODO V2: Implementar lógica para asociar acriss (superior o inferior)
                        // if (this.action === CREATE_ACTION) {
                        //     this.acriss.id = response.data.id;
                        //     this.submitButton = this.txt.form.acrissCreated;
                        //     this.submitButtonClass = "la-check";

                        //     if (this.acriss.motorizationType.acrissLetter === constants.topAcrissLetter) {
                        //         this.associationType = SUPERIOR;
                        //         this.checkIfAcrissHasChilds();
                        //     } else {
                        //         this.associationType = INFERIOR;
                        //         // TODO implementar lógica para hacer llamada backend y comprobar si el acriss es inferior
                        //     }
                        // }
                    } else {
                        this.$notify({
                            type: "error",
                            text: this.errorResponseMessage,
                        });
                    }
                })
                .catch((error) => {
                    console.error(error.response);
                    Loading.endLoading();

                    let errorMessage = this.errorResponseMessage;
                    if ([400, 460].includes(error.response.status)) {
                        errorMessage += error.response.data.message;
                    }
                    this.$notify({
                        type: "error",
                        text: errorMessage,
                    });
                });
        },
        checkIfAcrissHasChilds: async function() {
            Loading.starLoading();

            let url = this.routing.generate("acriss.checkIfHasChilds", {
                acrissFirstLetter: this.acriss.carClass.acrissLetter,
                acrissSecondLetter: this.acriss.vehicleType.acrissLetter,
                acrissThirdLetter: this.acriss.gearBox.acrissLetter,
            });

            this.axios
                .get(url)
                .then((response) => {
                    // console.log("Check If Acriss Has Childs: ", response);
                    Loading.endLoading();

                    if (response.data.acrissHasChilds) {
                        window.swal
                            .fire({
                                title: this.txt.form.associateAcrissQuestion,
                                type: "question",
                                confirmButtonText: this.txt.form.yes,
                                confirmButtonColor: "#5867dd",
                                showCancelButton: true,
                                cancelButtonText: this.txt.form.no,
                                cancelButtonColor: "#d33",
                            })
                            .then((result) => {
                                if (result.value) {
                                    this.associateAcriss = true;
                                    $("#associate-acriss-list").modal("show");
                                } else {
                                    this.goToDetailsPage();
                                }
                            });
                    }
                })
                .catch((error) => {
                    console.log(error.response);
                    Loading.endLoading();
                    this.$notify({
                        type: "error",
                        text: error.response.data.message,
                    });
                });
        },
        goToDetailsPage(timeout = 2000) {
            setTimeout(() => {
                window.location.href = this.routing.generate("acriss.show", { id: this.acriss.id });
            }, timeout);
        },
    },
    watch: {
        acrissCode: {
            handler: function() {
                this.acriss.acrissCode = this.acrissCode;
            },
            inmediate: true,
        },
    },
};
</script>

<style scoped></style>
