<template>
    <fragment>
        <notifications position="top right"></notifications>

        <div v-if="this.acriss !== null" class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--bordered">
                    <div class="kt-portlet__body">
                        <div class="kt-portlet kt-portlet--bordered">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title" v-text="this.txt.titles.acrissDetails"></h3>
                                </div>
                            </div>

                            <div class="kt-portlet__body">
                                <!-- Section 1 -->
                                <div class="group row">
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.acriss1stLetter"></h6>
                                        <p v-text="formatField(acriss.acriss1stLetter)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.acriss2ndLetter"></h6>
                                        <p v-text="formatField(acriss.acriss2ndLetter)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.acriss3rdLetter"></h6>
                                        <p v-text="formatField(acriss.acriss3rdLetter)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.acriss4thLetter"></h6>
                                        <p v-text="formatField(acriss.acriss4thLetter)"></p>
                                    </div>

                                    <div class="col-md-12 mt-3 mb-4">
                                        <h5 v-text="this.txt.titles.vehicleFields"></h5>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.carClass"></h6>
                                        <p v-text="formatField(acriss.carClass)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.acrissType"></h6>
                                        <p v-text="formatField(acriss.acrissType)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.gearBox"></h6>
                                        <p v-text="formatField(acriss.gearBox)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.motorizationType"></h6>
                                        <p v-text="formatField(acriss.motorizationType)"></p>
                                    </div>
                                </div>
                                <!--  -->

                                <div class="border-bottom col-md-12 mt-5 mb-5" />

                                <!-- Section 2 -->
                                <div class="group row">
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.numberSuitcase"></h6>
                                        <p v-text="formatField(acriss.numberSuitcase)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.numberSeats"></h6>
                                        <p v-text="formatField(acriss.numberSeats)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.numberDoors"></h6>
                                        <p v-text="formatField(acriss.numberDoors)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.commercialVehicle"></h6>
                                        <p
                                            v-text="
                                                acriss.commercialVehicle != null && acriss.commercialVehicle
                                                    ? this.txt.form.yes
                                                    : this.txt.form.no
                                            "
                                        ></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.mediumTerm"></h6>
                                        <p
                                            v-text="
                                                acriss.mediumTerm != null && acriss.mediumTerm
                                                    ? this.txt.form.yes
                                                    : this.txt.form.no
                                            "
                                        ></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.startDate"></h6>
                                        <p v-text="formatDate(acriss.startDate)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.endDate"></h6>
                                        <p v-text="formatDate(acriss.endDate)"></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.minAge"></h6>
                                        <p v-text="formatField(acriss.minAge)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.maxAge"></h6>
                                        <p v-text="formatField(acriss.maxAge)"></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.driverLicenseClassB"></h6>
                                        <p
                                            v-text="
                                                acriss.driverLicenseClassB != null && acriss.driverLicenseClassB
                                                    ? this.txt.form.yes
                                                    : this.txt.form.no
                                            "
                                        ></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.driverLicenseClassA"></h6>
                                        <p
                                            v-text="
                                                acriss.driverLicenseClassA != null && acriss.driverLicenseClassA
                                                    ? this.txt.form.yes
                                                    : this.txt.form.no
                                            "
                                        ></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.driverLicenseClassA1"></h6>
                                        <p
                                            v-text="
                                                acriss.driverLicenseClassA1 != null && acriss.driverLicenseClassA1
                                                    ? this.txt.form.yes
                                                    : this.txt.form.no
                                            "
                                        ></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.driverLicenseClassA2"></h6>
                                        <p
                                            v-text="
                                                acriss.driverLicenseClassA2 != null && acriss.driverLicenseClassA2
                                                    ? this.txt.form.yes
                                                    : this.txt.form.no
                                            "
                                        ></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.minAgeExperienceClassB"></h6>
                                        <p v-text="formatField(acriss.minAgeExperienceClassB)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.minAgeExperienceClassA"></h6>
                                        <p v-text="formatField(acriss.minAgeExperienceClassA)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.minAgeExperienceClassA1"></h6>
                                        <p v-text="formatField(acriss.minAgeExperienceClassA1)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.minAgeExperienceClassA2"></h6>
                                        <p v-text="formatField(acriss.minAgeExperienceClassA2)"></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.minHeight"></h6>
                                        <p v-text="formatField(acriss.minHeight)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.maxHeight"></h6>
                                        <p v-text="formatField(acriss.maxHeight)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.minLength"></h6>
                                        <p v-text="formatField(acriss.minLength)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.maxLength"></h6>
                                        <p v-text="formatField(acriss.maxLength)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.minWidth"></h6>
                                        <p v-text="formatField(acriss.minWidth)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.maxWidth"></h6>
                                        <p v-text="formatField(acriss.maxWidth)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.minTareWeight"></h6>
                                        <p v-text="formatField(acriss.minTareWeight)"></p>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 v-text="this.txt.fields.maxTareWeight"></h6>
                                        <p v-text="formatField(acriss.maxTareWeight)"></p>
                                    </div>
                                </div>
                                <!--  -->

                                <div class="border-bottom col-md-12 mt-5 mb-5" />

                                <!-- Section 3 -->
                                <div>
                                    <div class="col-md-12">
                                        <h5 v-text="this.txt.titles.translations"></h5>
                                    </div>

                                    <show-branch-translations :branchTranslationsList="acriss.branchTranslations" />
                                </div>
                                <!--  -->
                            </div>

                            <div class="kt-portlet__foot">
                                <div class="text-right">
                                    <div class="kt-align-right">
                                        <!-- Rounded switch -->
                                        <label class="switch mr-4">
                                            <input
                                                @change="setStatus($event)"
                                                id="acrissStatus"
                                                type="checkbox"
                                                v-model="status"
                                                :disabled="disableSlider"
                                            />
                                            <span class="slider round"></span>
                                        </label>
                                        <!--  -->

                                        <button
                                            @click="editPage"
                                            id="btn-edit"
                                            class="btn btn-dark kt-label-bg-color-4 mr-4"
                                            v-text="this.txt.form.edit"
                                        />
                                    </div>
                                </div>
                            </div>
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
import ShowBranchTranslations from "./components/ShowBranchTranslations";

export default {
    name: "AcrissShowPage",
    components: {
        ShowBranchTranslations,
    },
    props: {
        acriss: {},
    },
    data() {
        return {
            txt: {},
            disableSlider: false,
            status: null,
        };
    },
    created() {
        this.txt = txtTrans;
        this.status = this.acriss.status;
    },
    methods: {
        showNotification(type = "", text = "") {
            this.$notify({
                text,
                type,
            });
        },
        formatField(value) {
            return value !== null
                ? typeof value === "object" && Object.keys(value).length
                    ? value.name === null || value.name == ""
                        ? "-"
                        : value.name
                    : value
                : "-";
        },
        formatDate(date) {
            return date !== null && date !== undefined ? moment(date, "DD/MM/YYYY").format("DD/MM/YYYY") : "-";
        },
        editPage() {
            window.location.href = this.routing.generate("acriss.edit", { id: this.acriss.id });
        },
        async setStatus(e) {
            Loading.starLoading();
            this.disableSlider = true;

            let url = this.routing.generate("acriss.update.status", {
                acrissId: this.acriss.id,
                status: this.status,
            });
            Axios.post(url)
                .then((response) => {
                    this.disableSlider = false;
                    Loading.endLoading();

                    if (response.onBooking) {
                        this.showNotification("error", this.txt.form.onBookingAcrissStatusNotification);
                        this.status = !this.status;
                    } else {
                        if (response.updated) {
                            this.showNotification("success", this.txt.form.acrissStatusUpdatedSuccessNotification);
                        } else {
                            this.showNotification("error", this.txt.form.errorUpdatingAcrissStatusNotification);
                            this.status = !this.status;
                        }
                    }
                })
                .catch((e) => {
                    this.disableSlider = false;
                    Loading.endLoading();
                    this.status = !this.status;
                    console.log(e);
                    this.showNotification("error", this.txt.form.errorUpdatingAcrissStatusNotification);
                });
        },
    },
};
</script>

<style scoped>
/* The switch - the box around the slider */
.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
}

/* Hide default HTML checkbox */
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

/* The slider */
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: orangered;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}

input:checked + .slider {
    background-color: #0abb87;
}

input:focus + .slider {
    box-shadow: 0 0 1px #2196f3;
}

input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 24px;
}

.slider.round:before {
    border-radius: 80%;
}
</style>
