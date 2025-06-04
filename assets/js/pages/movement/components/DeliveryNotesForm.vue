<template>
    <fragment>
        <input-file-pond
            v-if="!fileUploaded || onChange"
            @init="inputRef = $event"
            @ajaxOnload="uploadSuccess"
            @ajaxError="uploadError"
            ref="inputFilePond"
            name="file"
            id="file"
            :accepted-files="acceptedFiles"
            :server="
                routing.generate('movement.deliveryNotes.update', {
                    movementId: this.movementId,
                    id: this.deliveryNoteId,
                    typeId: this.typeId,
                    typeName: this.deliveryNoteType,
                })
            "
            max-files="1"
            div-class="col-12"
        />

        <div v-if="onChange" class="col-12 mt-3">
            <button
                @click="(changingDeliveryNote = !changingDeliveryNote), inputRef.removeFile()"
                type="button"
                class="btn btn-dark btn-block"
                v-text="txt.form.undo"
            ></button>
        </div>

        <div class="col-12 mt-3" v-else>
            <div v-if="deliveryNoteData" class="dropdown">
                <button
                    type="button"
                    id="deliveryNoteMenuButton"
                    class="btn btn-record btn-block"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                    v-text="deliveryNoteData.name"
                ></button>

                <div class="dropdown-menu" aria-labelledby="deliveryNoteMenuButton">
                    <a
                        class="dropdown-item align-items-center"
                        target="_blank"
                        :download="deliveryNoteData.name"
                        :title="txt.form.download"
                        :href="deliveryNoteData.url"
                    >
                        <i class="flaticon-download"></i> {{ txt.form.download }}
                    </a>
                    <a
                        @click="changingDeliveryNote = !changingDeliveryNote"
                        class="dropdown-item align-items-center"
                        href="javascript:void(0);"
                    >
                        <i class="flaticon-edit"></i> {{ txt.form.change }}
                    </a>
                    <a @click="removeDeliveryNote" class="dropdown-item align-items-center" href="javascript:void(0);">
                        <i class="flaticon-cancel"></i> {{ txt.form.remove }}
                    </a>
                </div>
            </div>
        </div>
    </fragment>
</template>

<script>
import moment from "moment";
import Loading from "../../../../assets/js/utilities";
import InputFilePond from "../../../../SharedAssets/vue/components/base/inputs/InputFilePond.vue";

export default {
    name: "DeliveryNotesForm",
    components: {
        InputFilePond,
    },
    props: {
        movementId: {
            type: null,
            required: true,
        },
        typeId: {
            type: Number,
            required: true,
        },
        deliveryNote: {
            type: Object,
            required: false,
            validator: function(value) {
                return value.file !== null && value.typeId !== null;
            },
        },
    },
    data() {
        return {
            txt: {},
            constants,
            acceptedFiles: [],
            inputRef: null,
            deliveryNoteData: null,
            changingDeliveryNote: false,
        };
    },
    computed: {
        deliveryNoteType() {
            return constants.deliveryNoteType[this.typeId];
        },
        deliveryNoteId() {
            return this.deliveryNoteData?.id || null;
        },
        fileUploaded() {
            return !!this.deliveryNoteData;
        },
        onChange() {
            return !!this.deliveryNoteData && this.changingDeliveryNote;
        },
    },
    created() {
        this.txt = txtTrans;
        this.acceptedFiles = [
            ".pdf",
            "text/pdf",
            "application/pdf",
            ".jpg",
            "image/jpeg",
            ".png",
            "image/png",
            ".webp",
            "image/webp",
        ];
    },
    methods: {
        uploadError(response) {
            let result = JSON.parse(response);

            this.$notify({
                title: this.txt.titles.deliveryManagement,
                type: "error",
                text: `${this.txt.form.errorUploadingDeliveryNotesNotification} ${String(
                    this.txt.form[`deliveryNote${this.deliveryNoteType}`]
                ).toLowerCase()}. \n${result.message}`,
            });
        },
        uploadSuccess(response) {
            let result = JSON.parse(response);

            this.$notify({
                title: this.txt.titles.deliveryManagement,
                type: "success",
                text: `${this.txt.form[`deliveryNote${this.deliveryNoteType}`]} ${
                    this.txt.form.deliveryNotesUploadedSuccessNotification
                }`,
            });

            this.deliveryNoteData.url = `data:${result.fileType};base64,${result.file}`;
            this.deliveryNoteData.name = result.name;
            this.changingDeliveryNote = false;
        },
        removeDeliveryNote() {
            window.swal
                .fire({
                    title: this.txt.form.removeDeliveryNote,
                    text: this.txt.form.removeDeliveryNoteQuestion,
                    type: "warning",
                    confirmButtonText: this.txt.form.continue,
                    confirmButtonColor: "#5867dd",
                    showCancelButton: true,
                    cancelButtonText: this.txt.form.cancel,
                    cancelButtonColor: "#d33",
                })
                .then((result) => {
                    if (result.value) {
                        Loading.starLoading();

                        this.axios
                            .post(
                                this.routing.generate("movement.deliveryNotes.delete", {
                                    movementId: this.movementId,
                                    deliveryNoteId: this.deliveryNoteData.id,
                                })
                            )
                            .then((response) => {
                                console.log(`Delete Delivery Note: ${this.deliveryNoteType}`, response);
                                Loading.endLoading();

                                this.$notify({
                                    title: this.txt.titles.deliveryManagement,
                                    type: "success",
                                    text: `${this.txt.form[`deliveryNote${this.deliveryNoteType}`]} ${
                                        this.txt.form.deliveryNotesDeletedSuccessNotification
                                    }`,
                                });

                                this.deliveryNoteData = null;
                            })
                            .catch((error) => {
                                console.log(error.response);
                                Loading.endLoading();

                                let errorMessage = `${this.txt.form.errorDeletingDeliveryNotesNotification} ${
                                    this.txt.form[`deliveryNote${this.deliveryNoteType}`]
                                }`;

                                if (error.response.status === 460) {
                                    errorMessage += `. \n${error.response.data.message}`;
                                }

                                this.$notify({
                                    title: this.txt.titles.deliveryManagement,
                                    type: "error",
                                    text: errorMessage,
                                });
                            });
                    }
                });
        },
    },
    watch: {
        deliveryNote: {
            handler: function(dn) {
                if (dn) {
                    this.deliveryNoteData = {};
                    this.deliveryNoteData.id = dn.id;
                    this.deliveryNoteData.typeId = dn.typeId;
                    this.deliveryNoteData.url = dn.file + constants.azure.token;
                    this.deliveryNoteData.name = `Albaran_${this.movementId}_${dn.typeName
                        .replace(/\s/g, "")
                        .toLowerCase()}_${moment(dn.uploadDate, "DD/MM/YYYY").format("DD-MM-YYYY")}`;
                }
            },
            immediate: true,
        },
    },
};
</script>

<style scoped></style>
