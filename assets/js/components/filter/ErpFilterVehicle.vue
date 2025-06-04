<template>
    <fragment>
        <h1 v-text="`Registros totales: ${$store.getters['filter/count']}`"></h1>
        <div class="row mb-3">
            <div class="col-12">
                <!-- class="btn btn-dark kt-label-bg-color-4" -->
                <button @click="collapsed = !collapsed" type="button" id="show-filters" class="btn btn-record">
                    {{ message.filter }}
                    <i class="ml-3 fa" :class="collapsed ? 'fa-angle-up' : 'fa-angle-down'"></i>
                </button>
                <button
                    v-show="!collapsed && selectedFilters.length > 0"
                    @click="clear"
                    type="button"
                    id="reset-filters"
                    class="btn btn-record"
                    v-text="message.filterButtonDeleteAll"
                ></button>
            </div>

            <div id="filter-chips" class="col-12 my-3 filters collapse show">
                <button
                    v-if="selectedFilters.length > 0"
                    v-for="item in selectedFilters"
                    :key="item.name"
                    type="button"
                    class="btn btn-sm btn-light btn-pill mr-1 mb-2"
                    :data-target="item.name"
                >
                    {{ formatterChip(item) }}
                    <i @click="removeItemFilter(item)" class="fa fa-times-circle fa-lg ml-2"></i>
                </button>
            </div>

            <div id="collapse-filters" class="col-12 my-3 filters collapse">
                <form @submit.prevent="search" id="form-search" autocomplete="off">
                    <div class="kt-portlet kt-portlet--solid-light">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon"><i class="fa fa-filter"></i></span>
                                <h3 class="kt-portlet__head-title" v-text="message.filterTitle"></h3>
                            </div>
                        </div>

                        <div class="kt-portlet__body">
                            <div class="row">
                                <slot></slot>
                            </div>
                        </div>

                        <div class="kt-portlet__foot kt-portlet__foot--sm kt-align-right">
                            <slot name="more-actions"></slot>
                            <button
                                @click="clear"
                                type="button"
                                id="reset-filters"
                                class="btn btn-record"
                                v-text="message.filterButtonDeleteAll"
                            ></button>
                            <button type="submit" id="btn-search" class="btn btn-record" v-text="message.filterSearch"></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </fragment>
</template>

<script>
export default {
    name: "ErpFilterVehicle",
    components: {},
    props: {
        storeModuleName: {
            type: String,
            default: "filter",
        },
        showFilters: {
            type: Boolean,
            default: false,
        },
        autoSubmit: {
            type: Boolean,
            default: true,
        },
    },
    data() {
        return {
            message: {},
            collapsed: this.showFilters,
            submitted: false,
            selectedFilters: [],
            formFields: [],
            filters: {},
        };
    },
    mounted() {
        this.message = msg.filter;
        this.formFields = document.querySelectorAll("#form-search input, #form-search select");
    },
    methods: {
        formatterChip(item) {
            return `${item.name}: ${item.text}`;
        },
        flush(item = null) {
            if (item) {
                this.selectedFilters = this.selectedFilters.filter((filter) => filter.filterName !== item.filterName);
                delete this.filters[item.filterName];
            } else {
                this.selectedFilters = [];
                this.filters = {};
            }
        },
        saveField(field) {
            // console.log("Field: ", field);

            if (!["", null, undefined].includes(field.value) && !this.selectedFilters.some((item) => item.name === field.name)) {
                this.filters[field.filterName] = field.value;
                this.selectedFilters.push(field);
            }
        },
        saveFilters() {
            this.flush();

            this.formFields.forEach((element) => {
                let field = {
                    type: null,
                    filterName: null,
                    name: null,
                    value: null,
                    text: null,
                };

                // console.log("Element: ", element);

                field.type = element.nodeName.toLowerCase();

                switch (field.type) {
                    case "input":
                        if (["text", "number"].includes(element.type)) {
                            field.filterName = element.name;
                            field.value = element.value;
                            field.name = element.classList.contains("date")
                                ? element.parentElement.parentElement.querySelector("label").innerText
                                : element.parentElement.querySelector("label").innerText;
                            field.text = element.value;
                        }
                        break;
                    case "select":
                        field.filterName = element.name;
                        field.name = element.parentElement.parentElement.querySelector("label").innerText;

                        if (element.type === "select-multiple") {
                            let selectedOptions = Array.from(element.selectedOptions).map((option) => option.value);
                            field.value = selectedOptions.length > 0 ? selectedOptions : null;
                            field.text = Array.from(element.selectedOptions)
                                .map((option) => option.text)
                                .join(", ");
                        } else {
                            let selectedOption = element.options[element.selectedIndex];
                            if (selectedOption === undefined) {
                                break;
                            }
                            // console.log("Selected option: ", selectedOption);
                            field.value = selectedOption.value;

                            // console.log("Selected value: ", field.value);
                            field.text = selectedOption.text;
                        }
                        break;
                    default:
                        console.warn("Tipo de elemento desconocido: ", element);
                        break;
                }

                this.saveField(field);
            });
        },
        removeItemFilter(item) {
            this.flush(item);

            this.formFields.forEach((element) => {
                if (item.filterName === element.name) {
                    switch (element.nodeName.toLowerCase()) {
                        case "input":
                            if (["text", "number"].includes(element.type) && !element.hasAttribute("disabled")) {
                                element.value = null;
                            }
                            break;
                        case "select":
                            if (!element.hasAttribute("disabled")) {
                                Array.from(element.options).forEach((option) => (option.selected = false));
                                $(`#${element.id}`).selectpicker("refresh");
                            }
                            break;
                        default:
                            console.warn("Tipo de elemento desconocido: ", element);
                            break;
                    }

                    this.$emit("filterDeleted", item.name);
                }
            });

            if (this.selectedFilters.length > 0 || this.autoSubmit) {
                // Es necesario para que a los componentes de Bootsrap les de tiempo a actualizar el value
                this.$nextTick(function() {
                    this.search();
                });
            } else {
                this.submitted = false;
                this.$emit("filtersCleared", this.submitted);
            }
        },
        removeFilters() {
            this.flush();

            this.formFields.forEach((element) => {
                switch (element.nodeName.toLowerCase()) {
                    case "input":
                        if (["text", "number"].includes(element.type) && !element.hasAttribute("disabled")) {
                            element.value = null;
                        }
                        break;
                    case "select":
                        if (!element.hasAttribute("disabled")) {
                            Array.from(element.options).forEach((option) => (option.selected = false));
                            $(`#${element.id}`).selectpicker("refresh");
                        }
                        break;
                    default:
                        console.warn("Tipo de elemento desconocido: ", element);
                        break;
                }
            });

            this.$emit("filtersCleared", this.submitted);

            if (this.autoSubmit) {
                // Es necesario para que a los componentes de Bootsrap les de tiempo a actualizar el value
                this.$nextTick(function() {
                    this.search();
                });
            }
        },
        search() {
            this.collapsed = false;

            this.submitted = true;
            // Se añade este evento para cuando se requiera realizar alguna acción antes de enviar filtros y mostrar la tabla
            this.$emit("filtersSubmitted", this.submitted);

            // console.log("Filters: ", this.filters);

            this.saveFilters();

            // this.$store.dispatch(`${this.storeModuleName}/removeFilters`);
            // this.$store.dispatch(`${this.storeModuleName}/saveFilters`, this.filters);
            this.$store.commit(`${this.storeModuleName}/items`, this.filters);
            this.$emit("filtersUpdated");
        },
        clear() {
            if (this.selectedFilters.length > 0) {
                this.collapsed = false;
                this.submitted = false;
                this.removeFilters();
                this.$emit("filtersUpdated");
            }
        },
    },
    watch: {
        showFilters: function(show) {
            this.collapsed = show;
        },
        collapsed: function() {
            $("#collapse-filters").collapse("toggle");
            $("#filter-chips").collapse("toggle");
        },
    },
};
</script>

<style scoped>
div#collapse-filters div.kt-portlet.kt-portlet--solid-light {
    border: 1px solid #cf2d30;
}
</style>
