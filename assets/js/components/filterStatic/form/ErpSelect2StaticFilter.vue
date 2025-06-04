<template>
    <div v-if="disabled" :class="classNumber ? `col-md-${classNumber}` : 'col-md-3'">
        <label class="control-label" :for="id" v-text="label"></label>
        <select class="form-control kt-select2" :name="name" :id="id"  disabled>
            <slot></slot>
        </select>
    </div>

    <div v-else :class="classNumber ? `col-md-${classNumber}` : 'col-md-3'">
        <label class="control-label" :for="id" v-text="label"></label>
        <select class="form-control kt-select2" :name="name" :id="id" >
            <slot></slot>
        </select>
    </div>


</template>

<script>
    export default {
        name: "ErpSelect2StaticFilter",
        props: {
            classNumber: String,
            id: String,
            name: String,
            label: String,
            select: null,
            disabled: false
        },
        data() {
          return {
              el: null
          }
        },
        mounted() {
            let $this = this;
            this.el = $(`#${this.id}`);
            this.el.select2({tags: false});

            this.el.val('').trigger('change');
            $this.$emit('ref', this.el);
            this.el.select2().on('change', function() {
                $this.$emit('changeValue', $(this).val());
            }).trigger('change');


        },
        watch: {
            select() {
                if (this.el.find("option[value='" + this.select + "']").length) {
                    this.el.val(this.select).trigger('change');
                }
            }
        }
    }
</script>

<style>
    .select2-container {
        width: 100% !important;
    }
</style>