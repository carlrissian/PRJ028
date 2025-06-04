<template>
    <div v-if="disabled"  :class="classNumber ? `col-md-${classNumber}` : 'col-md-3'">
        <label class="control-label" :for="id" v-text="label"></label>
        <select @change="changeValue" class="form-control" :name="name" :id="id"  :required="required" data-live-search="true">
            <slot></slot>
        </select>
    </div>

    <div v-else  :class="classNumber ? `col-md-${classNumber}` : 'col-md-3'">
        <label class="control-label" :for="id" v-text="label"></label>
        <select @change="changeValue" class="form-control" :name="name" :id="id" :required="required" data-live-search="true">
            <slot></slot>
        </select>
    </div>
</template>

<script>
    export default {
        name: "ErpSelectStatic",
        props: {
            classNumber: String,
            id: String,
            name: String,
            label: String,
            disabled: false,
            required: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                txt: {},
            }
        },
        methods:{
            changeValue(e){
                this.$emit('changeValue', e);
            }
        },
        mounted() {
            this.txt = txtTrans.txtForm;
            this.el = $(`#${this.id}`);
            this.el.selectpicker({
                noneSelectedText: this.label,
                actionsBox: true
            });

        },

    }
</script>

<style scoped>

</style>