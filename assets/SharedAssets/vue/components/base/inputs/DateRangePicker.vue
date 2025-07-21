<template>
  <div :class="divClass">
    <label v-if="label" :class="labelClass" :for="idFrom" v-text="label"></label>

    <!-- DATE MODE -->
    <div class="input-group" v-if="mode === 'date'">
      <input
          type="text"
          class="form-control date"
          :name="nameFrom"
          :id="idFrom"
          :placeholder="placeholder"
          v-model="dateFrom"
          @input="onInputChange('from', $event)"
          @blur="formatAndSetDate('from')"
          @keydown.enter="formatAndSetDate('from')"
          :readonly="readonly"
          :disabled="disabled"
          :required="required"
          autocomplete="off"
      />
      <div class="input-group-append">
      <span class="input-group-text" @click="showPicker(idFrom)">
        <i class="la la-calendar"></i>
      </span>
      </div>
      <span class="input-group-text px-2">→</span>
      <input
          type="text"
          class="form-control date"
          :name="nameTo"
          :id="idTo"
          :placeholder="placeholder"
          v-model="dateTo"
          @input="onInputChange('to', $event)"
          @blur="formatAndSetDate('to')"
          @keydown.enter="formatAndSetDate('to')"
          :readonly="readonly"
          :disabled="disabled"
          :required="required"
          autocomplete="off"
      />
      <div class="input-group-append">
      <span class="input-group-text" @click="showPicker(idTo)">
        <i class="la la-calendar"></i>
      </span>
      </div>
    </div>

    <!-- NUMBER OR OTHER MODE -->
    <div class="input-group" v-else>
      <input
          :type="mode"
          class="form-control"
          :name="nameFrom"
          :id="idFrom"
          :placeholder="'Desde'"
          v-model="dateFrom"
          @input="onInputChange('from', $event)"
          @blur="emitUpdated('from')"
          :readonly="readonly"
          :disabled="disabled"
          :required="required"
      />
      <span class="input-group-text px-2">→</span>
      <input
          :type="mode"
          class="form-control"
          :name="nameTo"
          :id="idTo"
          :placeholder="'Hasta'"
          v-model="dateTo"
          @input="onInputChange('to', $event)"
          @blur="emitUpdated('to')"
          :readonly="readonly"
          :disabled="disabled"
          :required="required"
      />
    </div>
  </div>
</template>

<script>
import moment from "moment";

export default {
  name: "DateRangePicker",
  props: {
    nameFrom: String,
    nameTo: String,
    idFrom: String,
    idTo: String,
    valueFrom: String,
    valueTo: String,
    label: String,
    divClass: {
      type: String,
      default: "form-group",
    },
    labelClass: {
      type: String,
      default: "control-label",
    },
    format: {
      type: String,
      default: "DD/MM/YYYY",
    },
    placeholder: {
      type: String,
      default: "dd/mm/yyyy",
    },
    readonly: Boolean,
    disabled: Boolean,
    required: Boolean,
    mode: {
      type: String,
      default: "date", // or "number"
    },
    limitStartDay: [Date, String],
    limitEndDay: [Date, String],
  },
  data() {
    return {
      dateFrom: this.valueFrom,
      dateTo: this.valueTo,
      tempDateFrom: null,
      tempDateTo: null,
    };
  },
  mounted() {
    if (this.mode === "date") {
      this.initDatepicker(this.idFrom);
      this.initDatepicker(this.idTo);
    }
  },
  watch: {
    dateFrom(val) {
      this.updateToPickerStartDate(val);
    },
    valueFrom(val) {
      this.dateFrom = val;
    },
    valueTo(val) {
      this.dateTo = val;
    },
    limitStartDay() {
      this.refreshPickers();
    },
    limitEndDay() {
      this.refreshPickers();
    },
  },
  methods: {
    initDatepicker(id) {
      const options = {
        format: this.format.toLowerCase(),
        language: "es",
        orientation: "bottom auto",
        todayHighlight: true,
        autoclose: true,
        clearBtn: true,
      };

      if (this.limitStartDay) {
        options.startDate = this.limitStartDay;
      }
      if (this.limitEndDay) {
        options.endDate = this.limitEndDay;
      }

      const $el = $(`#${id}`);
      $el.datepicker(options);
      $el.on("changeDate", (e) => {
        const newDate = e.target.value;
        if (id === this.idFrom) {
          this.dateFrom = newDate;
          this.$emit("updatedForm", newDate);
        } else {
          this.dateTo = newDate;
          this.$emit("updatedTo", newDate);
        }
      });
    },
    updateToPickerStartDate(date) {
      if (this.mode === "date") {
        const $toPicker = $(`#${this.idTo}`);
        $toPicker.datepicker("setStartDate", date);
      }
    },
    refreshPickers() {
      if (this.mode === "date") {
        $(`#${this.idFrom}`).datepicker("destroy");
        $(`#${this.idTo}`).datepicker("destroy");
        this.initDatepicker(this.idFrom);
        this.initDatepicker(this.idTo);
      }
    },
    onInputChange(which, e) {
      if (which === "from") {
        this.tempDateFrom = e.target.value;
      } else {
        this.tempDateTo = e.target.value;
      }
    },
    formatAndSetDate(which) {
      const input = which === "from" ? this.tempDateFrom : this.tempDateTo;
      if (!input) return;

      let formatted = input;
      const regex = /^(\d{1,2})(\d{1,2})(\d{2,4})$/;
      if (regex.test(formatted)) {
        formatted = formatted.replace(regex, "$1/$2/$3");
      }

      const formats = ["D/M/YYYY", "D-M-YYYY", "DMYYYY"];
      let momentDate = null;
      for (const f of formats) {
        momentDate = moment(formatted, f);
        if (momentDate.isValid()) break;
      }

      if (momentDate && momentDate.isValid()) {
        const finalDate = momentDate.format(this.format.toUpperCase());
        if (which === "from") {
          this.dateFrom = finalDate;
          this.$emit("updatedForm", finalDate);
          $(`#${this.idFrom}`).datepicker("update", finalDate);
        } else {
          this.dateTo = finalDate;
          this.$emit("updatedTo", finalDate);
          $(`#${this.idTo}`).datepicker("update", finalDate);
        }
      }

      if (which === "from") this.tempDateFrom = null;
      else this.tempDateTo = null;
    },
    emitUpdated(which) {
      if (which === "from") {
        this.$emit("updatedForm", this.dateFrom);
      } else {
        this.$emit("updatedTo", this.dateTo);
      }
    },
    showPicker(id) {
      const $el = $(`#${id}`);
      $el.focus();
      setTimeout(() => {
        $el.datepicker("show");
      }, 10);
    },
  },
};
</script>

<style scoped>
input:disabled {
  opacity: 0.65;
  cursor: not-allowed;
}
</style>
