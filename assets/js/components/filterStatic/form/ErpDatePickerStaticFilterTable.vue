<template>
    <div :class="classNumber ? `col-md-${classNumber}` : 'col-md-3'">
            <div class="input-group date table">
                <input type="text" class="form-control date" :name="name" :id="id" readonly="" :value="value" :placeholder="placeholder" >
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="la la-calendar"></i>
                    </span>
                </div>
            </div>
    </div>
</template>

<script>
    export default {
        name: "ErpDatePickerStaticFilterTable",
        props: {
            classNumber: String,
            label: String,
            id: String,
            name: String,
            value: String,
            format: String,
            placeholder: String,
            limitStartDay: [Date, String],
            limitEndDay: [Date, String]
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

            this.el.on('clearDate', () => {
                this.$emit('updateDatePicker', null);
            })
        },
        methods: {
            getPropertiesDataPicker() {
                let obj = {
                    format: this.format || 'dd/mm/yyyy',
                    language: 'es',
                    orientation:"bottom left",
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
    .table .form-group, .table .input-group {
        margin-bottom: 0 !important;
    }
</style>