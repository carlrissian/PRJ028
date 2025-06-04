<template>
    <fragment>
        <erp-modal
            @onOpenModal="movementId = movement.id"
            @onCloseModal="clear()"
            :title="txt.titles.validateMovement"
            id="modal-validation-movement"
            size="xl"
        >
            <template #body>
                <p v-if="needToAssignVehicles" v-text="txt.form.errorAssignedVehicles"></p>
                <div v-else-if="needToUpdate">
                    <p v-text="txt.form.errorMovementFields"></p>
                    <ul class="list">
                        <li v-for="field in fieldsToUpdate" v-text="field"></li>
                    </ul>
                </div>

                <div v-else class="kt-portlet__body body_tab">
                    <div class="kt-portlet__head-toolbar">
                        <ul
                            class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-left nav-tabs-line-primary"
                            role="tablist"
                        >
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    :class="{ active: !isInProgress }"
                                    href="#load"
                                    role="tab"
                                    data-toggle="tab"
                                    aria-selected="false"
                                    v-text="txt.titles.loadValidation"
                                >
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    :class="{ active: isInProgress }"
                                    href="#unload"
                                    role="tab"
                                    data-toggle="tab"
                                    aria-selected="false"
                                    v-text="txt.titles.unloadValidation"
                                >
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane" :class="{ active: !isInProgress }" id="load" role="tabpanel">
                            <table-load ref="tableLoad" @validate="validate" :movement-id="movementId" />
                        </div>

                        <div class="tab-pane" :class="{ active: isInProgress }" id="unload" role="tabpanel">
                            <table-unload ref="tableUnload" @validate="validate" :movement-id="movementId" />
                        </div>
                    </div>
                </div>
            </template>

            <template #footer>
                <div class="kt-portlet__foot">
                    <div class="text-right">
                        <div class="kt-align-right">
                            <button
                                @click="editButton"
                                v-if="needToUpdate"
                                type="button"
                                id="btn-edit"
                                class="btn btn-dark kt-label-bg-color-4"
                                v-text="txt.form.editMovement"
                            ></button>

                            <button
                                @click="assignVehiclesButton"
                                v-if="needToAssignVehicles"
                                type="button"
                                id="btn-edit-car"
                                class="btn btn-dark kt-label-bg-color-4"
                                v-text="txt.form.assignVehicles"
                            ></button>
                        </div>
                    </div>
                </div>
            </template>
        </erp-modal>
    </fragment>
</template>

<script>
import Loading from "../../../../../assets/js/utilities";
import formatter from "../../../../../SharedAssets/js/formatter";
import ErpModal from "../../../../../SharedAssets/vue/components/modal/ErpModal.vue";
import TableLoad from "./tableTabs/TableLoad.vue";
import TableUnload from "./tableTabs/TableUnload.vue";

export default {
    name: "ModalValidationMovement",
    components: {
        ErpModal,
        TableLoad,
        TableUnload,
    },
    props: {
        movement: Object,
    },
    data() {
        return {
            txt: {},
            movementId: null,
            fieldsToUpdate: [],
            needToUpdate: false,
        };
    },
    created() {
        this.txt = txtTrans;
    },
    watch: {
        movement() {
            this.movementId = this.movement.id;
            this.needToUpdateMovement();
        },
    },
    computed: {
        needToAssignVehicles() {
            return Array.isArray(this.movement.vehicle) && this.movement.vehicle.length == 0;
        },
        isInProgress() {
            return this.movement.movementStatusId === constants.movementStatus.progress;
        },
    },
    methods: {
        showNotification(type = "", text = "") {
            this.$notify({
                text,
                type,
            });
        },
        editButton() {
            location.href = this.routing.generate("movement.edit", { id: this.movement.id });
        },
        assignVehiclesButton() {
            window.open(this.routing.generate("movement.vehicleLine.assigned.list", { id: this.movement.id }), "_blank");
        },
        clear() {
            this.movementId = null;
            this.fieldsToUpdate = [];
            this.needToUpdate = false;
            this.$refs?.tableLoad.clear();
            this.$refs?.tableUnload.clear();

            $("#modal-validation-movement").modal("hide");
        },
        needToUpdateMovement() {
            // TODO hay que corregir los nombres de los campos aquí una vez se corrija en FilterMovementQueryHandler
            const requiredFields = [
                {
                    name: "originLocation",
                    manual: "manualOriginLocation",
                    external: "externalOriginLocation",
                    translation: `${this.txt.fields.originLocation} / ${this.txt.fields.manualOriginLocation} / ${this.txt.fields.externalOriginLocation}`,
                },
                {
                    name: "destinationLocation",
                    manual: "manualDestinationLocation",
                    external: "externalDestinationLocation",
                    translation: `${this.txt.fields.destinationLocation} / ${this.txt.fields.manualDestinationLocation} / ${this.txt.fields.externalDestinationLocation}`,
                },
                {
                    name: "businessUnitName",
                    translation: this.txt.fields.businessUnit,
                },
                {
                    name: "movementStatusId",
                    translation: this.txt.fields.movementStatus,
                },
            ];

            if (this.movement.movementTypeId == constants.movementType.carrier) {
                requiredFields.push(
                    {
                        name: "supplierName",
                        translation: this.txt.fields.provider,
                    },
                    {
                        name: "transportMethodId",
                        translation: this.txt.fields.transportMethod,
                    },
                    {
                        name: "automaticCost",
                        translation: this.txt.fields.automaticCost,
                    }
                );
            }

            requiredFields.forEach((field) => {
                if (
                    !this.movement[field.name] &&
                    (!field.manual || !this.movement[field.manual]) &&
                    (!field.external || !this.movement[field.external])
                ) {
                    this.needToUpdate = true;
                    this.fieldsToUpdate.push(field.translation);
                }
            });
        },
        async validate(actualLoadDate, actualUnloadDate, vehicleLinesId, action) {
            Loading.starLoading();

            let url = this.routing.generate("movement.validate");
            let formData = new FormData();

            vehicleLinesId.forEach((id) => {
                formData.append("vehicleLinesId[]", id);
            });
            formData.set("movementId", this.movement.id);
            formData.set("actualLoadDate", actualLoadDate ? formatter.convertDateToDateTime(actualLoadDate) : null);
            formData.set("actualUnloadDate", actualUnloadDate ? formatter.convertDateToDateTime(actualUnloadDate) : null);
            formData.set("action", action);

            this.axios
                .post(url, formData)
                .then((response) => {
                    Loading.endLoading();
                    if (response.data.validated) {
                        this.showNotification("success", this.txt.form.movementValidatedSuccessNotification);

                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        this.showNotification("error", response.data.message);
                    }
                })
                .catch((error) => {
                    console.log(error.response);
                    Loading.endLoading();
                    this.showNotification("error", this.txt.form.errorValidatingMovementNotification);
                });
        },
    },
};
</script>

<style scoped>
.body_tab {
    padding-top: 0 !important;
}
</style>
