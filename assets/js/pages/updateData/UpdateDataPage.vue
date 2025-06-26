<template>
    <fragment>
        <notifications position="top right" />

        <div class="kt-portlet kt-portlet--bordered">
            <div class="kt-portlet__body">
                <div class="row text-center">
                    <div class="col-md-12 col-lg-6">
                        <h3 v-text="translations.titles.downloadTemplate"></h3>
                        <button @click="downloadTemplate" type="button" class="btn btn-dark kt-label-bg-color-4 mb-5 download">
                            <i class="la la-download"></i>
                            {{ translations.form.download }}
                        </button>
                    </div>

                    <div class="col-md-12 col-lg-6">
                        <h3 v-text="translations.titles.uploadExcel"></h3>
                        <div class="row">
                            <input-file-pond
                                @addedFile="flush"
                                @ajaxOnload="success"
                                @ajaxError="error"
                                ref="inputFilePond"
                                name="uploadExcel"
                                id="uploadExcel"
                                :accepted-files="acceptedFiles"
                                :server="routing.generate('updateData.uploadFile')"
                                :token="token"
                                max-files="1"
                                div-class="col-md-6 col-sm-12 my-4 mx-auto"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div v-show="showMessagesButtons" class="kt-portlet__foot">
                <div class="d-flex justify-content-start">
                    <button @click="showMessages = !showMessages" type="button" class="btn btn-dark kt-label-bg-color-4">
                        <i class="la" :class="{ 'la-angle-up': showMessages, 'la-angle-down': !showMessages }"></i>
                        {{ translations.form.showMessages }}
                    </button>
                    <button
                        @click="exportMessages"
                        type="button"
                        class="btn btn-icon btn-dark kt-label-bg-color-4 ml-2"
                        :title="translations.form.downloadMessages"
                    >
                        <i class="la la-download"></i>
                    </button>
                </div>
            </div>
        </div>

        <div v-if="showMessages">
            <alert v-if="successVehiclesList" type="success" class="mt-5" :closable="false">
                <template #text>
                    <p v-html="successVehiclesList" style="margin: 0"></p>
                </template>
            </alert>

            <alert v-if="warningMessages" type="warning" :closable="false">
                <template #text>
                    <p v-html="warningMessages" style="margin: 0"></p>
                </template>
            </alert>

            <alert v-if="errorVehiclesList" type="danger" class="mt-5" :closable="false">
                <template #text>
                    <p v-html="errorVehiclesList" style="margin: 0"></p>
                </template>
            </alert>
        </div>
    </fragment>
</template>

<script>
import Loading from "../../../assets/js/utilities";
import { downloadBlobFileButtonAction } from "../../../SharedAssets/js/utils.js";
import Alert from "../../../SharedAssets/vue/components/Alert.vue";
import InputFilePond from "../../../SharedAssets/vue/components/base/inputs/InputFilePond.vue";
import { htmlToText } from "html-to-text";

export default {
    name: "UpdateDataPage",
    components: {
        Alert,
        InputFilePond,
    },
    props: {
        token: String,
    },
    data() {
        return {
            translations,
            acceptedFiles: [],
            showMessages: false,
            warningMessages: null,
            successVehiclesList: null,
            errorVehiclesList: null,
        };
    },
    computed: {
        showMessagesButtons() {
            return [this.warningMessages, this.successVehiclesList, this.errorVehiclesList].some((message) => message !== null);
        },
    },
    created() {
        this.acceptedFiles = [
            ".xls",
            ".xlsx",
            "application/vnd.ms-excel",
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        ];
    },
    methods: {
        async downloadTemplate() {
            try {
                Loading.starLoading();
                const response = await this.axios.get(this.routing.generate("updateData.downloadTemplate"), {
                    responseType: "blob",
                });
                Loading.endLoading();

                const file = new Blob([response.data]);
                const filename = response?.headers["content-disposition"]?.split("filename=")[1] ?? "template.xslx";
                downloadBlobFileButtonAction(document, file, filename);
            } catch (error) {
                Loading.endLoading();
                let errorMessage = JSON.parse(await error.response.data.text());
                this.$notify({
                    title: errorMessage.error,
                    message: errorMessage.error,
                    type: "error",
                });
            }
        },
        flush() {
            this.showMessages = false;
            this.warningMessages = null;
            this.successVehiclesList = null;
            this.errorVehiclesList = null;
        },
        formatSuccessMessages(vehicles) {
            if (Array.isArray(vehicles) && vehicles.length > 0) {
                this.successVehiclesList = `<p>${translations.form.updatedVehicles}:</p>`;
                this.successVehiclesList += "<ul>";
                vehicles.forEach((vehicle) => {
                    this.successVehiclesList += `<li>${vehicle}</li>`;
                });
                this.successVehiclesList += "</ul>";
            }
        },
        formatWarningMessages(messages) {
            if (Array.isArray(messages) && messages.length > 0) {
                this.warningMessages = `<p>${translations.form.errorsFoundInExcel}:</p>`;
                this.warningMessages += "<ul>";
                messages.forEach((msg) => {
                    this.warningMessages += `<li>${msg}</li>`;
                });
                this.warningMessages += "</ul>";
            }
        },
        formatErrorMessages(vehicles) {
            if (Array.isArray(vehicles) && vehicles.length > 0) {
                this.errorVehiclesList = `<p>${translations.form.notUpdatedVehicles}:</p>`;
                this.errorVehiclesList += "<ul>";
                vehicles.forEach((vehicle) => {
                    this.errorVehiclesList += `<li>${vehicle}</li>`;
                });
                this.errorVehiclesList += "</ul>";
            }
        },
        error(response) {
            this.flush();
            let result = JSON.parse(response);

            this.$notify({
                type: "error",
                text: translations.form[result.message],
            });

            this.formatWarningMessages(result.vehicles);
            this.formatSuccessMessages(result.vehicles?.updated);
            this.formatErrorMessages(result.vehicles?.notUpdated);
            this.showMessages = true;
        },
        success(response) {
            this.flush();
            let result = JSON.parse(response);

            this.$notify({
                type: "success",
                text: translations.form[result.message],
            });

            this.formatSuccessMessages(result.vehicles.updated);
            this.showMessages = true;
        },
        exportMessages() {
            let messages = [this.successVehiclesList, this.warningMessages, this.errorVehiclesList]
                .filter((message) => message !== null)
                .join("<br><br>");
            const errors = htmlToText(messages);
            const blob = new Blob([errors], { type: "text/plain" });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = "update_vehicle_data_errors.txt";
            a.click();
            window.URL.revokeObjectURL(url);
        },
    },
};
</script>

<style>
.download {
    margin-top: 3em !important;
}

.filepond--root,
.filepond--root .filepond--drop-label {
    height: 80px;
}

.filepond--item {
    height: 50px;
}

.filepond--root .filepond--list-scroller {
    margin-top: 1.2em !important;
    height: 60px !important;
    z-index: 1;
}
</style>
