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
                                        @updatedSelectPicker="
                                            acrissData.carClass = selectList.carClassList.find((item) => item.id === $event)
                                        "
                                        @onBlurSelectPicker="checkAcrissLetters"
                                        name="carClass"
                                        id="carClass"
                                        divClass="form-group col-md-3"
                                        :label="txt.fields.carClass"
                                        :placeholder="txt.form.selectAnOption"
                                        :value="acrissData.carClass ? acrissData.carClass.id : null"
                                        required
                                        :disabled="acrissCreated"
                                    >
                                        <option
                                            v-for="item in selectList.carClassList"
                                            :value="item.id"
                                            :key="item.id"
                                            v-text="`${item.name} (${item.acrissLetter ? item.acrissLetter : ''})`"
                                        ></option>
                                    </single-select-picker>

                                    <single-select-picker
                                        @updatedSelectPicker="
                                            acrissData.vehicleType = selectList.acrissTypeList.find((item) => item.id === $event)
                                        "
                                        @onBlurSelectPicker="checkAcrissLetters"
                                        name="vehicleType"
                                        id="vehicleType"
                                        divClass="form-group col-md-3"
                                        :label="txt.fields.vehicleType"
                                        :placeholder="txt.form.selectAnOption"
                                        :value="acrissData.vehicleType ? acrissData.vehicleType.id : null"
                                        required
                                        :disabled="acrissCreated"
                                    >
                                        <option
                                            v-for="item in selectList.acrissTypeList"
                                            :value="item.id"
                                            :key="item.id"
                                            v-text="`${item.name} (${item.acrissLetter ? item.acrissLetter : ''})`"
                                        ></option>
                                    </single-select-picker>

                                    <single-select-picker
                                        @updatedSelectPicker="
                                            acrissData.gearBox = selectList.gearBoxList.find((item) => item.id === $event)
                                        "
                                        @onBlurSelectPicker="checkAcrissLetters"
                                        name="gearBox"
                                        id="gearBox"
                                        divClass="form-group col-md-3"
                                        :label="txt.fields.gearBox"
                                        :placeholder="txt.form.selectAnOption"
                                        :value="acrissData.gearBox ? acrissData.gearBox.id : null"
                                        required
                                        :disabled="acrissCreated"
                                    >
                                        <option
                                            v-for="item in selectList.gearBoxList"
                                            :value="item.id"
                                            :key="item.id"
                                            v-text="`${item.name} (${item.acrissLetter ? item.acrissLetter : ''})`"
                                        ></option>
                                    </single-select-picker>

                                    <single-select-picker
                                        @updatedSelectPicker="
                                            acrissData.motorizationType = selectList.motorizationTypeList.find(
                                                (item) => item.id === $event
                                            )
                                        "
                                        @onBlurSelectPicker="checkAcrissLetters"
                                        name="motorizationType"
                                        id="motorizationType"
                                        divClass="form-group col-md-3"
                                        :label="txt.fields.motorizationType"
                                        :placeholder="txt.form.selectAnOption"
                                        :value="acrissData.motorizationType ? acrissData.motorizationType.id : null"
                                        required
                                        :disabled="acrissCreated"
                                    >
                                        <option
                                            v-for="item in selectList.motorizationTypeList"
                                            :value="item.id"
                                            :key="item.id"
                                            v-text="`${item.name} (${item.acrissLetter ? item.acrissLetter : ''})`"
                                        ></option>
                                    </single-select-picker>
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
                                    @updatedDatePicker="acrissData.marketingStartDate = $event"
                                    name="marketingStartDate"
                                    id="marketingStartDate"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.marketingStartDate"
                                    :placeholder="txt.fields.marketingStartDate"
                                    :value="acrissData.marketingStartDate"
                                    :limit-end-day="acrissData.marketingEndDate"
                                />

                                <date-picker
                                    @updatedDatePicker="acrissData.marketingEndDate = $event"
                                    name="marketingEndDate"
                                    id="marketingEndDate"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.marketingEndDate"
                                    :placeholder="txt.fields.marketingEndDate"
                                    :value="acrissData.marketingEndDate"
                                    :limit-start-day="acrissData.marketingStartDate"
                                />

                                <check-box
                                    @updatedCheckBox="acrissData.commercialVehicle = $event"
                                    name="commercialVehicle"
                                    id="commercialVehicle"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.commercialVehicle"
                                    :value="acrissData.commercialVehicle"
                                />

                                <check-box
                                    @updatedCheckBox="acrissData.mediumTerm = $event"
                                    name="mediumTerm"
                                    id="mediumTerm"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.mediumTerm"
                                    :value="acrissData.mediumTerm"
                                />
                            </div>

                            <div class="row">
                                <input-number
                                    @updatedInputNumber="acrissData.numberOfSuitcases = $event"
                                    name="numberOfSuitcases"
                                    id="numberOfSuitcases"
                                    divClass="form-group col-md-3"
                                    :min="1"
                                    :step="1"
                                    :label="txt.fields.numberOfSuitcases"
                                    :value="acrissData.numberOfSuitcases"
                                />

                                <single-select-picker
                                    @updatedSelectPicker="acrissData.vehicleSeatsId = $event"
                                    name="vehicleSeatsId"
                                    id="vehicleSeatsId"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.numberOfSeats"
                                    :options="selectList.vehicleSeatsList"
                                    :placeholder="txt.form.selectAnOption"
                                    :value="acrissData.vehicleSeatsId"
                                />

                                <input-number
                                    @updatedInputNumber="acrissData.numberOfDoors = $event"
                                    name="numberOfDoors"
                                    id="numberOfDoors"
                                    divClass="form-group col-md-3"
                                    :min="1"
                                    :step="1"
                                    :label="txt.fields.numberOfDoors"
                                    :value="acrissData.numberOfDoors"
                                />
                            </div>

                            <div class="border-bottom mt-3 mb-5" />

                            <!-- Pernmission fields -->
                            <h5 class="mb-5" v-text="txt.titles.permissionFields"></h5>

                            <div class="row">
                                <input-number
                                    @updatedInputNumber="acrissData.minAge = $event"
                                    name="minAge"
                                    id="minAge"
                                    divClass="form-group col-md-3"
                                    :min="1"
                                    :max="acrissData.maxAge ? parseInt(acrissData.maxAge) : undefined"
                                    :step="1"
                                    :label="txt.fields.minAge"
                                    :value="acrissData.minAge"
                                    input-group
                                />

                                <input-number
                                    @updatedInputNumber="acrissData.maxAge = $event"
                                    name="maxAge"
                                    id="maxAge"
                                    divClass="form-group col-md-3"
                                    :min="acrissData.minAge ? parseInt(acrissData.minAge) : 1"
                                    :step="1"
                                    :label="txt.fields.maxAge"
                                    :value="acrissData.maxAge"
                                />

                                <multiple-select-picker
                                    @updatedMultipleSelectPicker="
                                        acrissData.driverLicenseIds = $event;
                                        onChangeDriverlLicenses($event);
                                    "
                                    name="driverLicenseIds"
                                    id="driverLicenseIds"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.driverLicense"
                                    :placeholder="txt.form.selectAnOption"
                                    :value="acrissData.driverLicenseIds"
                                    :options="driverLicenseList"
                                />
                            </div>

                            <div v-if="acrissData.driverLicenseIds && acrissData.driverLicenseIds.length > 0" class="row">
                                <input-number
                                    @updatedInputNumber="acriss[`minAgeDL${capitalize(dl, false)}`] = $event"
                                    v-for="dl in acrissData.driverLicenseIds"
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
                                    v-if="acrissData.branchTranslations.length > 0"
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
        selectList: {
            type: Object,
            required: true,
        },
        acriss: Object,
    },
    data() {
        return {
            EDIT_ACTION,
            Formatter,
            capitalize,
            txt: txtTrans,
            constants,

            associateAcriss: false,
            associationType: null,
            acrissExists: false,

            acrissData: {
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
                vehicleSeatsId: null,
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
        this.driverLicenseList = [
            { id: constants.driverLicense.classB, name: this.txt.fields[constants.driverLicense.classB] },
            { id: constants.driverLicense.classA, name: this.txt.fields[constants.driverLicense.classA] },
            { id: constants.driverLicense.classA1, name: this.txt.fields[constants.driverLicense.classA1] },
            { id: constants.driverLicense.classA2, name: this.txt.fields[constants.driverLicense.classA2] },
        ];
    },
    mounted() {
        if ([EDIT_ACTION, SHOW_ACTION].includes(this.action)) {
            this.acrissData.id = this.acriss?.data?.id;
            this.acrissData.acrissCode = this.acriss?.data?.name;
            this.acrissData.carClass = this.acriss?.data?.carClass;
            this.acrissData.vehicleType = this.acriss?.data?.acrissType;
            this.acrissData.gearBox = this.acriss?.data?.gearBox;
            this.acrissData.motorizationType = this.acriss?.data?.motorizationType;
            this.acrissData.marketingStartDate = this.acriss?.data?.startDate;
            this.acrissData.marketingEndDate = this.acriss?.data?.endDate;
            this.acrissData.commercialVehicle = this.acriss?.data?.commercialVehicle;
            this.acrissData.mediumTerm = this.acriss?.data?.mediumTerm;
            this.acrissData.numberOfSuitcases = this.acriss?.data?.numberOfSuitcases;
            this.acrissData.vehicleSeatsId = this.acriss?.data?.vehicleSeats?.id;
            this.acrissData.numberOfDoors = this.acriss?.data?.numberOfDoors;
            this.acrissData.minAge = this.acriss?.data?.minAge;
            this.acrissData.maxAge = this.acriss?.data?.maxAge;

            this.acrissData.driverLicenseIds = [];
            if (this.acriss?.data?.isDriverLicenseClassB) this.acrissData.driverLicenseIds.push(constants.driverLicense.classB);
            if (this.acriss?.data?.isDriverLicenseClassA) this.acrissData.driverLicenseIds.push(constants.driverLicense.classA);
            if (this.acriss?.data?.isDriverLicenseClassA1) this.acrissData.driverLicenseIds.push(constants.driverLicense.classA1);
            if (this.acriss?.data?.isDriverLicenseClassA2) this.acrissData.driverLicenseIds.push(constants.driverLicense.classA2);
            this.acrissData.minAgeDLClassB = this.acriss?.data?.minAgeExperienceDriverLicenseClassB;
            this.acrissData.minAgeDLClassA = this.acriss?.data?.minAgeExperienceDriverLicenseClassA;
            this.acrissData.minAgeDLClassA1 = this.acriss?.data?.minAgeExperienceDriverLicenseClassA1;
            this.acrissData.minAgeDLClassA2 = this.acriss?.data?.minAgeExperienceDriverLicenseClassA2;
            this.acrissData.enabled = this.acriss?.data?.enabled;

            this.acrissData.branchTranslations = this.acriss?.branchTranslations ?? [];
        }
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
            return `${this.acrissData.carClass?.acrissLetter ?? ""}${this.acrissData.vehicleType?.acrissLetter ?? ""}${this
                .acrissData.gearBox?.acrissLetter ?? ""}${this.acrissData.motorizationType?.acrissLetter ?? ""}`.trim();
        },
        canCreateAcriss() {
            return this.action === CREATE_ACTION && (this.acrissExists || this.acrissCreated);
        },
        acrissCreated() {
            return this.action === CREATE_ACTION && this.acrissData.id !== null;
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
        formatAcrissField(field) {
            return (
                this.acrissData[field]?.acrissLetter ?? `${this.txt.form.select} ${String(this.txt.fields[field]).toLowerCase()}`
            );
        },
        checkAcrissLetters: function() {
            if (
                this.acrissData.carClass &&
                this.acrissData.vehicleType &&
                this.acrissData.gearBox &&
                this.acrissData.motorizationType
            ) {
                this.checkIfAcrissExists();
            }
        },
        checkIfAcrissExists: async function() {
            Loading.starLoading();

            const carClass = this.acrissData.carClass.acrissLetter ?? "";
            const vehicleType = this.acrissData.vehicleType.acrissLetter ?? "";
            const gearBox = this.acrissData.gearBox.acrissLetter ?? "";
            const motorizationType = this.acrissData.motorizationType.acrissLetter ?? "";
            let acriss = String("").concat(carClass, vehicleType, gearBox, motorizationType);

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
                if (!selection.includes(dl.id)) this.acrissData[`minAgeDL${capitalize(dl.id, false)}`] = null;
            });
        },
        submitAcriss: async function() {
            Loading.starLoading();

            const formData = new FormData();
            // formData.set("acriss", JSON.stringify(this.acrissData));
            formData.set("acrissCode", this.acrissData.acrissCode);
            formData.set("carClassId", this.acrissData.carClass.id);
            formData.set("vehicleTypeId", this.acrissData.vehicleType.id);
            formData.set("gearBoxId", this.acrissData.gearBox.id);
            formData.set("motorizationTypeId", this.acrissData.motorizationType.id);
            formData.set("marketingStartDate", this.acrissData.marketingStartDate);
            formData.set("marketingEndDate", this.acrissData.marketingEndDate);
            formData.set("commercialVehicle", this.acrissData.commercialVehicle);
            formData.set("mediumTerm", this.acrissData.mediumTerm);
            formData.set("numberOfSuitcases", this.acrissData.numberOfSuitcases);
            formData.set("vehicleSeatsId", this.acrissData.vehicleSeatsId);
            formData.set("numberOfDoors", this.acrissData.numberOfDoors);
            formData.set("minAge", this.acrissData.minAge);
            formData.set("maxAge", this.acrissData.maxAge);
            if (this.acrissData.driverLicenseIds?.length > 0) {
                this.acrissData.driverLicenseIds.forEach((dl) => {
                    const minAgeDLId = `minAgeDL${capitalize(dl, false)}`;
                    formData.set(minAgeDLId, this.acrissData[minAgeDLId]);
                });
            }

            // Branch translations
            if (this.action === EDIT_ACTION) {
                this.acrissData.branchTranslations = this.$refs.branchTranslationsForm.branchTranslations;
                if (this.acrissData.branchTranslations?.length > 0) {
                    this.acrissData.branchTranslations.forEach((item) => {
                        delete item.selectedLanguage;
                        item.imageLines.forEach((imageLine) => {
                            delete imageLine.viewImage;
                        });
                        formData.append("branchTranslations[]", JSON.stringify(item));
                    });
                }
            }

            const url = this.acrissData.id
                ? this.routing.generate("acriss.update", { id: this.acrissData.id })
                : this.routing.generate("acriss.store");

            this.axios
                .post(url, formData)
                .then((response) => {
                    // console.log("Create Acriss: ", response);
                    Loading.endLoading();

                    if ([200, 201].includes(response.status)) {
                        if (this.action === CREATE_ACTION) this.acrissData.id = response.data.id;
                        this.$notify({
                            type: "success",
                            text: this.successResponseMessage,
                        });

                        this.goToDetailsPage();

                        // TODO V2: Implementar lógica para asociar acriss (superior o inferior)
                        // if (this.action === CREATE_ACTION) {
                        //     this.acrissData.id = response.data.id;
                        //     this.submitButton = this.txt.form.acrissCreated;
                        //     this.submitButtonClass = "la-check";

                        //     if (this.acrissData.motorizationType.acrissLetter === constants.topAcrissLetter) {
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
                acrissFirstLetter: this.acrissData.carClass.acrissLetter,
                acrissSecondLetter: this.acrissData.vehicleType.acrissLetter,
                acrissThirdLetter: this.acrissData.gearBox.acrissLetter,
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
                window.location.href = this.routing.generate("acriss.show", { id: this.acrissData.id });
            }, timeout);
        },
    },
    watch: {
        acrissCode: {
            handler: function() {
                this.acrissData.acrissCode = this.acrissCode;
            },
            inmediate: true,
        },
    },
};
</script>

<style scoped></style>
