<template>
    <erp-modal :title="txt.titles.cancelMovement" id="modal-cancel-movement" use-form :submit-prevent="cancelMovement">
        <template slot="body">
            <!-- Cancelation notes -->
            <text-area
                @updatedTextArea="cancelationNotes = $event"
                name="cancelationNotes"
                id="cancelationNotes"
                divClass="form-group col-md-12"
                :cols="3"
                :rows="6"
                :label="txt.fields.cancelReason"
                :value="cancelationNotes"
                required
            />
            <!--  -->
            <!-- <div class="form-group">
                <label for="cancelationNotes" v-text="txt.fields.cancelReason"></label>
                <textarea class="form-control" id="cancelationNotes" rows="3" cols="6" v-model="cancelationNotes"></textarea>
            </div> -->
        </template>
        <template slot="footer">
            <div class="kt-align-right">
                <button type="submit" class="btn btn-dark kt-label-bg-color-4" v-text="txt.form.cancelMovement"></button>
            </div>
        </template>
    </erp-modal>
</template>

<script>
import Loading from "../../../../../assets/js/utilities";
import ErpModal from "../../../../../SharedAssets/vue/components/modal/ErpModal";
import TextArea from "../../../../../SharedAssets/vue/components/base/inputs/TextArea";

export default {
    name: "ModalCancelMovement",
    components: {
        ErpModal,
        TextArea,
    },
    props: {
        movementId: Number,
        movementTypeName: String,
        movementTypeId: Number,
        row: Object,
    },
    watch: {
        movementId: function() {
            this.cancelationNotes = null;
        },
    },
    data() {
        return {
            txt: {},
            constants,
            cancelationNotes: null,
        };
    },
    created() {
        this.txt = txtTrans;
    },
    methods: {
        checkForm() {
            let count = 0;

            if ([constants.movementType.carrier, constants.movementType.operation].includes(this.movementTypeId)) {
                $.each(this.row.vehicle, function(key, item) {
                    if (item.actualLoadDate !== null) {
                        count++;
                    }
                });
            }

            if (["", null, undefined].includes(this.cancelationNotes)) {
                this.$notify({
                    type: "warn",
                    text: this.txt.form.reasonCancellation,
                });

                return false;
            } else if (count > 0) {
                // Si tiene fechas de carga real
                this.$notify({
                    type: "warn",
                    text: this.txt.form.reasonLoadingDate,
                });

                return false;
            }

            return true;
        },
        async cancelMovement() {
            if (this.checkForm()) {
                Loading.starLoading();

                let url = this.routing.generate("movement.cancel", {
                    movementId: this.movementId,
                    cancelationNotes: this.cancelationNotes,
                });

                this.axios
                    .post(url)
                    .then((response) => {
                        // console.log("Cancel Movement: ", response);
                        Loading.endLoading();

                        if (response.data.cancelled) {
                            this.$notify({
                                type: "success",
                                text: this.txt.form.movementCancelledSuccessNotification,
                            });
                            $("#modal-cancel-movement").modal("hide");

                            setTimeout(() => {
                                window.location.href = this.routing.generate("movement.list", {
                                    movementType: this.movementTypeName,
                                });
                            }, 2000);
                        } else {
                            this.$notify({
                                type: "error",
                                text: this.txt.form.errorCancelingMovementNotification,
                            });
                        }
                    })
                    .catch((error) => {
                        console.error(error.response);
                        Loading.endLoading();
                        this.$notify({
                            type: "error",
                            text: `${this.txt.form.errorCancelingMovementNotification}.<br>${error.response.data.message}`,
                        });
                    });
            }
        },
    },
};
</script>

<style>
.modal-footer {
    border-top: none !important;
}
</style>
