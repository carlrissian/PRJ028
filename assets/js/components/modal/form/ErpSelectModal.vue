<template>
    <div :class=" classNumber ? `col-md-${classNumber}` : 'col-md-4'">
        <div class="form-group">
            <label class="control-label" :for="id" v-text="label"></label>
                <select @change="changeSelect"  :name="name" class="form-control" :id="id" :required="required">
                    <slot></slot>
                </select>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpSelectModal",
        props: {
            classNumber: String,
            label: String,
            id: String,
            name: String,
            required: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            changeSelect(e) {
                this.$emit('updateSelect', e.target.value);
            }
        }
    }
</script>

<style scoped>

</style>