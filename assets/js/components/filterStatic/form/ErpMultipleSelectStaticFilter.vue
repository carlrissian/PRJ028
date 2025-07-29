<template>
    <div v-if="disabled" :class=" classNumber ? `col-md-${classNumber}` : 'col-md-4'">
        <div class="form-group">
            <label class="control-label" :for="id" v-text="label"></label>
            <select  :type="type" class="form-control kt-selectpicker" :name="name" :id="id" multiple data-size="5" data-live-search="true" disabled>
                <slot></slot>
            </select>
        </div>
    </div>
    <div  v-else :class=" classNumber ? `col-md-${classNumber}` : 'col-md-4'">
        <div class="form-group">
            <label class="control-label" :for="id" v-text="label"></label>
            <select  :type="type" class="form-control kt-selectpicker" :name="name" :id="id" multiple data-size="5" data-live-search="true">
                <slot></slot>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpMultipleSelectStaticFilter",
        props: {
            classNumber: String,
            id: String,
            type: String,
            name: String,
            label: String,
            value: Array,
            dataForAjax: Array,
            defaultText: String,
            disabled: false,
            movement: String
        },
        data() {
            return {
                el: null,
                valueDataAjax: Array
            }
        },
        mounted() {
            this.el = $(`#${this.id}`);
            this.el.selectpicker({
                noneSelectedText : this.defaultText ?? this.label,
                actionsBox: true
            });
            let $this = this;
            this.el.on('changed.bs.select', function (e) {
              $this.getValueMultipleSelect(e.target);
            });
        },
      methods: {
        getValueMultipleSelect(el) {
          const label = el.parentElement.parentElement.parentElement.querySelector('label').innerText;
          const value = el.nextSibling.title;
          this.$emit('changeSelectMultiple', {[label]: value});
        },
      },
        watch: {
            valueDataAjax() {
                //Para cuando es editar aparezcan los filtros marcados sin poder cambiarlos
                if(this.movement === 'true'){
                    let idSelect;
                    idSelect = $(this).attr('id');
                    this.value.forEach((item, key) => {
                        $('#'+idSelect).children('option[value="'+item+'"]').css( "background-color", "#cdcdcd" );
                        $('#'+idSelect).children('option[value="'+item+'"]').css( "color", "#000" );
                        $('#'+idSelect).children('option[value="'+item+'"]').css( "cursor", "none" );
                    });
                }
                    this.el.val(this.value);
                    this.el.selectpicker("refresh");
            },
            value() {
                this.el.val(this.value);
                this.el.selectpicker("refresh");
            },
            dataForAjax: {
                handler() {
                    this.dataForAjax.forEach(item => {
                        this.el.append($("<option>", {
                            value: item.id,
                            text: item.name
                        }));
                        this.valueDataAjax = this.value;
                        this.el.selectpicker("refresh");
                    });
                },
                immediate: true,
            }
        }
    }
</script>
<style scoped>

</style>