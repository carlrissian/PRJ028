<template>
    <erp-modal :title="translations.editSeason" modal-id="modal-confirm-edit" :url="routing.generate('seasonUpdate')" :method="'POST'" >
        <template slot="body">
            <div class="row">
                <input v-if="row" type="hidden" :value="row.id" name="seasonId">
                <erp-select-modal class-number="3" id="locationsEditModalId" name="locationsEditModal" :label="translations.location">
                    <option v-for="item in locations" :value="item.id" v-text="item.name" :key="item.id" :selected="row ? row.locations === item.id : null"></option>
                </erp-select-modal>


                <erp-multiple-select-modal class-number="3" :value="row ? rowGroups : null" id="carGroupsEditModalId" name="carGroupsEditModal[]" :label="translations.groups">
                    <option v-for="item in carGroups"  :value="item.id" v-text="item.name" :key="item.id"></option>
                </erp-multiple-select-modal>

                <erp-date-picker-modal class-number="3" :value="row ? row.startDate : null" id="startDateEditModalId" name="startDateEditModal" :label="translations.startDate"/>
                <erp-date-picker-modal class-number="3" :value="row ? row.endDate : null" id="endDateEditModalId" name="endDateEditModal" :label="translations.endDate"/>
            </div>
        </template>
        <template slot="footer">
            <div class="kt-align-right">
                <button type="submit" style="" id="btn-edit-modal" class="btn btn-dark kt-label-bg-color-4">{{ translations.edit }}</button>
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
        name: "SeasonEditModal",
        components: {
            ErpSelectModal,
            ErpDatePickerModal,
            ErpMultipleSelectModal,
            ErpModal
        },
        props: {
            locations: Array,
            carGroups: Array,
            row: Object
        },
        data() {
          return {
              rowGroups: [],
              translations: {}
          }
        },
        mounted() {
          this.translations = txtTrans.txtModals;
        },
        watch: {
            row() {
                this.rowGroups = this.row.carGroupsId.map(val => {
                    return val.id;
                })
            }
        }
    }
</script>

<style scoped>

</style>