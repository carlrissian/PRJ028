<template>
    <erp-modal :title="translations.addSeason" modal-id="modal-confirm-create" :method="'POST'" :url="routing.generate('seasonStore')" >
        <template slot="body">
            <div class="row">
                <erp-date-picker-modal class-number="3" id="startDateCreateModalId" name="startDateCreateModal" :label="translations.startDate" :limit-start-day="new Date()"/>
                <erp-date-picker-modal class-number="3" id="endDateCreateModalId" name="endDateCreateModal" :label="translations.endDate"/>
                <erp-select-modal class-number="3" id="locationsCreateModalId" name="locationsModal" :label="translations.location">
                    <option v-for="item in locations"  :value="item.id" v-text="item.name" :key="item.id"></option>
                </erp-select-modal>
                <erp-multiple-select-modal class-number="3" id="carGroupsCreateModalId" name="carGroupsId[]" :label="translations.groups">
                    <option v-for="item in carGroups"  :value="item.id" v-text="item.name" :key="item.id"></option>
                </erp-multiple-select-modal>
            </div>
        </template>
        <template slot="footer">
            <div class="kt-align-right">
                <button  type="submit" style="" id="btn-create-modal" class="btn btn-dark kt-label-bg-color-4">{{ translations.add }}</button>
            </div>
        </template>
    </erp-modal>
</template>

<script>
    import ErpModal from "../../../components/modal/ErpModal";
    import ErpMultipleSelectModal from "../../../components/modal/form/ErpMultipleSelectModal";
    import ErpDatePickerModal from "../../../components/modal/form/ErpDatePickerModal";
    import ErpSelectModal from "../../../components/modal/form/ErpSelectModal";
    export default {
        name: "SeasonCreateModal",
        components: {
            ErpSelectModal,
            ErpDatePickerModal,
            ErpMultipleSelectModal,
            ErpModal
        },
        props: {
            locations: Array,
            carGroups: Array,
        },
        data () {
            return {
                groupsIds: [],
                translations: {},
            }
        },
        mounted() {
            this.translations = txtTrans.txtModals;
        }
    }
</script>

<style scoped>

</style>