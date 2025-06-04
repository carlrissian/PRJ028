<template>
    <erp-modal :title="txt.detailMovement" modal-id="modal-create-movement" :size="modalSize.XXL">
        <template slot="body">
            <div class="kt-portlet__body">
                <table class="table table-bordered" style="width: 100%" v-html="renderBody()"></table>
            </div>
        </template>
        <template slot="footer">
            <div class="kt-align-right">
                <button @click.prevent="sendParams" style="" id="btn-create-modal" class="btn btn-dark kt-label-bg-color-4">
                    {{ txt.title }} {{ txt.movement }}
                </button>
            </div>
        </template>
    </erp-modal>
</template>

<script>
// TODO eliminar este componente cuando se revise movimientos por Operación
import ErpModal from "../../../../components/modal/ErpModal";
import { MODAL_SIZE } from "../../../../helpers/constants";

export default {
    name: "ModalCarrierMovement",
    components: { ErpModal },
    props: {
        dataTable: null,
    },
    watch: {
        dataTable() {
            this.renderBody();
        },
    },
    mounted() {
        this.txt = txtTrans.txtForm.carrier;
    },
    data() {
        return {
            txt: {},
            modalSize: MODAL_SIZE,
        };
    },
    methods: {
        renderBody() {
            let items = this.dataTable;
            let html = "";
            html += `</tr>`;
            for (let i = 0; i < items.length; i++) {
                let keys = Object.keys(items[i]);
                html += `
             <td style="font-weight: bold">${keys}</td>  <td>${items[i][keys]}</td>
           `;
                if (i % 4 == 0) {
                    html += `</tr><tr>`;
                }
            }
            html += `</tr>`;
            return html;
        },
        sendParams() {
            this.$emit("sendForm");
        },
    },
};
</script>

<style scoped></style>
