<template>
    <erp-modal
        modal-id="modal-parameter-conflict" 
        id="modal-parameter-conflict"
        :title="txt.titles.conflictParameter"
        :size="modalSize.LG"
        use-form
        :submit-prevent="confirmOverride"
        >

      <template #body>
        <div class="form-group col-md-12">
          <p v-html="message"></p>
        </div>
      </template>
  
      <template #footer>
        <div class="kt-align-right">
          <button
            type="button"
            class="btn btn-secondary"
            @click="cancel"
            v-text="txt.form.keepEditing"
            />
          <button
            type="submit"
            class="btn btn-danger"
            v-text="txt.form.overrideAndSave"
          />
        </div>
      </template>
    </erp-modal>
  </template>
  
  <script>
  import ErpModal from '../../../../SharedAssets/vue/components/modal/ErpModal.vue';
  import { MODAL_SIZE } from '../../../helpers/constants';
  
  export default {
    name: 'ModalParameterConflict',
    components: { ErpModal },
    props: {
      message: { type: String, required: true },
      onConfirm: { type: Function, required: true },
    },
    data() {
      return {
        txt: {
          titles: {
            conflictParameter: 'Conflicto de parámetro',
          },
          form: {
            overrideAndSave: 'Borrar parámetro(s) y guardar',
            keepEditing: 'Seguir editando',
          },
        },
        modalSize: MODAL_SIZE,
      };
    },
    mounted() {
        console.log('Mensaje recibido:', this.message);
    },
    methods: {
      confirmOverride() {
        this.onConfirm();
      },
      cancel() {
        this.$emit('cancel');
      },
    },
  };
  </script>
  