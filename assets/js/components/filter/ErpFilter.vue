<!-- INFO versión mejorada de ErpFilter de Shared -->
<template>
    <div :id="id">
        <erp-search-filter :store="store" :show-count="showCount" :show-search="showSearch">
            <div class="col-10">
                <button @click="clickButton" type="button" id="btn-filters" class="btn btn-record">
                    {{ message.filter }}<i class="ml-3" :class="isCollapsed ? 'fa fa-angle-up' : 'fa fa-angle-down'"></i>
                </button>
                <button
                    @click="removeAll"
                    type="button"
                    id="btn-reset-filters-out"
                    class="btn btn-record"
                    :class="statusButtonRemove ? '' : 'collapse'"
                    v-text="message.filterButtonDeleteAll"
                ></button>
            </div>
        </erp-search-filter>
        <div :id="`${id}filters`" class="row filters collapse mb-3">
            <div class="col">
                <div class="kt-portlet kt-portlet--solid-light mb-0">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon"><i class="fa fa-filter"></i></span>
                            <h3 class="kt-portlet__head-title" v-text="message.filterTitle"></h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <form :action="url" class="form-horizontal" autocomplete="off" id="form-search" :method="method">
                            <div class="row">
                                <slot></slot>
                            </div>
                        </form>
                    </div>
                    <div class="kt-portlet__foot kt-portlet__foot--sm kt-align-right ">
                        <button
                            @click="removeAll"
                            type="button"
                            id="btn-reset-filters-in"
                            class="btn btn-font-light btn-outline-hover-light"
                            v-text="message.filterButtonDeleteAll"
                        ></button>
                        <button
                            @click="searchButton"
                            type="button"
                            id="btn-search"
                            class="btn btn-font-light btn-outline-hover-light"
                            v-text="message.filterSearch"
                        ></button>
                    </div>
                </div>
            </div>
        </div>
        <div id="active-filters" class="row collapse show filters my-3">
            <div class="col">
                <button
                    v-if="items.length"
                    v-for="item in items"
                    :key="item.name"
                    style="margin-bottom: 1em"
                    type="button"
                    class="btn btn-sm btn-light btn-pill mr-1 btn-filter-data"
                    :data-target="item.name"
                >
                    {{ `${item.label}: ${item.value}` }} <i @click="removeItem(item)" class="fa fa-times-circle fa-lg  ml-3"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import ErpSearchFilter from "./form/ErpSearchFilter.vue";
export default {
    name: "ErpFilter",
    components: {
        ErpSearchFilter,
    },
    props: {
        id: String,
        store: {
            type: String,
            default: "filter",
        },
        url: String,
        method: String,
        showSearch: Boolean,
        showCount: {
            type: Boolean,
            default: true,
        },
        showFilter: {
            type: Boolean,
            default: false,
        },
        activateEnterKeySearch: {
            type: Boolean,
            default: true,
        },
    },
    data() {
        return {
            message: {},
            items: [],
            elements: null,
            filter: null,
            filterActive: null,
            form: {},
            isCollapsed: this.showSearch,
        };
    },
    mounted() {
        this.message = msg.filter;
        let filter = this.id ? `#${this.id}` : "";

        this.elements = Array.from(
            document.querySelectorAll(`${filter} #form-search input, ${filter} #form-search select`)
        ).filter((el) => el.getAttribute("type") !== "search");

        this.$nextTick(function() {
            this.filter = $(`#${this.id}filters`);
            this.filterActive = $("#active-filters");
        });

        if (this.activateEnterKeySearch) {
            $(document).on("keypress", (e) => {
                if (e.key === "Enter") {
                    e.preventDefault();
                    this.searchButton();
                }
            });
        }

        if (this.showFilter) {
            this.showAndHide();
        }
    },
    destroyed() {
        if (this.activateEnterKeySearch) {
            $(document).off("keypress");
        }
    },
    computed: {
        statusButtonRemove() {
            return (this.items.length > 0 && this.isCollapsed) || this.items.length > 0;
        },
    },
    methods: {
        clickButton() {
            this.showAndHide();
        },
        searchButton() {
            if (!this.fieldsIsEmpty()) {
                this.items = [];
                this.form = [];

                this.elements.forEach((el) => {
                    if (el.value === "") return;

                    switch (el.type) {
                        case "select-multiple":
                            this.getValueMultipleSelect(el);
                            return;
                        case "select-one":
                            this.getValueSelect(el);
                            return;
                        case "checkbox":
                            if (el.checked) {
                                this.getValueCheckbox(el);
                            }
                            return;
                        default:
                            const label =
                                el.parentElement.parentElement.querySelector("label")?.innerText ||
                                el.parentElement.parentElement.parentElement.querySelector("label")?.innerText;
                            const value = this.getValue(el);
                            const name = el.getAttribute("name");
                            let valueEncoded = escape(value);
                            this.form[name] = valueEncoded;
                            this.items.push({ label, value, name, el });
                            return;
                    }
                });

                this.showAndHide();
                this.$store.commit(`${this.store}/items`, this.form);
            }
        },
        getValueSelect(el) {
            const label = el.parentElement.parentElement.parentElement.querySelector("label")?.innerText;
            const value = el.options[el.selectedIndex].text;
            const name = el.getAttribute("name");
            this.form[name] = el.value;
            this.items.push({ label, value, name, el });
        },
        getValueMultipleSelect(el) {
            const label = el.parentElement.parentElement.parentElement.querySelector("label")?.innerText;
            const value = el.nextSibling.title;
            const name = el.name;
            let arraySelected = value.split(",").map((i) => i.trim());
            if (value && value !== label && value !== "Nothing selected") {
                this.items.push({ label, value, name, el });
                let ids = [];
                for (let i = 0; i < el.length; i++) {
                    if (arraySelected.includes(el[i].text)) {
                        ids.push(el[i].value);
                    }
                }
                this.form[name] = JSON.stringify(ids);
            }
        },
        getValueCheckbox(el) {
            const label = el.parentElement.parentElement.parentElement.querySelector("label")?.innerText;
            const value = el.checked;
            const name = el.getAttribute("name");
            this.form[name] = true;
            this.items.push({ label, value, name, el });
        },
        getValue(el) {
            return el.nodeName?.toUpperCase() === "SELECT" ? el.options[el.selectedIndex].text : el.value;
        },
        removeItem(item) {
            switch (item.el.type) {
                case "select-multiple":
                case "select-one":
                    item.el.value = "";
                    this.changedTextSelectMultipleRemove(item.el);
                    break;
                case "checkbox":
                    item.el.checked = false;
                    break;
                default:
                    item.el.value = "";
                    break;
            }

            this.items = this.items.filter((el) => el.name !== item.name);
            delete this.form[item.name];
            this.$store.commit(`${this.store}/items`, this.form);
        },
        removeAll() {
            this.elements.forEach((el) => {
                switch (el.type) {
                    case "select-multiple":
                    case "select-one":
                        if (el.value) {
                            el.value = "";
                            this.changedTextSelectMultipleRemove(el);
                        }
                        return;
                    case "checkbox":
                        el.checked = false;
                        return;
                    default:
                        el.value = "";
                        return;
                }
            });
            this.items = [];
            this.form = [];
            if (!this.checkTagsEmpty()) this.$store.commit(`${this.store}/items`, this.form);
        },
        changedTextSelectMultipleRemove(el) {
            let title = el.parentElement.parentElement.parentElement.querySelector("label")?.innerText || "Nothing selected";
            el.nextSibling.title = title;
            el.nextSibling.querySelector(".filter-option-inner-inner").innerText = title;
        },
        showAndHide() {
            this.filter.collapse("toggle");
            this.filterActive.collapse("toggle");

            this.isCollapsed = !this.isCollapsed;
        },
        fieldsIsEmpty() {
            let empty = true;
            this.elements.forEach((el) => {
                if (el.type === "checkbox") {
                    if (el.checked) empty = false;
                    return;
                }
                if (el.value) empty = false;
            });

            return empty;
        },
        checkTagsEmpty() {
            return document.querySelectorAll("#active-filters i").length === 0;
        },
    },
};
</script>

<style scoped></style>
