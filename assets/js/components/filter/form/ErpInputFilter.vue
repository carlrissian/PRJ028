<template>
    <div :class="classNumber">
        <div class="row mb-3 justify">
            <label class="col-12 col-form-label" :for="id" v-text="label"></label>
            <div class="col-12">
                <input :title="title" :type="type" class="form-control"  :placeholder="placeholder" :name="name" :id="id" :value="value">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpInputFilter",
        props: {
            label: String,
            id: String,
            name: String,
            type: String,
            placeholder: String,
            title: String,
            value: [String, Number],
            classNumber: String
        }
    }
</script>

<style scoped>
    .justify {
        justify-content: space-evenly;
    }
</style>