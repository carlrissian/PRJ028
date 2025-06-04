<template>
    <div class="row">
        <div class="col-md-12">
            <div class="kt-portlet kt-portlet--bordered">
                <div class="kt-portlet__body">
                    <div class="kt-portlet kt-portlet--bordered">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3
                                    class="kt-portlet__head-title"
                                    v-text="
                                        this.txt.titles.commercialGroupDetails
                                    "
                                ></h3>
                            </div>
                        </div>

                        <!-- Details commercial group module -->
                        <div
                            v-if="this.commercialGroup != null"
                            class="kt-portlet__body"
                        >
                            <div class="group row mt-3">
                                <div class="col-3">
                                    <h6
                                        v-text="txt.fields.commercialGroup"
                                    ></h6>
                                    <p v-text="commercialGroup.name"></p>
                                </div>

                                <div class="col-3">
                                    <h6 v-text="txt.fields.acriss"></h6>
                                    <p v-text="commercialGroup.acrissName"></p>
                                </div>

                                <div class="col-3">
                                    <h6 v-text="txt.fields.status"></h6>
                                    <p
                                        v-text="
                                            commercialGroup.status !== null
                                                ? commercialGroup.status
                                                    ? this.txt.form.activated
                                                    : this.txt.form.deactivated
                                                : '-'
                                        "
                                    ></p>
                                </div>
                            </div>
                        </div>
                        <!--  -->

                        <!-- Commercial group translations -->
                        <div class="kt-portlet__body">
                            <h5 v-text="txt.fields.translations"></h5>

                            <div
                                v-if="
                                    commercialGroup.translationList.length > 0
                                "
                                class="col-md-12"
                                v-for="(translation,
                                index) in commercialGroup.translationList"
                                :key="index"
                            >
                                <h6
                                    v-if="translation.default"
                                    v-text="txt.fields.byDefault"
                                ></h6>

                                <div class="kt-checkbox-inline">
                                    <label class="kt-checkbox control-label">
                                        <input
                                            type="checkbox"
                                            :checked="translation.default"
                                            readonly
                                            disabled
                                        />
                                        <span></span>
                                        <div style="display: inline-block">
                                            <h6
                                                v-text="
                                                    translation.languageCode
                                                "
                                            ></h6>
                                        </div>
                                        <div
                                            style="margin-left:1rem; display: inline-block"
                                            v-text="translation.translation"
                                        ></div>
                                    </label>
                                </div>
                            </div>
                            <p v-else v-text="txt.form.notTranslations"></p>
                        </div>
                        <!--  -->

                        <div class="kt-portlet__foot">
                            <div class="text-right">
                                <div class="kt-align-right">
                                    <button
                                        @click="editPage"
                                        id="btn-edit"
                                        class="btn btn-dark kt-label-bg-color-4"
                                    >
                                        <i class="fas fa-pen"></i>
                                        {{ this.txt.form.edit }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ShowCommercialGroupPage",
    components: {},
    props: {
        commercialGroup: {},
    },
    data() {
        return {
            txt: {},
        };
    },
    created() {
        this.txt = txtTrans;
        // console.log(this.commercialGroup);
    },
    methods: {
        editPage() {
            window.location.href = this.routing.generate(
                "commercialgroup.edit",
                {
                    id: this.commercialGroup.id,
                }
            );
        },
    },
};
</script>

<style scoped></style>
