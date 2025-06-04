<template>
    <erp-modal :title="translations.deleteSeason" modal-id="modal-confirm-delete" :url="routing.generate('seasonDelete')"  method="POST" >
        <template slot="body">
            <p>{{ translations.questionDeleteSeason }}</p>
        </template>
        <template slot="footer">
            <div class="kt-align-right">
              <input type="hidden" :value="id" name="seasonId">
                <button type="submit"  style="" id="btn-deleted-modal" class="btn btn-danger">{{ translations.delete }} </button>
            </div>
        </template>
    </erp-modal>
</template>

<script>
    import ErpModal from "../../../components/modal/ErpModal";
    export default {
        name: "SeasonDeleteModal",
        components: {ErpModal},
        props: {
            id: Number
        },
        data(){
            return {
                translations: {}
            }
        },
        mounted() {
            this.translations = txtTrans.txtModals;
        }
    }
</script>

<style scoped>

</style>