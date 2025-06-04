<template>
    <bootstrap-table
        :ref="reference"
        :columns="columns"
        :options="optionsTable"
        @onCheck="check"
        @onUncheck="check"
        @onCheckAll="check"
        @onUncheckAll="check"
    />
</template>

<script>
import Axios from "axios";

export default {
    name: "ErpAjaxTable",
    props: {
        reference: {
            type: String,
            default: "table",
        },
        columns: {
            type: Array,
            required: true,
        },
        options: {
            type: Object,
            required: true,
        },
        url: {
            type: String,
            required: true,
        },
        filter: {
            type: Boolean,
            default: true,
        },
        parameterDefault: Object,
        store: {
            type: String,
            default: "filter",
        },
        firstCall: {
            type: Boolean,
            default: true,
        },
    },
    data() {
        return {
            items: null,
            search: "",
            optionsTable: {
                sidePagination: "server",
                ajax: this.ajaxRequest,
            },
            initCall: true,
        };
    },
    created() {
        this.optionsTable = { ...this.optionsTable, ...this.options };
        this.initCall = this.firstCall;
    },
    mounted() {
        this.$emit("referer", this.$refs[this.reference]);
    },
    methods: {
        ajaxRequest(params) {
            // Se hace esta lógica para evitar que se haga la primera llamada automáticamente, siempre que se mande firstCall a false
            if (this.initCall) {
                Axios.get(this.getUrlByFilter(params)).then((resp) => {
                    if (this.filter) {
                        this.$store.commit(`${this.store}/count`, resp.data.total);
                    }
                    this.$emit("items", resp.data);
                    params.success(resp.data, null, {});
                });
            } else {
                this.initCall = true;
            }
        },
        getUrlByFilter(params) {
            let queryString = "";
            this.getParameterFilterSearch(params);
            queryString = this.getParameterFilterInputs(queryString);
            queryString += Object.keys(params.data)
                .map((key) => {
                    return params.data[key] !== undefined ? key + "=" + params.data[key] : "";
                })
                .filter(($key) => {
                    return $key !== "";
                })
                .join("&");
            if (this.parameterDefault) {
                queryString +=
                    "&" +
                    Object.keys(this.parameterDefault)
                        .map((key) => key + "=" + this.parameterDefault[key])
                        .join("&");
            }

            if (this.url.includes("?")) {
                return `${this.url}&${queryString}`;
            } else {
                return `${this.url}?${queryString}`;
            }
        },
        getParameterFilterSearch(params) {
            if (this.search !== "") {
                params.data.search = this.search;
            }
        },
        getParameterFilterInputs(queryString) {
            if (this.items) {
                queryString =
                    Object.keys(this.items)
                        .map((key) => key + "=" + this.items[key])
                        .join("&") + "&";
            }
            return queryString;
        },
        check() {
            this.$emit("check", this.$refs[this.reference]);
        },
    },
    computed: {
        itemsStore() {
            return this.$store.getters[`${this.store}/items`];
        },
        searchStore() {
            return this.$store.getters[`${this.store}/search`];
        },
    },
    watch: {
        searchStore(value) {
            this.search = value;
            this.$refs[this.reference].refresh();
        },
        itemsStore(value) {
            this.items = value;
            this.$refs[this.reference].refresh();
        },
    },
};
</script>

<style scoped></style>
