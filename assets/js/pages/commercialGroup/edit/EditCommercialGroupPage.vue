<template>
    <fragment>
        <notifications position="top right"></notifications>

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
                                            this.txt.titles.editCommercialGroup
                                        "
                                    ></h3>
                                </div>
                            </div>
                            <form
                                @submit.prevent="updateCommercialGroup"
                                enctype="multipart/form-data"
                            >
                                <!-- Commercial group details -->
                                <div class="kt-portlet__body">
                                    <div class="row">
                                        <input
                                            type="hidden"
                                            name="id"
                                            v-model="commercialGroup.id"
                                        />

                                        <div class="form-group col-md-4">
                                            <label
                                                for="name"
                                                v-text="this.txt.fields.name"
                                            ></label>
                                            <input
                                                type="text"
                                                name="name"
                                                id="name"
                                                class="form-control"
                                                :placeholder="
                                                    this.txt.fields.name
                                                "
                                                v-model="commercialGroup.name"
                                                required
                                            />
                                        </div>

                                        <erp-multiple-select-static-filter
                                            :value="commercialGroup.acrissIds"
                                            @changeSelectMultiple="
                                                onSelectAcrissChange
                                            "
                                            classNumber="4"
                                            :label="txt.fields.acriss"
                                            name="acrissIds[]"
                                            id="acrissIds"
                                            :data-for-ajax="acrissList"
                                        />

                                        <div class="form-group col-md-4">
                                            <label
                                                for="status"
                                                v-text="this.txt.fields.status"
                                            ></label>
                                            <div class="form-check">
                                                <input
                                                    type="checkbox"
                                                    name="status"
                                                    id="status"
                                                    class="form-check-input"
                                                    v-model="
                                                        commercialGroup.status
                                                    "
                                                />
                                                <label
                                                    v-text="
                                                        commercialGroup.status
                                                            ? this.txt.form
                                                                  .activated
                                                            : this.txt.form
                                                                  .deactivated
                                                    "
                                                ></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->

                                <!-- Commercial group translations -->
                                <div class="kt-portlet__body">
                                    <h5 v-text="txt.fields.translations"></h5>

                                    <div class="row">
                                        <!-- Add translation module -->
                                        <div class="col-md-12 mb-4">
                                            <div
                                                class="col-md-4"
                                                style="display: inline-block"
                                            >
                                                <label
                                                    for="language"
                                                    v-text="
                                                        this.txt.fields.language
                                                    "
                                                ></label>
                                                <select
                                                    name="language"
                                                    id="language"
                                                    class="form-control kt-selectpicker"
                                                    v-model="languageId"
                                                    :data-size="
                                                        this.languageList.length
                                                    "
                                                    data-live-search="true"
                                                >
                                                    <option
                                                        v-for="item in this
                                                            .languageList"
                                                        :key="item.id"
                                                        :value="item.id"
                                                    >
                                                        {{ item.name }}
                                                    </option>
                                                </select>
                                            </div>

                                            <button
                                                @click="addLanguage()"
                                                type="button"
                                                class="btn btn-primary"
                                            >
                                                <i class="la la-plus"></i>
                                                {{ this.txt.form.addLanguage }}
                                            </button>
                                        </div>
                                        <!--  -->

                                        <!-- Translations list -->
                                        <div
                                            v-if="
                                                commercialGroup.translations
                                                    .length > 0
                                            "
                                            class="col-md-12"
                                            v-for="(translation,
                                            index) in commercialGroup.translations"
                                            :key="index"
                                        >
                                            <h6
                                                v-if="translation.default"
                                                v-text="txt.fields.byDefault"
                                            ></h6>

                                            <div class="kt-checkbox-inline">
                                                <label
                                                    class="kt-checkbox control-label"
                                                    style="display: inline-block; margin-bottom:15px; "
                                                >
                                                    <input
                                                        type="checkbox"
                                                        @change="
                                                            onTranslationDefaultChange($event)
                                                        "
                                                        class="defaultTranslation"
                                                        :id="
                                                            'defaultTranslation' +
                                                                translation.languageId
                                                        "
                                                        :name="
                                                            'defaultTranslation' +
                                                                translation.languageId
                                                        "
                                                        :value="
                                                            translation.languageId
                                                        "
                                                        :checked="
                                                            translation.default
                                                        "
                                                    />
                                                    <span></span>
                                                </label>
                                                <h6
                                                    style="display: inline-block"
                                                    v-text="
                                                        translation.languageCode
                                                    "
                                                ></h6>
                                                <div
                                                    style="display: inline-block"
                                                    class="col-md-4"
                                                >
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        v-model="
                                                            commercialGroup
                                                                .translations[
                                                                index
                                                            ].translation
                                                        "
                                                        :name="
                                                            'translation' +
                                                                translation.languageId
                                                        "
                                                        :id="
                                                            'translation' +
                                                                translation.languageId
                                                        "
                                                    />
                                                </div>
                                                <button
                                                    @click="
                                                        deleteTranslation(index)
                                                    "
                                                    type="button"
                                                    class="btn btn-icon delete"
                                                    style="display: inline-block"
                                                >
                                                    <i
                                                        class="fa fa-times btn-outline-hover-danger"
                                                    ></i>
                                                </button>
                                            </div>
                                        </div>
                                        <p
                                            v-else
                                            v-text="txt.form.notTranslations"
                                        ></p>
                                        <!--  -->
                                    </div>
                                </div>
                                <!--  -->

                                <div class="kt-portlet__foot">
                                    <div class="text-right">
                                        <div class="kt-align-right">
                                            <button
                                                type="submit"
                                                id="btn-update"
                                                class="btn btn-dark kt-label-bg-color-4"
                                                v-text="this.txt.form.update"
                                            ></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fragment>
</template>

<script>
import Axios from "axios";
import Loading from "../../../../assets/js/utilities";
import ErpMultipleSelectStaticFilter from "../../../components/filterStatic/form/ErpMultipleSelectStaticFilter";

export default {
    name: "EditCommercialGroupPage",
    components: {
        ErpMultipleSelectStaticFilter,
    },
    props: {
        data: {},
    },
    data() {
        return {
            txt: {},
            commercialGroup: {
                id: null,
                name: "",
                acrissIds: null,
                status: null,
                translations: null,
            },
            languageId: null,
            defaultTranslationId: null,
            acrissList: [],
            languageList: [],
        };
    },
    created() {
        this.txt = txtTrans;
        console.log(this.data);
    },
    mounted() {
        this.commercialGroup = this.data.commercialGroup;

        this.acrissList = this.data.selectList.acrissList;
        this.languageList = this.data.selectList.languageList;

        this.loadSelectPicker();
        $("#acrissIds").attr("required", true);
    },
    updated() {
        this.$nextTick(function() {
            $("#language").selectpicker("refresh");
        });
    },
    methods: {
        showNotification(type = "", text = "", duration = 3000) {
            this.$notify({
                text,
                type,
                duration,
            });
        },
        loadSelectPicker() {
            let config = {
                noneSelectedText: this.txt.form.selectAnOption,
                actionsBox: true,
            };

            // language
            let language = $("#language");
            language.selectpicker(config);
        },
        onSelectAcrissChange() {
            this.commercialGroup.acrissIds = $("#acrissIds").val();
        },

        /* Translations */
        addLanguage() {
            let $this = this;

            if (this.languageId == null || this.languageId == "") {
                this.showNotification(
                    "warn",
                    this.txt.form.selectLanguageToAdd
                );
                return;
            } else {
                let languageExists = this.commercialGroup.translations.filter(
                    function(arr) {
                        return arr.languageId == $this.languageId;
                    }
                );
                if (languageExists.length > 0) {
                    this.showNotification(
                        "warn",
                        this.txt.form.languageAlreadyExists
                    );
                } else {
                    let languageToAdd = this.languageList.filter(function(arr) {
                        return arr.id == $this.languageId;
                    });

                    let translation = {
                        id: null,
                        languageCode: languageToAdd[0].languageCode,
                        languageId: languageToAdd[0].id,
                        translation: "",
                        default: this.commercialGroup.translations.length === 0,
                    };
                    this.commercialGroup.translations.push(translation);

                    if (this.commercialGroup.translations.length == 1) {
                        this.defaultTranslationId = translation.languageId;
                    }

                    this.$nextTick(function() {
                        this.changeCheckboxes();
                    });

                    this.languageId = null;
                }
            }
        },
        deleteTranslation(index) {
            this.commercialGroup.translations.splice(index, 1);

            if (this.commercialGroup.translations.length > 0) {
                this.$nextTick(function() {
                    this.changeCheckboxes();
                });
            }

            this.$forceUpdate();
        },
        onTranslationDefaultChange(e) {
            this.defaultTranslationId = e.target.value;
            this.$nextTick(function() {
                this.changeCheckboxes();
            });
        },
        changeCheckboxes() {
            for (const translation of this.commercialGroup.translations) {
                if (translation.languageId == this.defaultTranslationId) {
                    translation.default = true;
                    $("#defaultTranslation" + translation.languageId).attr(
                        "disabled",
                        "disabled"
                    );
                } else {
                    translation.default = false;
                    $(
                        "#defaultTranslation" + translation.languageId
                    ).removeAttr("disabled");
                    $(
                        "#defaultTranslation" + translation.languageId
                    ).checked = false;
                }
            }
        },
        /* */

        async updateCommercialGroup() {
            Loading.starLoading();

            let formData = new FormData();
            formData.set(
                "commercialGroup",
                JSON.stringify(this.commercialGroup)
            );
            let url = this.routing.generate("commercialgroup.update");
            Axios.post(url, formData)
                .then((response) => {
                    Loading.endLoading();
                    // console.log("Update Commercial Group: ", response);

                    if (response.data.updated) {
                        this.showNotification(
                            "success",
                            this.txt.form
                                .commercialGroupUpdatedSuccessNotification
                        );

                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else if (response.data.nameExists) {
                        this.showNotification(
                            "warn",
                            this.txt.form.nameAlreadyExists
                        );
                    } else {
                        this.showNotification(
                            "error",
                            this.txt.form
                                .errorUpdatingCommercialGroupNotification
                        );
                    }
                })
                .catch((e) => {
                    console.log(e);
                    this.showNotification(
                        "error",
                        this.txt.form.errorUpdatingCommercialGroupNotification
                    );

                    Loading.endLoading();
                });
        },
    },
};
</script>

<style scoped></style>
