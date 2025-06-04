<template>
    <div :class="classNumber ? `col-md-${classNumber}` : 'col-md-3'">
        <div class="row mb-3 justify">
            <label class="col-12 col-form-label" :for="id" v-text="label"></label>
            <div class="col-12">
                <select
                    @change="onChange"
                    @blur="onBlur"
                    :name="name"
                    :id="id"
                    class="form-control kt-selectpicker"
                    :disabled="disabled"
                    :data-size="dataSizeComputed"
                    data-live-search="true"
                >
                    <!-- FIXME el dataSize se vuelve loco al añadir este valor default -->
                    <option :value="null" v-text="placeholder"></option>
                    <option
                        v-if="optionsArray.length > 0"
                        v-for="item in optionsArray"
                        :key="item.id"
                        :value="returnObject ? item : item.id"
                        v-text="item.name"
                    ></option>
                    <slot></slot>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ErpSelectFilter",
    props: {
        name: String,
        id: String,
        classNumber: String,
        url: String,
        options: {
            type: Array,
            default: function() {
                return [];
            },
        },
        returnObject: {
            type: Boolean,
            default: false,
        },
        label: String,
        placeholder: {
            type: String,
            default: "Nothing selected",
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        dataSize: {
            type: Number,
            default: 5,
        },
    },
    data() {
        return {
            element: null,
            selection: this.value,
            optionsArray: [],
        };
    },
    created() {
        if (this.url) this.fetchOptions();
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
    },
    updated() {
        this.$nextTick(function() {
            this.element.selectpicker("refresh");
        });
    },
    computed: {
        dataSizeComputed() {
            return this.dataSize + 1 || this.optionsArray.length + 1;
        },
    },
    methods: {
        onChange(e) {
            this.$emit("onChangeSelectPicker", e);
            this.$emit("updatedSelectPicker", this.selection);
        },
        onBlur(e) {
            this.$emit("onBlurSelectPicker", e);
        },
        fetchOptions: async function() {
            this.axios
                .get(this.url)
                .then((response) => {
                    console.log(`Fetch ${this.url} options: `, response);
                    this.optionsArray = response.data?.length > 0 ? response.data : [];
                })
                .catch((e) => {
                    console.error(e);
                });
        },
    },
    watch: {
        options: function(options) {
            this.optionsArray = options;
        },
    },
};
</script>

<style scoped>
.justify {
    justify-content: space-evenly;
}
</style>
