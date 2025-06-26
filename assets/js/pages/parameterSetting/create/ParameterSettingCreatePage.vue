<template>
    <fragment>
        <notifications position="top right"></notifications>

        <form @submit.prevent="handleSubmit" enctype="multipart/form-data" autocomplete="off">
            <div class="row">
                <div class="col-md-12">
                    <div class="kt-portlet kt-portlet--bordered">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title" v-text="txt.titles.createParameterSetting"></h3>
                            </div>
                        </div>

                        <div class="kt-portlet__body">
                            <div class="row">
                                <date-picker
                                    @updatedDatePicker="parameterSetting.startDate = $event"
                                    name="startDate"
                                    id="startDate"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.startDate"
                                    :limit-start-day="today"
                                    :limit-end-day="parameterSetting.endDate"
                                    :value="parameterSetting.startDate"
                                    required
                                />
                                <date-picker
                                    @updatedDatePicker="parameterSetting.endDate = $event"
                                    name="endDate"
                                    id="endDate"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.endDate"
                                    :limit-start-day="endDateLimit"
                                    :value="parameterSetting.endDate"
                                    required
                                />

                                <single-select-picker
                                    @updatedSelectPicker="parameterSetting.parameterType = $event"
                                    name="typeId"
                                    id="typeId"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.type"
                                    :placeholder="txt.form.selectAnOption"
                                    :options="selectList.parameterSettingTypeList"
                                    :value="parameterSetting.parameterType"
                                    required
                                />

                                <input-number
                                    @updatedInputNumber="parameterSetting.parameter = $event"
                                    name="parameterId"
                                    id="parameterId"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.parameter"
                                    :value="parameterSetting.parameter"
                                    required
                                />
                            </div>

                            <div class="row">
                                <multiple-select-picker
                                    @onChangeMultipleSelectPicker="onChangeCarGroup"
                                    @updatedMultipleSelectPicker="parameterSetting.carGroupIds = $event"
                                    name="carGroupsId[]"
                                    id="carGroupsId"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.carGroup"
                                    :placeholder="txt.form.selectAnOption"
                                    :options="customCarGroupList"
                                    :value="parameterSetting.carGroupIds"
                                />

                                <multiple-select-picker
                                    @onChangeMultipleSelectPicker="onChangeAcriss"
                                    @updatedMultipleSelectPicker="parameterSetting.acrissIds = $event"
                                    name="acrissId[]"
                                    id="acrissId"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.acriss"
                                    :placeholder="txt.form.selectAnOption"
                                    :options="customAcrissList"
                                    :value="parameterSetting.acrissIds"
                                    required
                                />

                                <multiple-select-picker
                                    v-if="showReplacement"
                                    @onChangeMultipleSelectPicker="onChangeReplacementCarGroup"
                                    @updatedMultipleSelectPicker="parameterSetting.replacementCarGroupIds = $event"
                                    name="replacementGroupsId[]"
                                    id="replacementGroupsId"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.replacementGroups"
                                    :placeholder="txt.form.selectAnOption"
                                    :options="customReplacementCarGroupList"
                                    :disabled="disableReplacementFields"
                                    :value="parameterSetting.replacementCarGroupIds"
                                />

                                <multiple-select-picker
                                    v-if="showReplacement"
                                    @onChangeMultipleSelectPicker="onChangeReplacementAcriss"
                                    @updatedMultipleSelectPicker="parameterSetting.replacementAcrissIds = $event"
                                    name="replacementAcrissId[]"
                                    id="replacementAcrissId"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.replacementAcriss"
                                    :placeholder="txt.form.selectAnOption"
                                    :options="customReplacementAcrissList"
                                    :disabled="disableReplacementFields"
                                    :required="!disableReplacementFields"
                                    :value="parameterSetting.replacementAcrissIds"
                                />
                            </div>

                            <div class="row">
                                <multiple-select-picker
                                    @updatedMultipleSelectPicker="(parameterSetting.regionIds = $event), regionUpdated()"
                                    name="regionId[]"
                                    id="regionId"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.region"
                                    :placeholder="txt.form.selectAnOption"
                                    :options="regionListFiltered"
                                    :value="parameterSetting.regionIds"
                                />

                                <multiple-select-picker
                                    @updatedMultipleSelectPicker="(parameterSetting.areaIds = $event), areaUpdated()"
                                    name="areaId[]"
                                    id="areaId"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.area"
                                    :placeholder="txt.form.selectAnOption"
                                    :options="areaListFiltered"
                                    :value="parameterSetting.areaIds"
                                />

                                <multiple-select-picker
                                    @updatedMultipleSelectPicker="parameterSetting.branchIds = $event"
                                    name="branchId[]"
                                    id="branchId"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.branch"
                                    :placeholder="txt.form.selectAnOption"
                                    :options="branchListFiltered"
                                    :value="parameterSetting.branchIds"
                                    required
                                />

                                <multiple-select-picker
                                    @updatedMultipleSelectPicker="parameterSetting.partnerIds = $event"
                                    name="partnerId[]"
                                    id="partnerId"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.partners"
                                    :placeholder="txt.form.selectAnOption"
                                    :options="selectList.partnerList"
                                    :value="parameterSetting.partnerIds"
                                    required
                                />
                            </div>

                            <div class="row">
                                <time-picker
                                    @updatedTimePicker="parameterSetting.startTime = $event"
                                    name="startTime"
                                    id="startTime"
                                    divClass="form-group col-md-2"
                                    :label="txt.fields.startTime"
                                    :value="parameterSetting.startTime"
                                    :disabled="disableTimes"
                                />

                                <time-picker
                                    @updatedTimePicker="parameterSetting.endTime = $event"
                                    name="endTime"
                                    id="endTime"
                                    divClass="form-group col-md-2"
                                    :label="txt.fields.endTime"
                                    :value="parameterSetting.endTime"
                                    :disabled="disableTimes"
                                />

                                <single-select-picker
                                    @updatedSelectPicker="parameterSetting.connectedVehicle = $event"
                                    name="connectedVehicle"
                                    id="connectedVehicle"
                                    divClass="form-group col-md-3"
                                    :label="txt.fields.connectedVehicle"
                                    :placeholder="txt.form.selectAnOption"
                                    :value="parameterSetting.connectedVehicle"
                                    disabled
                                    required
                                >
                                    <option
                                        v-for="item in selectList.connectedVehicleList"
                                        :value="item.id"
                                        v-text="txt.form[item.name]"
                                    ></option>
                                </single-select-picker>
                            </div>
                        </div>

                        <div class="kt-portlet__foot">
                            <div class="kt-align-right">
                                <button type="submit" class="btn btn-dark kt-label-bg-color-4">
                                    <i class="la la-plus"></i>
                                    {{ txt.form.create }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <modal-parameter-conflict
            v-if="showConflictModal"
            :message="conflictMessage"
            :onConfirm="overrideAndSave"
            @cancel="closeConflictModal"
            />
    </fragment>
</template>

<script>
import moment from "moment";
import Loading from "../../../../assets/js/utilities";

import DatePicker from "../../../../SharedAssets/vue/components/base/inputs/DatePicker.vue";
import InputNumber from "../../../../SharedAssets/vue/components/base/inputs/InputNumber.vue";
import MultipleSelectPicker from "../../../../SharedAssets/vue/components/base/inputs/MultipleSelectPicker.vue";
import SingleSelectPicker from "../../../../SharedAssets/vue/components/base/inputs/SingleSelectPicker.vue";
import TimePicker from "../../../../SharedAssets/vue/components/base/inputs/TimePicker.vue";
import ModalParameterConflict from "../modals/ModalParameterConflict.vue";

export default {
    name: "ParameterSettingCreatePage",
    components: {
        DatePicker,
        InputNumber,
        MultipleSelectPicker,
        SingleSelectPicker,
        TimePicker,
        ModalParameterConflict,
    },
    props: {
        selectList: Object,
    },
    data() {
        return {
            txt: txtTrans,
            today: new Intl.DateTimeFormat("en-GB").format(new Date(Date.now())),
            parameterSetting: {
                startDate: new Intl.DateTimeFormat("en-GB").format(new Date(Date.now())),
                endDate: null,
                parameterType: null,
                parameter: null,
                carGroupIds: [],
                acrissIds: [],
                replacementCarGroupIds: [],
                replacementAcrissIds: [],
                regionIds: [],
                areaIds: [],
                branchIds: [],
                partnerIds: [],
                startTime: null,
                endTime: null,
                connectedVehicle: false,
            },

            disableReplacementFields: false,

            customCarGroupList: [],
            customAcrissList: [],
            customReplacementCarGroupList: [],
            customReplacementAcrissList: [],

            carGroupSelected: [],
            acrissSelected: [],
            replacementCarGroupSelected: [],
            replacementAcrissSelected: [],

            regionListFiltered: [],
            areaListFiltered: [],
            branchListFiltered: [],
            showConflictModal: false,
            conflictMessage: '',
            conflictingParams: [], 
        };
    },
    computed: {
        endDateLimit() {
            return new Intl.DateTimeFormat("en-GB").format(
                moment(this.parameterSetting.startDate, "DD/MM/YYYY")
                    .add(1, "days")
                    .toDate()
            );
        },
        disableTimes() {
            if (["", null, undefined].includes(this.parameterSetting.parameter) || !this.parameterSetting.parameter >= 0) {
                this.parameterSetting.startTime = "00:00";
                this.parameterSetting.endTime = "23:59";
            }
            return ["", null, undefined].includes(this.parameterSetting.parameter) || this.parameterSetting.parameter >= 0;
        },
        showReplacement() {
            let show = false;

            switch (this.parameterSetting.parameterType) {
                case constants.parameterType.orderUpgrade:
                    show = true;
                    this.disableReplacementFields = false;
                    break;
                case constants.parameterType.saleFamily:
                    show = true;
                    this.disableReplacementFields = true;

                    this.replacementAcrissSelected = this.acrissSelected;
                    this.replacementCarGroupSelected = this.carGroupSelected;
                    this.parameterSetting.replacementAcrissIds = this.parameterSetting.acrissIds;
                    this.parameterSetting.replacementCarGroupIds = this.parameterSetting.carGroupIds;
                    this.manageSelections(
                        null,
                        null,
                        "replacementCarGroupSelected",
                        "customReplacementCarGroupList",
                        this.selectList.carGroupList
                    );
                    this.manageSelections(
                        null,
                        null,
                        "replacementAcrissSelected",
                        "customReplacementAcrissList",
                        this.selectList.acrissList
                    );
                    break;

                default:
                    show = false;
                    this.disableReplacementFields = true;
                    this.parameterSetting.replacementAcrissIds.length = 0;
                    this.parameterSetting.replacementCarGroupIds.length = 0;
                    break;
            }

            return show;
        },
    },
    created() {
        this.customCarGroupList = this.selectList.carGroupList;
        this.customAcrissList = this.selectList.acrissList;
        this.customReplacementCarGroupList = this.selectList.carGroupList;
        this.customReplacementAcrissList = this.selectList.acrissList;

        this.areaListFiltered = this.selectList.areaList;
        this.regionListFiltered = this.selectList.regionList;
        this.branchListFiltered = this.selectList.branchList;
    },
    methods: {
        regionUpdated() {
            this.parameterSetting.areaIds = [];
            this.parameterSetting.branchIds = [];
            if (this.parameterSetting.regionIds.length === 0) {
                this.regionListFiltered = this.selectList.regionList;
                this.areaListFiltered = this.selectList.areaList;
                this.branchListFiltered = this.selectList.branchList;
                return;
            }

            this.areaListFiltered = this.selectList.areaList.filter((item) =>
                this.parameterSetting.regionIds.includes(item.regionId)
            );
            this.branchListFiltered = this.selectList.branchList.filter((item) =>
                this.areaListFiltered.map((item) => item.id).includes(item.areaId)
            );
        },
        areaUpdated() {
            this.parameterSetting.branchIds = [];
            if (this.parameterSetting.areaIds.length === 0) {
                this.areaListFiltered = this.selectList.areaList;
                this.branchListFiltered = this.selectList.branchList;
                return;
            }

            this.branchListFiltered = this.selectList.branchList.filter((item) =>
                this.parameterSetting.areaIds.includes(item.areaId)
            );
        },
        manageSelections(clickedIndex, selectedValues, selectedValuesOrdered, customList, originalist) {
            if (selectedValues) {
                // Si está vacío
                if (selectedValues.length === 0) {
                    this[selectedValuesOrdered].length = 0;
                    this[customList] = originalist.slice();
                    clickedIndex = null;
                }
                // Si todos están seleccionados
                if (selectedValues.length === originalist.length) {
                    selectedValues.forEach((value) => {
                        this[selectedValuesOrdered].push(originalist.find((item) => item.id === value));
                    });
                }
            }

            if (clickedIndex !== null) {
                // Buscar si el índice ya está en el array, si no añadir
                let selectedValue = this[customList][clickedIndex];
                if (!this[selectedValuesOrdered].includes(selectedValue)) {
                    this[selectedValuesOrdered].push(selectedValue);
                } else {
                    // Si está en el array, buscar el índice y eliminarlo
                    this[selectedValuesOrdered].splice(this[selectedValuesOrdered].indexOf(selectedValue), 1);
                }
            }

            // Reordenamos la lista del selector poniendo en orden de selección los valores seleccionados, y en orden por defecto los no seleccionados
            const arrayCopy = originalist.slice();
            const unselectedValues = arrayCopy.filter((item) => !this[selectedValuesOrdered].includes(item));
            this[customList] = [...this[selectedValuesOrdered], ...unselectedValues];
            this[customList] = [...new Set(this[customList])];
        },
        onChangeCarGroup(e, clickedIndex, isSelected, previousValue, selectedValues) {
            this.manageSelections(
                clickedIndex,
                selectedValues,
                "carGroupSelected",
                "customCarGroupList",
                this.selectList.carGroupList
            );

            this.acrissSelected.length = 0;
            this.parameterSetting.acrissIds.length = 0;

            if (this.carGroupSelected.length > 0) {
                this.carGroupSelected.forEach((carGroup) => {
                    let foundAcriss = this.customAcrissList.filter((item) => item.carGroupId === carGroup.id);

                    if (foundAcriss) {
                        this.acrissSelected.forEach((acriss) => {
                            foundAcriss = foundAcriss.filter((item) => item.id !== acriss.id);
                        });

                        this.acrissSelected = this.acrissSelected.concat(foundAcriss);
                    }
                });
                this.parameterSetting.acrissIds = this.acrissSelected.map((item) => item.id);
            }

            this.manageSelections(null, null, "acrissSelected", "customAcrissList", this.selectList.acrissList);
        },
        onChangeAcriss(e, clickedIndex, isSelected, previousValue, selectedValues) {
            this.manageSelections(clickedIndex, selectedValues, "acrissSelected", "customAcrissList", this.selectList.acrissList);

            this.carGroupSelected.length = 0;
            this.parameterSetting.carGroupIds.length = 0;

            if (this.acrissSelected.length > 0) {
                this.acrissSelected.forEach((acriss) => {
                    if (acriss.carGroupId && this.carGroupSelected.find((item) => item.id === acriss.carGroupId) === undefined) {
                        this.carGroupSelected.push(this.selectList.carGroupList.find((item) => item.id === acriss.carGroupId));
                    }
                });
                this.parameterSetting.carGroupIds = this.carGroupSelected.map((item) => item.id);
            }

            this.manageSelections(null, null, "carGroupSelected", "customCarGroupList", this.selectList.carGroupList);
        },
        onChangeReplacementCarGroup(e, clickedIndex, isSelected, previousValue, selectedValues) {
            this.manageSelections(
                clickedIndex,
                selectedValues,
                "replacementCarGroupSelected",
                "customReplacementCarGroupList",
                this.selectList.carGroupList
            );

            this.replacementAcrissSelected.length = 0;
            this.parameterSetting.replacementAcrissIds.length = 0;

            if (this.replacementCarGroupSelected.length > 0) {
                this.replacementCarGroupSelected.forEach((carGroup) => {
                    let foundAcriss = this.customReplacementAcrissList.filter((item) => item.carGroupId === carGroup.id);

                    if (foundAcriss) {
                        this.replacementAcrissSelected.forEach((acriss) => {
                            foundAcriss = foundAcriss.filter((item) => item.id !== acriss.id);
                        });

                        this.replacementAcrissSelected = this.replacementAcrissSelected.concat(foundAcriss);
                    }
                });
                this.parameterSetting.replacementAcrissIds = this.replacementAcrissSelected.map((item) => item.id);
            }

            this.manageSelections(
                null,
                null,
                "replacementAcrissSelected",
                "customReplacementAcrissList",
                this.selectList.acrissList
            );
        },
        onChangeReplacementAcriss(e, clickedIndex, isSelected, previousValue, selectedValues) {
            this.manageSelections(
                clickedIndex,
                selectedValues,
                "replacementAcrissSelected",
                "customReplacementAcrissList",
                this.selectList.acrissList
            );

            this.replacementCarGroupSelected.length = 0;
            this.parameterSetting.replacementCarGroupIds.length = 0;

            if (this.replacementAcrissSelected.length > 0) {
                this.replacementAcrissSelected.forEach((acriss) => {
                    if (
                        acriss.carGroupId &&
                        this.replacementCarGroupSelected.find((item) => item.id === acriss.carGroupId) === undefined
                    ) {
                        this.replacementCarGroupSelected.push(
                            this.selectList.carGroupList.find((item) => item.id === acriss.carGroupId)
                        );
                    }
                });
                this.parameterSetting.replacementCarGroupIds = this.replacementCarGroupSelected.map((item) => item.id);
            }

            this.manageSelections(
                null,
                null,
                "replacementCarGroupSelected",
                "customReplacementCarGroupList",
                this.selectList.carGroupList
            );
        },
        checkForm() {
            if (
                this.parameterSetting.parameterType === constants.parameterType.group &&
                this.parameterSetting.carGroupIds.length > 1
            ) {
                this.$notify({
                    text: this.txt.form.errorCarGroupMustBeOne,
                    type: "warn",
                });
                return false;
            }

            return true;
        },
        handleSubmit() {
            this.createParameterSetting(false); 
        },
        createParameterSetting(isOverride = false) {
            if (this.checkForm()) {
                Loading.starLoading();
                let url = this.routing.generate("parameterSettings.store");
                let formData = new FormData();
                formData.set("startDate", this.parameterSetting.startDate);
                formData.set("endDate", this.parameterSetting.endDate);
                formData.set("parameterTypeId", this.parameterSetting.parameterType);
                formData.set("parameter", this.parameterSetting.parameter);
                formData.append("isOverride",isOverride);
                this.parameterSetting.carGroupIds.forEach((item) => {
                    formData.append("carGroupIds[]", item);
                });
                this.parameterSetting.acrissIds.forEach((item) => {
                    formData.append("acrissIds[]", item);
                });
                this.parameterSetting.replacementCarGroupIds.forEach((item) => {
                    formData.append("replacementCarGroupIds[]", item);
                });
                this.parameterSetting.replacementAcrissIds.forEach((item) => {
                    formData.append("replacementAcrissIds[]", item);
                });
                this.parameterSetting.regionIds.forEach((item) => {
                    formData.append("regionIds[]", item);
                });
                this.parameterSetting.areaIds.forEach((item) => {
                    formData.append("areaIds[]", item);
                });
                this.parameterSetting.branchIds.forEach((item) => {
                    formData.append("branchIds[]", item);
                });
                this.parameterSetting.partnerIds.forEach((item) => {
                    formData.append("partnerIds[]", item);
                });
                formData.set("startTime", this.parameterSetting.startTime);
                formData.set("endTime", this.parameterSetting.endTime);
                formData.set("connectedVehicle", this.parameterSetting.connectedVehicle);

                this.axios
                    .post(url, formData)
                    .then((response) => {
                        Loading.endLoading();
                        if (response.status == 200) {
                            this.$notify({
                                text: this.txt.form.parameterSettingCreatedSuccessNotification,
                                type: "success",
                            });

                            setTimeout(() => {
                                window.location.href = this.routing.generate("parameterSettings.list");
                            }, 2000);
                        } else {
                            this.$notify({
                                text: this.txt.form.errorCreatingparameterSettingNotification,
                                type: "error",
                            });
                        }
                    })
                    .catch((error) => {
                        Loading.endLoading();

                        let errorMessage = this.txt.form.errorCreatingparameterSettingNotification;
                        if (error.response.status === 460) {
                            errorMessage += error.response.data.message;
                        }
                        if(error.response.status === 400) {
                            this.conflictingParams = error.response.data.conflictingParams;
                            this.conflictMessage = error.response.data.message;
                            this.showConflictModal = true;
                            this.$nextTick(() => {
                                $('#modal-parameter-conflict').modal('show');
                            });
                            
                        } else {
                            this.$notify({
                                text: errorMessage,
                                type: "error",
                            });
                        }
                    });
            }
        },
        overrideAndSave() {
            this.closeConflictModal();
            this.createParameterSetting(true);
            
        },
        closeConflictModal() {
            this.showConflictModal = false;
            this.conflictMessage = '';
            this.conflictingParams = [];
            $('#modal-parameter-conflict').modal('hide');
        },
    },
};
</script>

<style scoped></style>
