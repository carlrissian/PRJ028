<template>
    <fragment>
        <div class="kt-portlet kt-portlet--bordered">
            <div class="kt-portlet__body">
                <div class="row text-center">
                    <div class="col-md-12 col-lg-6">
                        <h3 v-text="this.txt.titles.downloadTemplate"></h3>
                        <button @click="downloadTemplate" type="button" class="btn btn-dark kt-label-bg-color-4 mb-5 download">
                            <i class="la la-download"></i>
                            {{ this.txt.form.download }}
                        </button>
                    </div>

                    <div class="col-md-12 col-lg-6">
                        <h3 v-text="this.txt.titles.uploadExcel"></h3>
                        <div class="row">
                            <erp-input-file-static-filter
                                :class-number="'4'"
                                :accepted-files="
                                    '.csv, text/csv, application/vnd.ms-excel, application/csv, text/x-csv, application/x-csv, text/comma-separated-values, text/x-comma-separated-values'
                                "
                                :server="routing.generate('routes.uploadCSV')"
                                :token="token"
                                :name="'fileCSV'"
                                @onAddingFile="flushMessages"
                                @ajaxOnload="success"
                                @ajaxError="failed"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            v-show="messages.length > 0"
            class="alert alert-custom fade show"
            :class="error ? 'alert-danger' : 'alert-warning'"
            role="alert"
        >
            <div class="alert-icon"><em :class="error ? 'flaticon2-cross' : 'flaticon-warning'"></em></div>
            <div class="alert-text">
                <p v-for="message in messages" v-html="message" style="margin: 0"></p>
            </div>
            <div class="alert-close">
                <button @click="flushMessages" type="button" class="close" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-xl la la-close"></i></span>
                </button>
            </div>
        </div>
        <div v-show="successMessage !== null" class="alert-success alert alert-custom fade show" role="alert">
            <div class="alert-icon"><em class="flaticon2-check-mark"></em></div>
            <div class="alert-text">
                <p v-html="successMessage" style="margin: 0"></p>
            </div>
            <div class="alert-close">
                <button @click="flushMessages" type="button" class="close" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-xl la la-close"></i></span>
                </button>
            </div>
        </div>
    </fragment>
</template>

<script>
import ErpInputFileStaticFilter from "../../../../components/filterStatic/form/ErpInputFileStaticFilter";

export default {
    name: "ExcelRoutePage",
    components: { ErpInputFileStaticFilter },
    props: {
        token: String,
    },
    data() {
        return {
            txt: {},
            messages: [],
            successMessage: null,
            error: false,
        };
    },
    created() {
        this.txt = txtTrans;
    },
    methods: {
        downloadTemplate() {
            location.href = this.routing.generate("routes.downloadTemplate");
        },
        flushMessages() {
            this.messages = [];
            this.successMessage = null;
        },
        failed(response) {
            let resp = JSON.parse(response);
            this.messages = resp.messages;
            this.error = resp.code === 500;
        },
        success(response) {
            let resp = JSON.parse(response);
            let routesAffectedList = `<ul>
                <li>${this.txt.form.createdRoutes} (ID): ${resp.affectedRoutes.created.join(", ")}</li>
                <li>${this.txt.form.updatedRoutes} (ID): ${resp.affectedRoutes.updated.join(", ")}</li>
                <li>${this.txt.form.deletedRoutes} (ID): ${resp.affectedRoutes.deleted.join(", ")}</li>
            </ul>
            `;
            this.successMessage = resp.messages + routesAffectedList;


        },
    },
};
</script>

<style>
.download {
    margin-top: 3em !important;
}

.filepond--root,
.filepond--root .filepond--drop-label {
    height: 80px;
}

.filepond--item {
    height: 50px;
}

.filepond--root .filepond--list-scroller {
    margin-top: 1.2em !important;
    height: 60px !important;
    z-index: 1;
}
</style>
