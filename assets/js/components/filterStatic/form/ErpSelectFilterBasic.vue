<template>
    <div v-if="disabled"  :class="classNumber ? `col-md-${classNumber}` : 'col-md-3'">
        <label class="control-label" :for="id" v-text="label"></label>
        <select @change="changeValue" class="form-control" :name="name" :id="id" disabled>
            <slot></slot>
        </select>
    </div>

    <div v-else  :class="classNumber ? `col-md-${classNumber}` : 'col-md-3'">
        <label class="control-label" :for="id" v-text="label"></label>
        <select @change="changeValue"  class="form-control"  :name="name" :id="id">
            <slot></slot>
        </select>
    </div>
</template>

<script>
    export default {
        name: "ErpSelectFilterBasic",
        props: {
            classNumber: String,
            id: String,
            name: String,
            label: String,
            disabled: false
        },
        methods:{
            changeValue(e){
                this.$emit('changeValue', e);
            }
        }
    }
</script>

<style scoped>

</style>