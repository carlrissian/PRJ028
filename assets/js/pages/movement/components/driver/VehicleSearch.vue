<template>
    <fragment>
        <div class="row">
            <div class="col-md-12">
                <!-- Search vehicle module -->
                <div class="kt-portlet kt-portlet--bordered">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title" v-text="this.txt.titles.vehicleSearch"></h3>
                        </div>
                    </div>
                    <form
                        @submit.prevent="search"
                        ref="vehicleSearchForm"
                        class="kt-form"
                        autocomplete="off"
                        enctype="multipart/form-data"
                    >
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="form-group col-md-3 col-sm-6">
                                    <label for="licensePlate" v-text="this.txt.fields.licensePlate"></label>
                                    <input
                                        type="text"
                                        name="licensePlate"
                                        id="licensePlate"
                                        class="form-control uppercase"
                                        :placeholder="this.txt.fields.licensePlatePH"
                                        v-model="licensePlate"
                                    />
                                </div>
                                <div class="form-group col-md-3 col-sm-6">
                                    <label for="vin" v-text="this.txt.fields.vin"></label>
                                    <input
                                        type="text"
                                        name="vin"
                                        id="vin"
                                        class="form-control uppercase"
                                        :placeholder="this.txt.fields.vinPH"
                                        v-model="vin"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__foot search">
                            <div class="text-right">
                                <div class="kt-align-right">
                                    <button type="submit" class="btn btn-dark kt-label-bg-color-4" :disabled="this.searching">
                                        <i class="la la-search"></i>
                                        {{ this.txt.form.search }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!--  -->
            </div>
        </div>

        <movement-driver-vehicle-data :vehicle="this.vehicle"></movement-driver-vehicle-data>
    </fragment>
</template>

<script>
import Axios from "axios";
import Loading from "../../../../../assets/js/utilities";
import MovementDriverVehicleData from "./MovementDriverVehicleData";

export default {
    name: "VehicleSearch",
    components: {
        MovementDriverVehicleData,
    },
    data() {
        return {
            txt: {},
            vehicle: null,
            searching: false,
            vin: null,
            licensePlate: null,
        };
    },
    created() {
        this.txt = txtTrans;
    },
    methods: {
        showNotification(type = "", text = "") {
            this.$notify({
                text,
                type,
            });
        },
        checkField(field) {
            if (["", null, undefined].includes(field)) {
                return false;
            } else if (typeof field === "string" && field.trim() === "") {
                return false;
            }

            return true;
        },
        async search() {
            this.$emit("reset");
            this.vehicle = null;
            this.searching = true;

            if (!this.checkField(this.licensePlate) && !this.checkField(this.vin)) {
                this.searching = false;
                this.showNotification("warn", this.txt.form.pleaseFillFields);
            } else {
                Loading.starLoading();

                //Se envía siempre en mayusculas
                let licensePlate = this.licensePlate ? this.licensePlate.toUpperCase() : null;
                let vin = this.vin ? this.vin.toUpperCase() : null;

                let url = this.routing.generate("vehicle.exist", {
                    licensePlate: licensePlate,
                    vin: vin,
                });
                Axios.get(url)
                    .then((response) => {
                        // console.log("Create movement | Vehicle search: ", response);
                        Loading.endLoading();
                        this.searching = false;

                        if (response.data.exist) {
                            this.vehicle = response.data.vehicle;
                            this.$emit("onSuccessSearch", this.vehicle);
                        }
                    })
                    .catch((e) => {
                        console.log(e);
                        Loading.endLoading();
                        this.searching = false;
                        if (e.response.status === 404) {
                            this.showNotification("error", this.txt.form.vehicleNotFound);
                        } else {
                            this.showNotification("error", this.txt.form.errorOnSearch);
                        }
                    });
            }
        },
    },
};
</script>

<style scoped>
.kt-portlet__foot.search {
    display: inherit !important;
}
.uppercase {
    text-transform: uppercase;
}
</style>
