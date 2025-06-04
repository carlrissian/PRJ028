<template>
    <div :class=" classNumber ? `col-md-${classNumber}` : 'col-md-4'">
        <div class="form-group">
            <label class="control-label" :for="id" v-text="label"></label>
            <div class="input-group date">
                <input type="text"  class="form-control date" :name="name" :id="id" readonly="" :value="value" :placeholder="placeholder" >
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
        name: "ErpDatePickerModal",
        props: {
            classNumber: String,
            label: String,
            id: String,
            name: String,
            value: String,
            format: String,
            placeholder: String,
            // FIXME no se pueden usar estas propiedaes como en ErpDatePickerFilter. Sería ideal realizar un componente definitivo para V2
            limitStartDay: Date,
            limitEndDay: Date
        },
        mounted() {
            let el = $(`#${this.id}`);
            el.datepicker(this.getPropertiesDataPicker());
            let $this = this;
            el.on('changeDate', function(e)  {
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
                    autoclose: true
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
        }
    }
</script>

<style scoped>
</style>