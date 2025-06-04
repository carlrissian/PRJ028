<template>
    <!-- TODO sería ideal aplicar constantes del tipo de DeliveryNote -->
    <erp-modal :title="txt.titles.deliveryManagement" id="modal-delivery-notes">
        <template slot="body">
            <div class="row">
                <div class="col-md-6 col-sm-12 text-center">
                    <h5 class="mb-3" v-text="txt.form.deliveryNotePickUp"></h5>
                    <delivery-notes-form :movement-id="row.id" :typeId="1" :delivery-note="deliveryNotePickUp" />
                </div>
                <div class="col-md-6 col-sm-12 text-center">
                    <h5 class="mb-3" v-text="txt.form.deliveryNoteDropOff"></h5>
                    <delivery-notes-form :movement-id="row.id" :typeId="2" :delivery-note="deliveryNoteDropOff" />
                </div>
            </div>
        </template>
    </erp-modal>
</template>

<script>
import ErpModal from "../../../../../SharedAssets/vue/components/modal/ErpModal.vue";
import DeliveryNotesForm from "../DeliveryNotesForm.vue";

export default {
    name: "ModalDeliveryNotesMovement",
    components: {
        ErpModal,
        DeliveryNotesForm,
    },
    props: {
        row: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            txt: {},
            deliveryNotePickUp: null,
            deliveryNoteDropOff: null,
        };
    },
    created() {
        this.txt = txtTrans;
    },
    watch: {
        // TODO sería ideal aplicar constantes del tipo de DeliveryNote
        row() {
            if (this.row.deliveryNotes.length > 0) {
                this.row.deliveryNotes.forEach((element) => {
                    switch (element.typeId) {
                        case 1:
                            this.deliveryNotePickUp = element;
                            break;
                        case 2:
                            this.deliveryNoteDropOff = element;
                            break;
                    }
                });
            }
        },
    },
};
</script>

<style scoped></style>
