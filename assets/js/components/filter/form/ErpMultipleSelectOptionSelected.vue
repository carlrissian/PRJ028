<template>
    <div :class="`col-md-${classNumber}`">
        <div class="form-group">
            <label class="control-label" :for="id" v-text="label"></label>
            <select
                :type="type"
                :name="name"
                :id="id"
                class="form-control kt-selectpicker"
                multiple
                :data-size="dataForAjax.length"
                data-live-search="true"
            >
                <slot></slot>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    name: "ErpMultipleSelectOptionSelected",
    props: {
        type: String,
        name: String,
        id: String,
        classNumber: {
            type: Number,
            default: 3,
        },
        label: String,
        value: Array,
        dataForAjax: Array,
    },
    data() {
        return {
            el: null,
            valueDataAjax: Array,
        };
    },
    mounted() {
        let $this = this;
        this.el = $(`#${this.id}`);
        this.el.selectpicker({
            noneSelectedText: this.label,
            actionsBox: true,
        });
        this.el.on("changed.bs.select", function(e) {
            $this.getValueMultipleSelect(e.target);
        });
    },
    methods: {
        getValueMultipleSelect(el) {
            const value = el.nextSibling.title;
            this.$emit("changeSelectMultiple", { value });
        },
    },
    watch: {
        valueDataAjax() {
            let idSelect;
            idSelect = $(this).attr("id");

            if (this.value) {
                this.value.forEach((item, key) => {
                    $("#" + idSelect)
                        .children('option[value="' + item + '"]')
                        .attr("disabled", true);
                    $("#" + idSelect).selectpicker("refresh");
                });

                this.el.val(this.value);
            }

            this.el.selectpicker("refresh");
        },
        value() {
            this.el.val(this.value);
            this.el.selectpicker("refresh");
        },
        dataForAjax: {
            handler() {
                if (this.dataForAjax) {
                    this.dataForAjax.forEach((item, key) => {
                        let obj = {};
                        if (typeof item === "object") {
                            obj = {
                                value: item.id,
                                text: item.name,
                            };
                        } else {
                            obj = {
                                value: key,
                                text: item,
                            };
                        }
                        this.el.append($("<option>", obj));
                        this.valueDataAjax = this.value;
                        this.el.selectpicker("refresh");
                    });
                }
            },
            immediate: true,
        },
    },
};
</script>

<style scoped></style>
