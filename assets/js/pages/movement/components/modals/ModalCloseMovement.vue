<template>
    <erp-modal id="modal-close-movement" :title="txt.titles.closeMovement" use-form :submit-prevent="closeMovement">
        <template slot="body">
            <div class="row">
                <input-number
                    @updatedInputNumber="movementData.actualKms = $event"
                    name="actualKms"
                    id="actualKms"
                    divClass="form-group col-md-4"
                    :min="0"
                    :label="txt.fields.kilometers"
                    :value="movementData.actualKms"
                    required
                />
                <input-number
                    v-if="isFuel"
                    @updatedInputNumber="movementData.tankActualOctaves = $event"
                    name="tankActualOctaves"
                    id="tankActualOctaves"
                    divClass="form-group col-md-4"
                    :min="0"
                    :max="8"
                    :label="txt.fields.tankActualOctaves"
                    placeholder="0 - 8"
                    :value="movementData.tankActualOctaves"
                    required
                />
                <input-number
                    v-if="isBattery"
                    @updatedInputNumber="movementData.batteryActual = $event"
                    name="batteryActual"
                    id="batteryActual"
                    divClass="form-group col-md-4"
                    :min="0"
                    :max="100"
                    :step="0.1"
                    :numOfDecimals="1"
                    :label="txt.fields.batteryActual"
                    :value="movementData.batteryActual"
                    required
                />

                <input-base
                    name="movementStatus"
                    id="movementStatus"
                    divClass="form-group col-md-4"
                    :label="txt.fields.movementStatus"
                    :value="movementData.status"
                    readonly
                />
            </div>

            <div class="row">
                <input-base
                    name="destinationLocation"
                    id="destinationLocation"
                    divClass="form-group col-md-4"
                    :label="txt.fields.destinationLocation"
                    :value="movementData.destinationLocation"
                    readonly
                />

                <input-number
                    @updatedInputNumber="movementData.manualCost = $event"
                    v-if="
                        movementData &&
                            movementData.movementCategoryId === constants.category.notOrdinary &&
                            !['', null, undefined].includes(movementData.supplierName)
                    "
                    name="manualCost"
                    id="manualCost"
                    divClass="form-group col-md-4"
                    :min="0"
                    :step="0.01"
                    :numOfDecimals="2"
                    :label="txt.fields.amount"
                    :value="movementData.manualCost"
                    required
                />

                <date-picker
                    @updatedDatePicker="movementData.actualUnloadDate = $event"
                    name="actualUnloadDate"
                    id="actualUnloadDate"
                    divClass="form-group col-md-4"
                    :label="txt.fields.actualUnloadDate"
                    :value="movementData.actualUnloadDate"
                    :limit-start-day="movementData.actualLoadDate"
                    :limit-end-day="new Date()"
                    required
                />

                <text-area
                    @updatedTextArea="movementData.closingNotes = $event"
                    name="closingNotes"
                    id="closingNotes"
                    divClass="form-group col-md-12"
                    :cols="30"
                    :rows="6"
                    :label="txt.fields.closingNotes"
                    :value="movementData.closingNotes"
                />
            </div>
        </template>

        <template slot="footer">
            <div class="kt-align-right">
                <button type="submit" class="btn btn-dark kt-label-bg-color-4" v-text="txt.form.closeMovement"></button>
            </div>
        </template>
    </erp-modal>
</template>

<script>
import Loading from "../../../../../assets/js/utilities";
import Formatter from "../../../../../SharedAssets/js/formatter";
import ErpModal from "../../../../../SharedAssets/vue/components/modal/ErpModal";
import DatePicker from "../../../../../SharedAssets/vue/components/base/inputs/DatePicker";
import InputBase from "../../../../../SharedAssets/vue/components/base/inputs/InputBase";
import InputNumber from "../../../../../SharedAssets/vue/components/base/inputs/InputNumber";
import TextArea from "../../../../../SharedAssets/vue/components/base/inputs/TextArea";

export default {
    name: "ModalCloseMovement",
    components: {
        ErpModal,
        DatePicker,
        InputBase,
        InputNumber,
        TextArea,
    },
    props: {
        movementTypeName: String,
        movement: Object,
    },
    data() {
        return {
            constants,
            txt: {},
            movementData: {
                id: null,
                tankCapacity: null,
                batteryCapacity: null,
                actualKms: null,
                tankActualOctaves: null,
                batteryActual: null,
                status: null,
                destinationLocation: null,
                manualCost: null,
                actualLoadDate: null,
                actualUnloadDate: null,
                closingNotes: null,
            },
        };
    },
    created() {
        this.txt = txtTrans;
    },
    computed: {
        isFuel() {
            return (
                [
                    constants.motorizationType.unespecifiedPowerAir,
                    constants.motorizationType.unespecifiedPowerNoAir,
                    constants.motorizationType.dieselAir,
                    constants.motorizationType.dieselNoAir,
                    constants.motorizationType.hybrid,
                    constants.motorizationType.hybridPlugin,
                    constants.motorizationType.lpgAir,
                    constants.motorizationType.lpgNoAir,
                    constants.motorizationType.hydrogenAir,
                    constants.motorizationType.hydrogenNoAir,
                    constants.motorizationType.multiFuelAir,
                    constants.motorizationType.multiFuelNoAir,
                    constants.motorizationType.petrolAir,
                    constants.motorizationType.petrolNoAir,
                    constants.motorizationType.ethanolAir,
                    constants.motorizationType.ethanolNoAir,
                ].includes(this.movementData?.vehicle?.motorizationType?.id) || this.movementData?.tankCapacity !== null
            );
        },
        isBattery() {
            return (
                [
                    constants.motorizationType.unespecifiedPowerAir,
                    constants.motorizationType.unespecifiedPowerNoAir,
                    constants.motorizationType.hybrid,
                    constants.motorizationType.hybridPlugin,
                    constants.motorizationType.electricE,
                    constants.motorizationType.electricC,
                    constants.motorizationType.multiFuelAir,
                    constants.motorizationType.multiFuelNoAir,
                ].includes(this.movementData?.vehicle?.motorizationType?.id) || this.movementData?.batteryCapacity !== null
            );
        },
    },
    methods: {
        formatterDestinationLocation(data) {
            const location = data?.destinationLocation || data?.externalDestinationLocation;

            if (location) {
                return Formatter.formatField(location);
            }

            if (data?.manualDestinationLocation) {
                return Formatter.concatFields(data?.manualDestinationLocation.country, data?.manualDestinationLocation.state);
            }
        },
        closeMovement: async function() {
            Loading.starLoading();

            let url = this.routing.generate("movement.close");

            let formData = new FormData();
            // formData.set("movement", JSON.stringify(this.movement));
            formData.set("id", this.movementData.id);
            formData.set("actualKms", this.movementData.actualKms);
            formData.set("tankActualOctaves", this.movementData.tankActualOctaves);
            formData.set("batteryActual", this.movementData.batteryActual);
            formData.set("manualCost", this.movementData.manualCost);
            formData.set("actualUnloadDate", Formatter.convertDateToDateTime(this.movementData.actualUnloadDate));
            formData.set("closingNotes", this.movementData.closingNotes);

            this.axios
                .post(url, formData)
                .then((response) => {
                    // console.log("Close Movement: ", response);
                    Loading.endLoading();

                    if (response.data.closed) {
                        this.$notify({
                            type: "success",
                            text: this.txt.form.movementClosedSuccessNotification,
                        });
                        $("#modal-close-movement").modal("hide");

                        setTimeout(() => {
                            window.location.href = this.routing.generate("movement.list", {
                                movementType: this.movementTypeName,
                            });
                        }, 2000);
                    } else {
                        this.$notify({
                            type: "error",
                            text: this.txt.form.errorClosingMovementNotification,
                        });
                    }
                })
                .catch((error) => {
                    console.error(error.response);
                    Loading.endLoading();
                    this.$notify({
                        type: "error",
                        text: `${this.txt.form.errorClosingMovementNotification}.<br>${error.response.data.message}`,
                    });
                });
        },
    },
    watch: {
        movement: function(data) {
            this.movementData.id = data?.id;
            this.movementData.tankCapacity = data?.vehicle.tankCapacity;
            this.movementData.batteryCapacity = data?.vehicle.batteryCapacity;
            this.movementData.actualKms = null;
            this.movementData.tankActualOctaves = null;
            this.movementData.batteryActual = null;
            this.movementData.status = data?.movementStatus.name;
            this.movementData.manualCost = data?.manualCost;
            this.movementData.actualLoadDate = data?.actualLoadDate;
            this.movementData.actualUnloadDate = null;
            this.movementData.closingNotes = null;

            this.movementData.destinationLocation = this.formatterDestinationLocation(data);
        },
    },
};
</script>

<style scoped></style>
