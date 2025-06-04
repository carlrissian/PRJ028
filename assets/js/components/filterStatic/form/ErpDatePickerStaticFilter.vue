<template>
    <div v-if="disabled" :class="classNumber ? `col-md-${classNumber}` : 'col-md-3'">
        <div class="form-group">
            <label class="control-label" :for="id" v-text="label"></label>
            <div class="input-group date">
                <input type="text"  class="form-control date" :name="name" :id="id" :value="value" :placeholder="placeholder" disabled :required="required" :autocomplete="autocomplete">
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="la la-calendar"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div v-else :class="classNumber ? `col-md-${classNumber}` : 'col-md-3'">
        <div class="form-group">
            <label class="control-label" :for="id" v-text="label"></label>
            <div class="input-group date">
                <input type="text"  class="form-control date" :name="name" :id="id"  :value="value" :placeholder="placeholder" :required="required" :autocomplete="autocomplete">
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="la la-calendar"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpDatePickerStaticFilter",
        props: {
            classNumber: String,
            label: String,
            id: String,
            name: String,
            value: String,
            format: String,
            placeholder: String,
            limitStartDay: [Date, String],
            limitEndDay: [Date, String],
            disabled: false,
            autocomplete: String,
            required: {
                type: Boolean,
                default: false
            }
        },
        data() {
          return {
              el: null
          }
        },
        mounted() {
            this.el = $(`#${this.id}`);
            this.el.datepicker(this.getPropertiesDataPicker());
            let $this = this;
            this.el.on('changeDate', function(e)  {
                $this.$emit('updateDatePicker', e);
            });
        },
        methods: {
            getPropertiesDataPicker() {
                let obj = {
                    format: this.format || 'dd/mm/yyyy',
                    language: 'es',
                    orientation:"bottom left",
                    todayHighlight: true,
                    autoclose: true,
                };
                if (this.limitStartDay) {
                    obj['startDate'] = this.limitStartDay;
                }

                if (this.limitEndDay) {
                    obj['endDate'] = this.limitEndDay;
                }

                if (this.format && this.format.toLowerCase() === 'yyyy') {
                    Object.assign(obj, { viewMode: "years", minViewMode: "years" })
                }
                return obj;
            }
        },
        watch: {
            limitEndDay() {
                this.el.datepicker('destroy').datepicker(this.getPropertiesDataPicker());
            },
            limitStartDay() {
                this.el.datepicker('destroy').datepicker(this.getPropertiesDataPicker());
            }
        }
    }
</script>

<style scoped>
</style>
