<template>
    <fragment>
        <notifications position="top center" width="80%" />

        <div class="kt-container">
            <div class="kt-portlet kt-portlet--bordered">
                <div class="kt-portlet__body">
                    <acriss-list-filter :select-list="selectList" />

                    <div class="kt-align-right mb-2">
                        <button @click="goToCreate" type="button" class="btn btn-dark kt-label-bg-color-4 mb-5">
                            <i class="la la-plus"></i>
                            {{ txt.form.createAcriss }}
                        </button>
                    </div>
                    <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded">
                        <erp-ajax-table
                            id="dataTable"
                            :url="routing.generate('acriss.filter')"
                            :columns="columns"
                            :options="options"
                        />
                    </div>
                </div>
            </div>
        </div>
    </fragment>
</template>

<script>
import Loading from "../../../../assets/js/utilities";
import Formatter from "../../../../SharedAssets/js/formatter";
import ErpAjaxTable from "../../../../SharedAssets/vue/components/table/ErpAjaxTable.vue";
import AcrissListFilter from "./AcrissListFilter.vue";

export default {
    name: "AcrissListPage",
    components: {
        ErpAjaxTable,
        AcrissListFilter,
    },
    data() {
        return {
            txt: {},

            selectList: {
                commercialGroupList: [],
                carGroupList: [],
                carClassList: [],
                acrissTypeList: [],
                motorizationTypeList: [],
                gearBoxList: [],
                statusList: [],
            },

            columns: [
                {
                    field: "name",
                    title: txtTrans.fields.acriss,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "carClass",
                    title: txtTrans.fields.carClass,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "acrissType",
                    title: txtTrans.fields.acrissType,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "gearBox",
                    title: txtTrans.fields.gearBox,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "motorizationType",
                    title: txtTrans.fields.motorizationType,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "commercialGroup",
                    title: txtTrans.fields.commercialGroup,
                    sortable: true,
                    formatter: (value) => Formatter.formatArray(value),
                },
                {
                    field: "carGroup",
                    title: txtTrans.fields.carGroup,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "status",
                    title: txtTrans.fields.status,
                    sortable: true,
                    formatter: this.formatterBoolean,
                },
                {
                    title: txtTrans.fields.actions,
                    formatter: this.actionsFormatter,
                    events: {
                        "click .show": (e, value, row) => this.clickShowRow(row),
                    },
                    width: 160,
                },
            ],
            options: {
                pagination: true,
                locale: "es-ES",
                scrollX: true,
                pageSize: 50,
                stickyHeader: true,
                height: 500 
            },
        };
    },
    created() {
        this.txt = txtTrans;
    },
    async mounted() {
        this.getSelectLists();
    },
    methods: {
        goToCreate() {
            location.href = this.routing.generate("acriss.create");
        },
        formatterBoolean(value) {
            return typeof value === "boolean" ? (value ? this.txt.form.enabled : this.txt.form.disabled) : "-";
        },
        actionsFormatter() {
            let actions = [
                '<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md show" title="Show"><em class="flaticon-eye"></em></a>',
            ];
            return actions.join("");
        },
        clickShowRow(row) {
            location.href = this.routing.generate("acriss.show", { id: row.id });
            // window.open(this.routing.generate("acriss.show", { id: row.acrissId }), "_self");
        },
        async getSelectLists() {
            Loading.starLoading();

            this.axios
                .all([
                    this.axios.get(this.routing.generate("commercialGroup.selectList")),
                    this.axios.get(this.routing.generate("cargroup.selectList")),
                    this.axios.get(this.routing.generate("carClass.selectList")),
                    this.axios.get(this.routing.generate("acrissType.selectList")),
                    this.axios.get(this.routing.generate("motorizationType.selectList")),
                    this.axios.get(this.routing.generate("gearBox.selectList")),
                ])
                .then(
                    this.axios.spread((commercialGroup, carGroup, carClass, acrissType, motorizationType, gearBox) => {
                        this.selectList.commercialGroupList = commercialGroup.data;
                        this.selectList.carGroupList = carGroup.data;
                        this.selectList.carClassList = carClass.data;
                        this.selectList.acrissTypeList = acrissType.data;
                        this.selectList.motorizationTypeList = motorizationType.data;
                        this.selectList.gearBoxList = gearBox.data;

                        this.selectList.statusList = [
                            {
                                id: true,
                                name: this.txt.form.enabled,
                            },
                            {
                                id: false,
                                name: this.txt.form.disabled,
                            },
                        ];

                        Loading.endLoading();
                    })
                )
                .catch((error) => {
                    console.error(error);
                    Loading.endLoading();
                });
        },
    },
};
</script>

<style scoped></style>
