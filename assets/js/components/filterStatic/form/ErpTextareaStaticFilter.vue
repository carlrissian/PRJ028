<template>
    <div  :class="classNumber ? `col-md-${classNumber}` : 'col-md-3'">
        <div class="form-group">
            <label class="control-label" :for="id" v-text="label"></label>
            <textarea @input="someHandler" class="form-control" :name="name" :id="id" :value="value" :rows="rows" />
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpTextareaStaticFilter",
        props:{
            classNumber: String,
            id: String,
            type: String,
            name: String,
            label: String,
            value: String,
            rows: String
        },
        methods: {
            someHandler(e) {
                this.$emit('changeUpdateTextArea', e);
            }
        }
    }
</script>

<style scoped>

</style>