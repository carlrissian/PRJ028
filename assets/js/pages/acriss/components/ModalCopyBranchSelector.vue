<template>
    <erp-modal
      modal-id="modal-copy-branch-selector"
      id="modal-copy-branch-selector"
      :title="txt.titles.selectBranches"
      :size="modalSize.LG"
    >
      <template #body>
        <div class="form-group col-md-12">
          <multiple-select-picker
            id="branchPicker"
            name="branchPicker"
            :label="txt.labels.branchList"
            :url="routing.generate('branch.selectList')"
            v-model="selectedBranchIds"
            :disabled-options="true"
            :data-size="10"
            :return-object="true"
            :value="selectedBranchIds"
            @updatedMultipleSelectPicker="selectedBranchIds = $event"
          />
        </div>
      </template>
  
      <template #footer>
        <div class="kt-align-right">
          <button
            type="button"
            class="btn btn-secondary"
            @click="cancel"
            v-text="txt.form.cancel"
          />
          <button
            type="button"
            class="btn btn-primary"
            @click="confirmSelection"
            v-text="txt.form.confirm"
          />
        </div>
      </template>
    </erp-modal>
  </template>
  
  <script>
import MultipleSelectPicker from '../../../../SharedAssets/vue/components/base/inputs/MultipleSelectPicker.vue';
import ErpModal from '../../../components/modal/ErpModal.vue';
import { MODAL_SIZE } from '../../../helpers/constants';
  export default {
    name: 'ModalCopyBranchSelector',
    components: {
      ErpModal,
      MultipleSelectPicker,
    },
    props: {
      onConfirm: {
        type: Function,
        required: true,
      },
      sourceBranchId: {
        type: Number,
        default: null
      },
    },
    data() {
      return {
        selectedBranchIds: [],
        txt: {
          titles: {
            selectBranches: 'Seleccionar delegaciones a copiar',
          },
          labels: {
            branchList: 'Delegaciones disponibles',
          },
          form: {
            confirm: 'Copiar parámetros',
            cancel: 'Cancelar',
          },
        },
        modalSize: MODAL_SIZE,
      };
    },
    methods: {
      confirmSelection(event) {
        event.preventDefault();
        this.onConfirm(this.selectedBranchIds);
      },
      cancel() {
        this.selectedBranchIds = [];
        this.$emit('cancel');
      },
    },
  };
  </script>