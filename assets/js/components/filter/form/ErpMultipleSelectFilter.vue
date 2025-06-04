<template>
    <div :class="classNumber ? `col-md-${classNumber}` : 'col-md-4'">
        <div class="row mb-3 justify">
            <label class="col-12 col-form-label" :for="id" v-text="label"></label>
            <div class="col-12">
                <select
                    :name="name"
                    :id="id"
                    class="form-control kt-selectpicker"
                    :type="type"
                    multiple
                    :data-size="dataSizeComputed"
                    data-live-search="true"
                >
                    <slot></slot>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ErpMultipleSelectFilter",
    props: {
        name: String,
        id: String,
        classNumber: String,
        type: String,
        dataForAjax: Array,
        value: Array,
        label: String,
        placeholder: {
            type: String,
            default: "Nothing selected",
        },
        dataSize: {
            type: Number,
            default: 5,
        },
    },
    data() {
        return {
            element: null,
            // selection: this.value,
            optionsArray: Array,
        };
    },
    mounted() {
        let config = {
            noneSelectedText: this.label ?? this.placeholder,
            liveSearch: true,
            actionsBox: true,
        };

        this.element = $(`#${this.id}`);
        this.element.selectpicker(config);

        this.element.on("hidden.bs.select", (e) => {
            this.$emit("onBlurSelectPicker", e);
        });

        this.element.on("changed.bs.select", (e) => {
            this.getValueMultipleSelect(e.target);
        });
    },
    updated() {
        this.$nextTick(function() {
            this.element.selectpicker("refresh");
        });
    },
    computed: {
        dataSizeComputed() {
            return this.dataSize || this.optionsArray.length;
        },
    },
    methods: {
        getValueMultipleSelect(el) {
            const value = el.nextSibling.title;
            this.$emit("changeSelectMultiple", { value });
        },
    },
    watch: {
        optionsArray() {
            this.element.val(this.value);
            this.element.selectpicker("refresh");
        },
        value() {
            this.element.val(this.value);
            this.element.selectpicker("refresh");
        },
        async dataForAjax() {
            let selectedItems = [];

            await this.dataForAjax.forEach((item, key) => {
                let obj = {};
                if (typeof item === "object") {
                    obj = {
                        value: item.id,
                        text: item.name,
                        selected: item.selected??false,
                        disabled: item.disabled??false,
                    };
                    if ((item.selected??false) === true) {
                        selectedItems.push(obj.value)
                    }
                } else {
                    obj = {
                        value: key,
                        text: item,
                    };
                }

                this.element.append($("<option>", obj));
                //this.valueDataAjax = this.value;
                this.element.selectpicker("refresh");
            });

            this.element.selectpicker('val', selectedItems);
            this.element.selectpicker("refresh");
        },
    },
};
</script>
<style scoped>
.justify {
    justify-content: space-evenly;
}
</style>
