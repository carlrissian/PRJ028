<template>
  <div>
    <panel :title="title">
      <one-way-stop-sale-form
        v-if="mode === 'oneway'"
        :select-list="selectList"
        :stop-sale-data="stopSaleData"
      />
      <standard-stop-sale-form
        v-else
        :select-list="selectList"
        :stop-sale-data="stopSaleData"
      />
    </panel>
  </div>
</template>

<script>
import OneWayStopSaleForm from './OneWayStopSaleForm.vue';
import StandardStopSaleForm from './StandardStopSaleForm.vue';

export default {
  name: 'CreateEditStopSalePage',
  components: {
    OneWayStopSaleForm,
    StandardStopSaleForm
  },
  props: {
    selectList:       { type: Object, required: true },
    stopSaleData:     { type: Object, default: null },
    categoryId:       { type: Number, required: true },
    stopSaleName:     { type: String, required: true },
    userCountryIso:   { type: String, required: true }
  },
  data() {
    return {
      mode: 'oneway',
      title: ''
    };
  },
  created() {
    if (this.stopSaleData) {
      this.mode = this.stopSaleData.mode;
      this.title = this.stopSaleData.mode === 'oneway'
        ? `Editar ${this.stopSaleName}`
        : `Editar Stop Sale estándar`;
    } else {
      this.mode = this.categoryId === parseInt(constants.STOPSALECAT_ONEWAY, 10)
        ? 'oneway'
        : 'standard';
      this.title = this.stopSaleName;
    }
  }
};
</script>
<style scoped></style>
