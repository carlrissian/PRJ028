<template>
    <erp-modal :title="translations.deleteGroup" modal-id="modal-delete-carGroup">
        <template slot="body">
            <p>{{ translations.questionDeleteGroup }}</p>
        </template>
        <template slot="footer">
            <div class="kt-align-right">
                <button @click.prevent="sendParams" type="submit" style="" id="btn-create-modal" class="btn btn-dark kt-label-bg-color-4">
                    {{ translations.delete }}</button>
            </div>
        </template>
    </erp-modal>
</template>

<script>
import ErpModal from "../../../components/modal/ErpModal";
export default {
    name: "DeleteCarGroupModal",
    components: {ErpModal},
    props: {
      row: {}
    },
    data() {
        return {
            translations: {}
        }
    },
    mounted() {
        this.translations = txtTrans.txtDeleteModal;
    },
    methods: {
        sendParams() {
            let form = document.createElement('form');
            form.setAttribute('method', 'POST');
            form.setAttribute('action', this.routing.generate('carGroup.delete'));

            let input = document.createElement('input');
            input.setAttribute('type', 'hidden');
            input.setAttribute('name', 'carGroupId');
            input.setAttribute('value', this.row.id);

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    }
}
</script>

<style scoped>

</style>