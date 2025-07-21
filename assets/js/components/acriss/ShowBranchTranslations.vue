<template>
    <fragment>
        <div v-if="this.branchTranslationsList != null && this.branchTranslationsList.length > 0">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-toolbar">
                    <ul class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
                        <li class="nav-item" v-for="(branchTranslation, index) in branchTranslationsList">
                            <a
                                class="nav-link"
                                :class="index === 0 ? 'active' : ''"
                                data-toggle="tab"
                                :href="'#kt_widget_' + index"
                                role="tab"
                                v-text="branchTranslation.branch.IATA"
                            >
                            </a>
                            <input type="hidden" :name="'branch[' + index + '][id]'" :value="branchTranslation.id" />
                        </li>
                    </ul>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="tab-content">
                    <div
                        v-for="(branchTranslation, index) in branchTranslationsList"
                        class="tab-pane"
                        :class="index === 0 ? 'active' : ''"
                        :id="'kt_widget_' + index"
                    >
                        <input type="hidden" :name="'branch[' + index + '][id]'" v-model="branchTranslation.id" />
                        <div class="row" style="padding-bottom: 1em;">
                            <div class="col-md-3">
                                <label><strong v-text="txt.fields.commercialName + ':'"></strong></label>
                                <p>{{ branchTranslation.branch.name }}</p>
                            </div>

                            <div class="kt-checkbox-inline">
                                <label class="kt-checkbox control-label">
                                    <label><strong v-text="txt.fields.defaultBranch"></strong></label>
                                    <input
                                        type="checkbox"
                                        :checked="branchTranslation.default"
                                        onclick="return false;"
                                    />
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label><strong v-text="txt.titles.imageList"></strong></label>
                                <show-image-line :image-line-list="branchTranslation.imageLines" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label><strong v-text="txt.titles.translationsList"></strong></label>
                                <show-translations :translation-line-list="branchTranslation.translations" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="col-md-12">
            <label><strong v-text="txt.form.notTranslations"></strong></label>
        </div>
    </fragment>
</template>
<script>
import ShowTranslations from "./ShowTranslations.vue";
import ShowImageLine from "./ShowImageLine.vue";

export default {
    name: "ShowBranchTranslations",
    components: {
        ShowTranslations,
        ShowImageLine,
    },
    props: {
        branchTranslationsList: {},
    },
    data() {
        return {
            txt: {},
        };
    },
    created() {
        this.txt = txtTrans;
    },
    methods: {},
};
</script>
<style scoped></style>
