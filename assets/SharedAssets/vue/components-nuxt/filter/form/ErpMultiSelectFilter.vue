<template>
    <div :class="divClass">
        <label :class="labelClass" :for="id" v-text="label"></label>
        <!-- Vue Multiselect Doc oficial: https://vue-multiselect.js.org/#sub-getting-started -->
        <multiselect
            @update:modelValue="(selection = $event), $emit('updated', computedSelection)"
            @select="onSelect"
            @remove="onRemove"
            @open="$emit('opened', $event)"
            @close="$emit('closed', $event)"
            ref="multiselect"
            :name="name"
            :id="id"
            :disabled="readonly ? readonly : disabled"
            :required="required"
            v-model="selection"
            :options="options"
            multiple
            :searchable="searchable"
            :preserve-search="searchable"
            :close-on-select="false"
            :placeholder="placeholder"
            label="text"
            track-by="text"
            :select-label="$t('select')"
            :selectedLabel="$t('selected')"
            :deselect-label="$t('remove')"
            group-select
            group-label="allOptions"
            group-values="data"
            :select-group-label="$t('selectAll')"
            :deselect-group-label="$t('pressEnterToDeselect')"
            :limit="displayOptionsLimit"
            :limit-text="(count) => $t('andXMore', { count })"
        >
        </multiselect>
    </div>
</template>

<script>
import Multiselect from "vue-multiselect";

export default {
    name: "ErpMultiSelectFilter",
    components: {
        Multiselect,
    },
    props: {
        name: String,
        id: String,
        value: [Number, String, Array, Object],
        label: String,
        placeholder: {
            type: String,
            default: function () {
                return this.$t("chooseAnOption");
            },
        },
        readonly: {
            type: Boolean,
            default: false,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        // INFO Sólo disponible en V3.1.0 (https://vue-multiselect.js.org/#sub-props)
        required: {
            type: Boolean,
            default: false,
        },
        searchable: {
            type: Boolean,
            default: true,
        },
        divClass: {
            type: String,
            default: null,
        },
        labelClass: {
            type: String,
            default: "control-label",
        },
        displayOptionsLimit: {
            type: Number,
            default: 3,
        },
        returnObject: {
            type: Boolean,
            default: false,
        },
        url: {
            type: String,
            required: false,
            default: null,
        },
        manualOptions: {
            type: Array,
            required: false,
            default: null,
        },
    },
    data() {
        return {
            selection: null,
            options: [],
        };
    },
    created() {
        if (this.url) this.fetchOptions();
    },
    computed: {
        computedSelection: function () {
            return this.selection?.map((item) => item.value);
        },
    },
    methods: {
        onSelect(selectedOption, id) {
            this.$emit("selected", selectedOption, id);
            this.$emit("updated", this.computedSelection);
        },
        onRemove(removedOption, id) {
            this.$emit("removed", removedOption, id);
            this.$emit("updated", this.computedSelection);
        },
        async fetchOptions() {
            this.selection = null;

            this.$axios
                .get(this.url)
                .then((response) => {
                    console.log(`Fetch ${this.url} options: `, response);
                    this.fillOptions(response.data);
                })
                .catch((error) => {
                    console.error(error);
                    this.options[0].data = [];
                });
        },
        fillOptions(data) {
            this.options = [];
            if (data?.group === true) {
                this.options = data.options.map((group) => ({
                    allOptions: group.name,
                    data: group.items.map((item) => ({
                        text: item.name,
                        value: this.returnObject ? item : item.id,
                    })),
                }));
            }
            if (data?.length > 0) {
                this.options = [
                    {
                        allOptions: this.$t("allOptions"),
                        data: [],
                    },
                ];
                data.map((option) => {
                    this.returnObject
                        ? this.options[0].data.push({ text: option.name, value: option })
                        : this.options[0].data.push({ text: option.name, value: option.id });
                });
            }

            if (this.value) {
                // Buscar en las options los valores seleccionados
                const allOptions = this.options.flatMap((group) => group.data);
                this.selection = allOptions.filter((option) => {
                    return this.returnObject
                        ? this.value.some((val) => val.id === option.value.id)
                        : this.value.includes(option.value);
                });
            }
        },
    },
    watch: {
        value: function (value) {
            this.selection = value;
        },
        manualOptions: {
            handler: function (value) {
                this.fillOptions(value);
            },
            immediate: true,
        },
    },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
.multiselect__tag {
    background: #48465b;
}

.multiselect__tag-icon:after {
    color: #ffffff !important;
}

.multiselect__tag-icon:focus,
.multiselect__tag-icon:hover {
    background: #48465b !important;
}

.multiselect__tag-icon:focus:after,
.multiselect__tag-icon:hover:after {
    color: #ffffff !important;
}

.multiselect__option--highlight,
.multiselect__option--highlight::after {
    background-color: #48465b;
}
</style>
