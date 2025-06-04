<template>
    <div :class="classNumber ? `col-md-${classNumber}` : 'col-md-1'">
        <label></label>
        <div class="kt-checkbox-inline">
            <label class="kt-checkbox control-label" :for="id" v-bind:style="[styleMargin]">
                <input :checked="checked" class="form-control" :value="value" type="checkbox" :name="name" :id="id"> {{ label }}
                <span></span>
            </label>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpCheckboxStaticFilter",
        props: {
            classNumber: String,
            id: String,
            name: String,
            label: String,
            value: String,
            checked: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                styleMargin: {
                    marginBottom: '35px !important',
                },
            }
        }
    }
</script>

<style scoped>

</style>