<template>
    <div :class="classNumber">
        <div class="row mb-3 justify">
            <label class="col-2 col-form-label" :for="id" v-text="label"></label>
            <div class="col-4">
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
        name: "ErpYear",
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
                default: 'col-lg-3'
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
            this.el.datepicker(this.getPropertiesDataPicker());
            let $this = this;
            this.el.on('changeDate', function (e) {
                $this.$emit('updateDatePicker', e);
            });
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

                if (this.format && this.format.toLowerCase() === 'yyyy') {
                    Object.assign(obj, {viewMode: "years", minViewMode: "years"})
                }
                return obj;
            }
        },


    }
</script>

<style scoped>

</style>