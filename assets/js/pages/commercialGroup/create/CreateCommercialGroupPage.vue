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
                                            this.txt.titles
                                                .createCommercialGroup
                                        "
                                    ></h3>
                                </div>
                            </div>
                            <form
                                @submit.prevent="createCommercialGroup"
                                enctype="multipart/form-data"
                            >
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

                                        <!-- <div class="form-group col-md-4">
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
                                        </div> -->
                                    </div>
                                </div>

                                <div class="kt-portlet__foot">
                                    <div class="text-right">
                                        <div class="kt-align-right">
                                            <button
                                                type="submit"
                                                id="btn-create"
                                                class="btn btn-dark kt-label-bg-color-4"
                                                v-text="this.txt.form.create"
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
    name: "CreateCommercialGroupPage",
    components: {
        ErpMultipleSelectStaticFilter,
    },
    props: {
        selectList: {},
    },
    data() {
        return {
            txt: {},
            commercialGroup: {
                name: "",
                acrissIds: null,
                status: false,
            },
            acrissList: [],
        };
    },
    created() {
        this.txt = txtTrans;
    },
    mounted() {
        this.acrissList = this.selectList.acrissList;
        $("#acrissIds").attr("required", true);
    },
    methods: {
        showNotification(type = "", text = "", duration = 3000) {
            this.$notify({
                text,
                type,
                duration,
            });
        },
        onSelectAcrissChange() {
            this.commercialGroup.acrissIds = $("#acrissIds").val();
        },
        async createCommercialGroup() {
            Loading.starLoading();

            console.log(this.commercialGroup);

            let formData = new FormData();
            formData.set(
                "commercialGroup",
                JSON.stringify(this.commercialGroup)
            );
            let url = this.routing.generate("commercialgroup.store");
            Axios.post(url, formData)
                .then((response) => {
                    Loading.endLoading();
                    // console.log("Create Commercial Group: ", response);

                    if (response.data.created) {
                        this.showNotification(
                            "success",
                            this.txt.form
                                .commercialGroupCreatedSuccessNotification
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
                                .errorCreatingCommercialGroupNotification
                        );
                    }
                })
                .catch((e) => {
                    console.log(e);
                    this.showNotification(
                        "error",
                        this.txt.form.errorCreatingCommercialGroupNotification
                    );

                    Loading.endLoading();
                });
        },
    },
};
</script>
<style scoped></style>
