<template>
    <div class="modal fade detail" :id="modalId ? modalId : 'erpModal'" tabindex="-1" role="dialog" aria-labelledby="modal-detail-label" aria-hidden="true">
        <div :class="'modal-dialog modal-'+size" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-detail-label" v-text="title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body detailTrafficCharge">
                    <form :method="method"  class="kt-form" :action="url" autocomplete="off">
                        <slot name="body"></slot>
                        <div class="modal-footer">
                            <slot name="footer"></slot>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default  {
        name: "ErpModal",
        props: {
            modalId: String,
            title: String,
            method: String,
            url: String,
            size: {
                default: 'lg',
                type: String
            }
        },
        methods:{
            onClose(){
                this.$emit('onCloseModal', this.modalId);
            },
        },mounted() {
            $("#"+this.modalId).on("hidden.bs.modal", this.onClose);
        },
    }
</script>

<style scoped>
    .modal-dialog.modal-xxl {
        max-width: 95% !important;
    }
</style>