<template>
    <erp-modal @onCloseModal="reset" id="modal-assign-vehicle-excel" :title="txt.titles.assignVehiclesExcel">
        <template slot="body">
            <div class="row text-center">
                <div class="col-md-12 col-lg-6">
                    <h3 v-text="this.txt.titles.downloadTemplate"></h3>
                    <button @click="downloadTemplate" type="button" class="btn btn-dark kt-label-bg-color-4 mb-5 download">
                        <i class="la la-download"></i>
                        {{ this.txt.form.download }}
                    </button>
                </div>

                <div class="col-md-12 col-lg-6">
                    <h3 v-text="this.txt.form.uploadExcel"></h3>
                    <div class="row">
                        <input-file-pond
                            @processFileStart="flushMessages"
                            @ajaxOnload="success"
                            @ajaxError="failed"
                            ref="inputFilePond"
                            name="fileCSV"
                            id="fileCSV"
                            :accepted-files="acceptedFiles"
                            :server="routing.generate('movement.vehicleLine.assign.uploadCSV', { movementId: movementId })"
                            max-files="1"
                            div-class="col-md-6 col-sm-12 my-4 mx-auto"
                        />
                    </div>
                </div>
            </div>

            <alert v-if="successMessages !== null" @flush="successMessages = null" type="success">
                <template #text>
                    <p v-html="successMessages" style="margin: 0"></p>
                </template>
            </alert>

            <alert v-if="warningMessages !== null" @flush="warningMessages = null" type="warning">
                <template #text>
                    <p v-if="typeof warningMessages === 'string'" v-html="warningMessages" style="margin: 0"></p>
                    <p v-else v-for="message in warningMessages" v-html="message" style="margin: 0"></p>
                </template>
            </alert>

            <alert v-if="errorMessages !== null" @flush="errorMessages = null" type="danger">
                <template #text>
                    <p v-html="errorMessages" style="margin: 0"></p>
                </template>
            </alert>
        </template>
    </erp-modal>
</template>

<script>
import Alert from "../../../../../SharedAssets/vue/components/Alert.vue";
import ErpModal from "../../../../../SharedAssets/vue/components/modal/ErpModal.vue";
import InputFilePond from "../../../../../SharedAssets/vue/components/base/inputs/InputFilePond.vue";

export default {
    name: "ModalExcelAssignVehicle",
    components: {
        Alert,
        ErpModal,
        InputFilePond,
    },
    props: {
        movementId: Number,
    },
    data() {
        return {
            txt: txtTrans,
            acceptedFiles: [],
            successMessages: null,
            warningMessages: null,
            errorMessages: null,
            processFinished: false,
        };
    },
    created() {
        this.acceptedFiles = [
            ".csv",
            "text/csv",
            "application/csv",
            "text/comma-separated-values",
            "text/x-csv",
            "application/x-csv",
            "text/x-comma-separated-values",
            "application/vnd.ms-excel",
        ];
    },
    methods: {
        downloadTemplate() {
            location.href = this.routing.generate("movement.vehicleLine.assign.downloadTemplate");
        },
        reset() {
            if (this.processFinished) {
                this.flushMessages();
                this.$refs.inputFilePond.$refs.filepond.removeFiles();
                this.$emit("closed");
            }
        },
        flushMessages() {
            this.processFinished = false;
            this.successMessages = null;
            this.warningMessages = null;
            this.errorMessages = null;
        },
        failed(response) {
            this.processFinished = true;
            let resp = JSON.parse(response);

            if (resp.code === 500) {
                if (resp.data?.assign) {
                    let errorAssignVehicles = "";
                    resp.data.assign.forEach((vehicle) => {
                        errorAssignVehicles += `<li>${vehicle}</li>`;
                    });
                    this.errorMessages = `${this.txt.form[resp.message]}:<br><ul>${errorAssignVehicles}</ul>`;
                    if (resp.data?.reason) this.errorMessages += `${this.txt.form.reason}: ${resp.data.reason}`;
                }
                if (resp.data?.affectedVehicles.notAssigned) {
                    let notAssignedVehicles = "";
                    resp.data.affectedVehicles.notAssigned.forEach((vehicle) => {
                        notAssignedVehicles += `<li>${vehicle}</li>`;
                    });
                    this.warningMessages = `${this.txt.form.notAssignedVehicles}:<br><ul>${notAssignedVehicles}</ul>`;
                }
            } else {
                this.warningMessages = resp.data;
            }
        },
        success(response) {
            this.processFinished = true;
            let resp = JSON.parse(response);

            if (resp.affectedVehicles.assigned.length > 0) {
                let assignedVehicles = "";
                resp.affectedVehicles.assigned.forEach((vehicle) => {
                    assignedVehicles += `<li>${vehicle}</li>`;
                });

                this.successMessages = `${this.txt.form[resp.messages]}.<br>${
                    this.txt.form.assignedVehicles
                }:<br><ul>${assignedVehicles}</ul>`;
            }

            if (resp.affectedVehicles.notAssigned.length > 0) {
                let notAssignedVehicles = "";
                resp.affectedVehicles.notAssigned.forEach((vehicle) => {
                    notAssignedVehicles += `<li>${vehicle}</li>`;
                });

                this.warningMessages = `${this.txt.form.notAssignedVehicles}:<br><ul>${notAssignedVehicles}</ul>`;
            }
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
