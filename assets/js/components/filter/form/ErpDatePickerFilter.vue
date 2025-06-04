<template>
    <div :class="classNumber">
        <div class="row mb-3 justify">
            <label class="col-12 col-form-label" :for="id" v-text="label"></label>
            <div class="col-12">
                <div class="input-group date">
                    <input type="text" :value="value" class="form-control date" :name="name" :id="id" readonly=""
                           :placeholder="placeholder">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ErpDatePickerFilter",
    props: {
        label: String,
        id: String,
        name: String,
        value: String,
        format: String,
        placeholder: String,
        orientation: {
            type: String,
            default: "bottom left"
        },
        classNumber: {
            type: String,
            default: 'col-lg-2'
        },
        limitStartDay: [Date, String],
        limitEndDay: [Date, String],
    },
    data() {
        return {
            el: null
        }
    },
    mounted() {
      this.el = $(`#${this.id}`);
      let $this = this;
      this.el.datepicker(this.getPropertiesDataPicker()).on('changeDate', function (e) {
        $this.$emit('updateDatePicker', e);
      });
    //   this.el.datepicker(this.getPropertiesDataPicker()).on('clearDate', function (e) {
    //     $this.$emit('updateDatePicker', e);
    //   });
    },
    methods: {
        getPropertiesDataPicker() {
            let obj = {
                format: this.format || 'dd/mm/yyyy',
                language: 'es',
                orientation: this.orientation,
                todayHighlight: true,
                autoclose: true,
                clearBtn: true
            };
            if (this.limitStartDay) {
                obj['startDate'] = this.limitStartDay;
            }

            if (this.limitEndDay) {
                obj['endDate'] = this.limitEndDay;
            }

            if (this.format && this.format.toLowerCase() === 'yyyy') {
                Object.assign(obj, {viewMode: "years", minViewMode: "years"})
            }
            return obj;
        }
    },
    watch: {
        limitEndDay() {
          let $this = this;
          this.el.datepicker('destroy').datepicker(this.getPropertiesDataPicker()).on('changeDate', function (e) {
            $this.$emit('updateDatePicker', e);
          });
        },
        limitStartDay() {
          let $this = this;
          this.el.datepicker('destroy').datepicker(this.getPropertiesDataPicker()).on('changeDate', function (e) {
            $this.$emit('updateDatePicker', e);
          });
        }
    }
}
</script>

<style scoped>

</style>