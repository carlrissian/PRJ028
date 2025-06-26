<template>
    <fragment>
        <!-- Search module -->
        <div class="kt-portlet kt-portlet--bordered">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title" v-text="txt.titles.driverSearch"></h3>
                </div>
            </div>
            <form
                id="transport-driver-filters"
                class="kt-form"
                enctype="multipart/form-data"
                autocomplete="off"
                @submit.prevent="search"
            >
                <div class="kt-portlet__body">
                    <div class="form-group row">
                        <erp-input-static-filter
                            id="driverNameFilterId"
                            name="driverNameFilter"
                            :label="txt.fields.name"
                            :placeholder="txt.fields.name"
                        />
                        <erp-input-static-filter
                            id="driverLastNameFilterId"
                            name="driverLastNameFilter"
                            :label="txt.fields.lastName"
                            :placeholder="txt.fields.lastName"
                        />
                        <erp-input-static-filter
                            id="driverIdNumberFilterId"
                            name="driverIdNumberFilter"
                            :label="txt.fields.idNumber"
                            :placeholder="txt.fields.idNumber"
                        />
                        <erp-input-static-filter
                            id="driverLicenseFilterId"
                            name="driverLicenseFilter"
                            :label="txt.fields.driverLicense"
                            :placeholder="txt.fields.driverLicense"
                        />
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-align-right">
                        <button type="button" class="btn btn-dark kt-label-bg-color-4" @click="onDriverAction('new')">
                            <i class="la la-plus"></i>
                            {{ txt.form.newDriver }}
                        </button>
                        <button type="submit" class="btn btn-dark kt-label-bg-color-4">
                            <i class="la la-search"></i>
                            {{ txt.form.search }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!--  -->

        <!-- Table list -->
        <div
            id="driver-table"
            v-show="showDriverList"
            class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded mt-3"
        >
            <erp-ajax-table :url="routing.generate('transportDriver.filter')" :columns="columns" :options="options" ref="table" />
        </div>
        <!--  -->

        <!-- Driver selected data list -->
        <div id="selected-driver" v-show="showDriverSelected" class="kt-portlet kt-portlet--bordered mt-3">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title" v-text="txt.titles.driverSelected"></h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!-- TODO quizás habría que organizar mejor el orden de visualización de datos -->
                <div class="group row">
                    <div class="col-3">
                        <h6 v-text="txt.fields.name"></h6>
                        <p v-text="Formatter.formatField(driver.name)"></p>
                    </div>
                    <div class="col-3">
                        <h6 v-text="txt.fields.lastName"></h6>
                        <p v-text="Formatter.formatField(driver.lastName)"></p>
                    </div>
                    <div class="col-3">
                        <h6 v-text="txt.fields.idNumber"></h6>
                        <p v-text="Formatter.formatField(driver.idNumber)"></p>
                    </div>
                    <div class="col-3">
                        <h6 v-text="txt.fields.driverLicense"></h6>
                        <p v-text="Formatter.formatField(driver.driverLicense)"></p>
                    </div>
                    <div class="col-3">
                        <h6 v-text="txt.fields.issueDate"></h6>
                        <p v-text="Formatter.formatDate(driver.issueDate)"></p>
                    </div>
                    <div class="col-3">
                        <h6 v-text="txt.fields.expirationDate"></h6>
                        <p v-text="Formatter.formatDate(driver.expirationDate)"></p>
                    </div>
                    <div class="col-3">
                        <h6 v-text="txt.fields.city"></h6>
                        <p v-text="Formatter.formatField(driver.city)"></p>
                    </div>
                    <div class="col-3">
                        <h6 v-text="txt.fields.state"></h6>
                        <p v-text="Formatter.formatField(driver.state)"></p>
                    </div>
                    <div class="col-3">
                        <h6 v-text="txt.fields.country"></h6>
                        <p v-text="Formatter.formatField(driver.country)"></p>
                    </div>
                    <div class="col-3">
                        <h6 v-text="txt.fields.postalCode"></h6>
                        <p v-text="Formatter.formatField(driver.postalCode)"></p>
                    </div>
                    <div class="col-3">
                        <h6 v-text="txt.fields.address"></h6>
                        <p v-text="Formatter.formatField(driver.address)"></p>
                    </div>
                    <div class="col-3">
                        <h6 v-text="txt.fields.branch"></h6>
                        <p v-text="Formatter.formatField(driver.branch)"></p>
                    </div>
                    <div v-if="!driver.internalDriver" class="col-3">
                        <h6 v-text="txt.fields.provider"></h6>
                        <p v-text="Formatter.formatField(driver.provider)"></p>
                    </div>
                </div>
                <div class="kt-align-right">
                    <button
                        type="button"
                        class="btn btn-dark kt-label-bg-color-4"
                        v-text="txt.form.change"
                        @click="changeDriver"
                    ></button>
                </div>
            </div>
        </div>
        <!--  -->

        <!-- New driver form -->
        <div id="new-driver" v-if="showCreateDriverForm" class="kt-portlet kt-portlet--bordered mt-3">
            <form @submit.prevent="submitNewTransportDriver" enctype="multipart/form-data">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title" v-text="txt.titles.newDriver"></h3>
                    </div>
                </div>

                <div class="kt-portlet__body">
                    <div class="row">
                        <!-- Name -->
                        <input-base
                            @updatedInput="driver.name = $event"
                            name="driverName"
                            id="driverName"
                            div-class="form-group col-md-3"
                            :label="txt.fields.name"
                            :value="driver.name"
                            required
                        />
                        <!--  -->

                        <!-- Last name -->
                        <input-base
                            @updatedInput="driver.lastName = $event"
                            name="driverLastName"
                            id="driverLastName"
                            div-class="form-group col-md-3"
                            :label="txt.fields.lastName"
                            :value="driver.lastName"
                            required
                        />
                        <!--  -->

                        <!-- Branch -->
                        <single-select-picker
                            @updatedSelectPicker="driver.branch = $event"
                            name="driverBranch"
                            id="driverBranch"
                            div-class="form-group col-md-3"
                            :label="txt.fields.branch"
                            :placeholder="txt.form.selectAnOption"
                            :value="driver.branch"
                            :disabled="internalDriver"
                            required
                            return-object
                            :options="selectList.branchList"
                        />
                        <!--  -->
                    </div>

                    <div class="row">
                        <!-- ID number -->
                        <input-base
                            @updatedInput="driver.idNumber = $event"
                            name="driverIdNumber"
                            id="driverIdNumber"
                            div-class="form-group col-md-3"
                            :label="txt.fields.idNumber"
                            :value="driver.idNumber"
                            required
                        />
                        <!--  -->

                        <!-- Driver license -->
                        <input-base
                            @updatedInput="driver.driverLicense = $event"
                            name="driverLicense"
                            id="driverLicense"
                            div-class="form-group col-md-3"
                            :label="txt.fields.driverLicense"
                            :value="driver.driverLicense"
                            required
                        />
                        <!--  -->

                        <!-- DL issue date -->
                        <date-picker
                            @updatedDatePicker="driver.issueDate = $event"
                            name="driverIssueDate"
                            id="driverIssueDate"
                            div-class="form-group col-md-3"
                            :label="txt.fields.issueDate"
                            :placeholder="txt.fields.issueDate"
                            :limit-end-day="driver.expirationDate"
                            :value="driver.issueDate"
                            required
                        />
                        <!--  -->

                        <!-- DL expiration date -->
                        <date-picker
                            @updatedDatePicker="driver.expirationDate = $event"
                            name="driverExpirationDate"
                            id="driverExpirationDate"
                            div-class="form-group col-md-3"
                            :label="txt.fields.expirationDate"
                            :placeholder="txt.fields.expirationDate"
                            :limit-start-day="getMinDLExpirationDate()"
                            :value="driver.expirationDate"
                            required
                        />
                        <!--  -->
                    </div>

                    <div class="row">
                        <!-- City -->
                        <input-base
                            @updatedInput="driver.city = $event"
                            name="driverCity"
                            id="driverCity"
                            div-class="form-group col-md-3"
                            :label="txt.fields.city"
                            :value="driver.city"
                            required
                        />
                        <!--  -->

                        <!-- Country -->
                        <single-select-picker
                            @updatedSelectPicker="
                                driver.country = $event;
                                loadStateList($event.id);
                            "
                            name="driverCountry"
                            id="driverCountry"
                            div-class="form-group col-md-3"
                            :label="txt.fields.country"
                            :placeholder="txt.form.selectAnOption"
                            :value="driver.country"
                            required
                            return-object
                            :options="selectList.countryList"
                        />
                        <!--  -->

                        <!-- State -->
                        <single-select-picker
                            v-if="requireProvince"
                            @updatedSelectPicker="driver.state = $event"
                            name="driverState"
                            id="driverState"
                            div-class="form-group col-md-3"
                            :label="txt.fields.state"
                            :placeholder="txt.form.selectAnOption"
                            :value="driver.state"
                            :required="requireProvince"
                            return-object
                            :options="stateListFiltered"
                        />
                        <!--  -->

                        <!-- Postal code -->
                        <input-number
                            v-if="requireProvince"
                            @updatedInputNumber="driver.postalCode = $event"
                            name="driverPC"
                            id="driverPC"
                            div-class="form-group col-md-3"
                            :label="txt.fields.postalCode"
                            :value="driver.postalCode"
                            :required="requireProvince"
                        />
                        <!--  -->

                        <!-- Address -->
                        <input-base
                            @updatedInput="driver.address = $event"
                            name="driverAddress"
                            id="driverAddress"
                            div-class="form-group col-md-3"
                            :label="txt.fields.address"
                            :value="driver.address"
                            required
                        />
                        <!--  -->
                    </div>
                </div>

                <div class="kt-portlet__foot driver-form">
                    <div class="kt-align-right">
                        <button
                            type="submit"
                            id="createTransportDriver"
                            class="btn btn-primary"
                            v-text="txt.form.submitTransportDriver"
                        ></button>
                    </div>
                </div>
            </form>
        </div>
        <!--  -->
    </fragment>
</template>

<script>
import moment from "moment";
import Loading from "../../../../../assets/js/utilities";
import Formatter from "../../../../../SharedAssets/js/formatter.js";
import ErpAjaxTable from "../../../../components/table/ErpAjaxTable.vue";
import ErpInputStaticFilter from "../../../../components/filterStatic/form/ErpInputStaticFilter.vue";
import InputBase from "../../../../../SharedAssets/vue/components/base/inputs/InputBase.vue";
import InputNumber from "../../../../../SharedAssets/vue/components/base/inputs/InputNumber.vue";
import DatePicker from "../../../../../SharedAssets/vue/components/base/inputs/DatePicker.vue";
import SingleSelectPicker from "../../../../../SharedAssets/vue/components/base/inputs/SingleSelectPicker.vue";

export default {
    name: "MovementDriverData",
    props: {
        internalDriver: Boolean,
        providerId: Number,
        branch: Object,
        selectList: Object,
    },
    components: {
        ErpAjaxTable,
        ErpInputStaticFilter,
        InputBase,
        InputNumber,
        DatePicker,
        SingleSelectPicker,
    },
    data() {
        return {
            Formatter,
            txt: txtTrans,
            showDriverList: true,
            showDriverSelected: false,
            showCreateDriverForm: false,
            /* Table config */
            columns: [
                {
                    field: "name",
                    title: txtTrans.fields.name,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "lastName",
                    title: txtTrans.fields.lastName,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "provider",
                    title: txtTrans.fields.provider,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "idNumber",
                    title: txtTrans.fields.idNumber,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "driverLicense",
                    title: txtTrans.fields.driverLicense,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "issueDate",
                    title: txtTrans.fields.issueDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "expirationDate",
                    title: txtTrans.fields.expirationDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "city",
                    title: txtTrans.fields.city,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "state",
                    title: txtTrans.fields.state,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "country",
                    title: txtTrans.fields.country,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    title: txtTrans.fields.options,
                    formatter: this.actionsFormatter,
                    events: {
                        "change .driver-pick": (e, value, row) => this.onDriverAction("select", row),
                    },
                },
            ],
            options: {
                pagination: true,
                locale: "es-ES",
                scrollX: true,
            },
            row: {},
            /* */

            driversList: [],
            stateListFiltered: [],

            driver: {
                id: null,
                internalDriver: null,
                provider: null,
                // rgoUserId: null,
                name: null,
                lastName: null,
                idNumber: null,
                driverLicense: null,
                issueDate: null,
                expirationDate: null,
                city: null,
                state: null,
                country: null,
                postalCode: null,
                address: null,
                branch: null,
            },
        };
    },
    computed: {
        requireProvince() {
            if (!this.driver.country) return false;

            const id = Number(this.driver.country.id ?? this.driver.country.ID);
            const isoRaw =
                this.driver.country.iso ||
                this.driver.country.countryCode ||
                this.driver.country.countryISO ||
                this.driver.country.COUNTRYISO ||
                this.driver.country.code ||
                this.driver.country.ISO ||
                '';
            const iso = typeof isoRaw === 'string' ? isoRaw.toUpperCase() : '';

            const ids = [1]; // Spain (fallback ID)
            const isos = ['ES', 'IC']; // Spain and Canary Islands ISO codes

            return isos.includes(iso) || ids.includes(id);
        },
    },
    mounted() {
        this.driver.internalDriver = this.internalDriver;
        this.driver.provider = {};
        this.driver.provider.id = this.providerId;
        this.assignBranch();
    },
    methods: {
        assignBranch() {
            if (this.internalDriver) {
                if (this.driver.branch === null) this.driver.branch = {};
                this.driver.branch.id = this.branch?.id;
                this.driver.branch.name = this.branch?.name;
            }
        },
        actionsFormatter() {
            return `
                <input
                    type="radio"
                    name="driverList"
                    class="driver-pick"
                    title="${this.txt.form.selectDriver}"
                />`;
        },
        getMinDLExpirationDate() {
            let issueDate = this.driver.issueDate ? moment(this.driver.issueDate, "DD/MM/YYYY") : null;
            let expirationDate = this.driver.expirationDate ? moment(this.driver.expirationDate, "DD/MM/YYYY") : null;
            let issueDateNextYear = issueDate ? issueDate.add(1, "years") : null;

            if (issueDateNextYear && expirationDate && issueDateNextYear.valueOf() > expirationDate.valueOf()) {
                this.driver.expirationDate = null;
            }

            return issueDateNextYear?.format("DD/MM/YYYY") ?? null;
        },
        loadStateList: async function(countryId = null) {
            if (countryId != null) {
                Loading.starLoading();
                let url = this.routing.generate("state.select.list", {
                    countryId: countryId,
                });

                this.axios
                    .get(url)
                    .then((response) => {
                        Loading.endLoading();
                        this.stateListFiltered = response.data;
                    })
                    .catch((error) => {
                        console.log(error.response);
                        Loading.endLoading();
                        this.$notify({
                            type: "error",
                            text: this.txt.form.msgErrorProcessData,
                        });
                    });
            }
        },
        search: async function() {
            this.showDriverList = true;
            this.showDriverSelected = false;
            this.showCreateDriverForm = false;

            let driverName = document.querySelector("form#transport-driver-filters #driverNameFilterId").value;
            let driverLastName = document.querySelector("form#transport-driver-filters #driverLastNameFilterId").value;
            let driverIdNumber = document.querySelector("form#transport-driver-filters #driverIdNumberFilterId").value;
            let driverLicense = document.querySelector("form#transport-driver-filters #driverLicenseFilterId").value;

            this.$store.commit(`filter/items`, {
                name: driverName,
                lastName: driverLastName,
                idNumber: driverIdNumber,
                driverLicense: driverLicense,
            });
        },
        reset() {
            this.fillDriverData(null);
            this.showDriverList = true;
            this.showDriverSelected = false;
            this.showCreateDriverForm = false;
            this.uncheckDriverPicks();
        },
        fillDriverData(data) {
            this.driver.id = data?.id;
            this.driver.internalDriver = data?.internalDriver;

            if (data?.provider) {
                this.driver.provider = {};
                this.driver.provider.id = data.provider.id;
                this.driver.provider.name = data.provider.name;
                if (this.driver.provider.id != null && [null, undefined].includes(this.driver.provider.name)) {
                    this.driver.provider.name = this.selectList.supplierList.filter(
                        (current) => current.id === this.driver.provider.id
                    )[0]?.name;
                }
            } else {
                this.driver.provider = null;
            }

            this.driver.name = data?.name;
            this.driver.lastName = data?.lastName;
            this.driver.idNumber = data?.idNumber;
            this.driver.driverLicense = data?.driverLicense;
            this.driver.issueDate = data?.issueDate;
            this.driver.expirationDate = data?.expirationDate;
            this.driver.city = data?.city;

            if (data?.state) {
                this.driver.state = {};
                this.driver.state.name = data.state.name;
                this.driver.state.id =
                    data.state.id || this.stateListFiltered.filter((current) => current.name === this.driver.state.name)[0]?.id;
            } else {
                this.driver.state = null;
            }

            if (data?.country) {
                this.driver.country = {};
                this.driver.country.name = data.country.name;
                this.driver.country.id =
                    data.country.id ||
                    this.selectList.countryList.filter((current) => current.name === this.driver.country.name)[0]?.id;
            } else {
                this.driver.country = null;
            }

            this.driver.postalCode = data?.postalCode;
            this.driver.address = data?.address;

            if (data?.branch) {
                this.driver.branch = {};
                this.driver.branch.id = data.branch.id;
                this.driver.branch.name =
                    data.branch.name ||
                    this.selectList.branchList.filter((current) => current.name === this.driver.branch.id)[0]?.name;
            } else {
                this.driver.branch = null;
            }

            if (data === null && this.internalDriver) this.assignBranch();
        },
        onDriverAction(action, row) {
            this.showDriverList = false;
            this.showDriverSelected = false;
            this.showCreateDriverForm = false;
            this.fillDriverData(null);

            Loading.starLoading();

            switch (action) {
                case "new":
                    this.$emit("action", null);
                    this.showCreateDriverForm = true;
                    break;
                case "select":
                    this.fillDriverData(row);
                    this.$emit("action", row.id);
                    this.showDriverSelected = true;
                    break;
                case "update":
                    this.$emit("action", this.driver.id);
                    break;
            }

            Loading.endLoading();
        },
        changeDriver() {
            this.fillDriverData(null);
            this.showDriverSelected = false;
            this.showDriverList = true;
            this.uncheckDriverPicks();
        },
        uncheckDriverPicks() {
            const elements = document.querySelectorAll("#driver-table .driver-pick");
            elements.forEach((element) => {
                element.checked = false;
            });
        },
        checkFormFields() {
            for (let prop in this.driver) {
                if (prop !== "id") {
                    if (!this.driver.internalDriver && prop === "provider") {
                        if (["", null, undefined].includes(this.driver[prop]["id"])) {
                            // console.log(prop);
                            return false;
                        }
                    }
                }
            }

            return true;
        },
        async submitNewTransportDriver() {
            this.driver.internalDriver = this.internalDriver;
            if (this.driver.provider === null) this.driver.provider = {};
            this.driver.provider.id = this.providerId;

            if (this.checkFormFields()) {
                Loading.starLoading();

                let formData = new FormData();
                formData.set("driver", JSON.stringify(this.driver));
                let url = this.routing.generate("transportDriver.store");

                this.axios
                    .post(url, formData)
                    .then((response) => {
                        // console.log("Create Transport Driver: ", response);
                        Loading.endLoading();

                        if (response.status === 200) {
                            this.$notify({
                                type: "success",
                                text: this.txt.form.transportDriverCreatedSuccessNotification,
                            });

                            this.onDriverAction("select", response.data.driverData);
                            this.$emit("action", this.driver.id);
                        } else {
                            this.$notify({
                                type: "error",
                                text: this.txt.form.transportDriverCreatedErroNotification,
                            });
                        }
                    })
                    .catch((error) => {
                        console.error(error.response);
                        Loading.endLoading();
                        this.$notify({
                            type: "error",
                            text: this.txt.form.transportDriverCreatedErroNotification,
                        });
                    });
            } else {
                this.$notify({
                    type: "error",
                    text: this.txt.form.providerNeed,
                });
                document.querySelector("#provider").focus();
            }
        },
    },
    watch: {
        internalDriver() {
            this.driver.internalDriver = this.internalDriver;
            this.assignBranch();
        },
        providerId() {
            if (this.driver.provider === null) this.driver.provider = {};
            this.driver.provider.id = this.providerId;
        },
        'driver.country': {
            handler() {
                if (!this.requireProvince) {
                    this.driver.state = null;
                    this.driver.postalCode = null;
                }
            },
            deep: true,
        },
    },
};
</script>

<style scoped>
/* Footer */
.kt-portlet__foot {
    display: inherit !important;
}
.kt-portlet__foot.driver-form {
    display: flex !important;
    flex-direction: row-reverse;
}
/*  */
</style>
