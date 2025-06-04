<template>
    <div  :class="classNumber ? `col-md-${classNumber}` : 'col-md-3'">
        <div class="form-group">
            <label class="control-label" :for="id" v-text="label"></label>
            <textarea v-model="item" :type="type" class="form-control" :name="name" :id="id"  :rows="rows" />
        </div>
    </div>
</template>
<script>
    export default {
        name: "ErpTextareaModal",
        props: {
            classNumber: String,
            id: String,
            type: String,
            name: String,
            label: String,
            value: String,
            placeholder: String,
            readOnly: String,
            rows: String,
            classNumber: String,
        },
        data() {
            return {
                item: ''
            }
        },
        mounted() {
            this.item = this.value;
        },
        watch: {
            item() {
                this.$emit('changeUpdateTextArea', this.item);
            },
            value() {
                this.item = this.value;
            }
        }
    }
</script>

<style scoped>

</style>