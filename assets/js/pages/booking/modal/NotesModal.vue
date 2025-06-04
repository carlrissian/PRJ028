<template>
    <erp-modal :title="title" modal-id="bookingModalNotes">
        <template slot="body">
            <template v-for="note in noteData">
                <div class="row mt-3">
                    <div class="col-auto">
                        <p><strong>{{ note.date }}</strong></p>
                    </div>
                    <div class="col">
                        <p><strong>{{ note.userName }} {{ note.userLastName }}</strong></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <p>{{ note.text }}</p>
                    </div>
                </div>
            </template>
        </template>
    </erp-modal>
</template>
<script>
    import ErpModal from "../../../components/modal/ErpModal";
    export default {
        name: "ModalNotes",
        components: {ErpModal},
        props: {
            title: String,
            noteData: Array
        },
    }
</script>
<style scoped>
</style>