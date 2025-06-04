<template>
    <fragment>
        <notifications position="top right"></notifications>

        <div class="row">
            <div class="col-md-12">
                <!-- Search vehicle module -->
                <div class="kt-portlet kt-portlet--bordered">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title" v-text="txt.titles.vehicleSearch"></h3>
                        </div>
                    </div>

                    <form @submit.prevent="vehicleSearch" class="kt-form" autocomplete="off" enctype="multipart/form-data">
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="form-group col-md-3 col-sm-6">
                                    <label for="licensePlate" v-text="txt.fields.licensePlate"></label>
                                    <input
                                        type="text"
                                        name="licensePlate"
                                        id="licensePlate"
                                        class="form-control"
                                        :placeholder="txt.fields.licensePlatePH"
                                        v-model="licensePlate"
                                        oninput="value = value.toUpperCase()"
                                    />
                                </div>
                                <div class="form-group col-md-3 col-sm-6">
                                    <label for="vin" v-text="txt.fields.vin"></label>
                                    <input
                                        type="text"
                                        name="vin"
                                        id="vin"
                                        class="form-control"
                                        :placeholder="txt.fields.vinPH"
                                        v-model="vin"
                                        oninput="value = value.toUpperCase()"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="kt-portlet__foot">
                            <div class="text-right">
                                <div class="kt-align-right">
                                    <button type="submit" class="btn btn-dark kt-label-bg-color-4" :disabled="searching">
                                        <i class="la la-search"></i>
                                        {{ txt.form.search }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!--  -->
            </div>
        </div>
    </fragment>
</template>

<script>
import Axios from "axios";
import Loading from "../../../assets/js/utilities";

export default {
    name: "VehicleSearchPage",
    components: {},
    data() {
        return {
            txt: {},
            searching: false,
            vin: null,
            licensePlate: null,
            vehicleId: null,
        };
    },
    created() {
        this.txt = txtTrans;
    },
    methods: {
        checkField(field) {
            if (["", null, undefined].includes(field)) {
                return false;
            }
            if (typeof field === "string" && field.trim() === "") {
                return false;
            }

            return true;
        },
        async vehicleSearch() {
            this.searching = true;

            if (!this.checkField(this.licensePlate) && !this.checkField(this.vin)) {
                this.searching = false;
                this.$notify({
                    type: "warn",
                    text: this.txt.form.pleaseFillFields,
                });
            } else {
                Loading.starLoading();

                let url = this.routing.generate("vehicle.exist", {
                    licensePlate: this.licensePlate,
                    vin: this.vin,
                });
                Axios.get(url)
                    .then((response) => {
                        // console.log("Vehicle search: ", response);
                        Loading.endLoading();
                        this.searching = false;

                        if (response.data.exist) {
                            this.vehicleId = response.data.vehicle.id;
                            window.location = this.routing.generate("vehicle.details", {
                                licensePlate: response.data.vehicle.licensePlate,
                            });
                        }
                    })
                    .catch((error) => {
                        console.log(error.response);
                        Loading.endLoading();
                        this.searching = false;
                        this.$notify({
                            type: "error",
                            text: error.response.status === 404 ? this.txt.form.vehicleNotFound : this.txt.form.errorOnSearch,
                        });
                    });
            }
        },
    },
};
</script>

<style scoped></style>
