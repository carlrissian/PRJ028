<template>
    <erp-modal @onCloseModal="$emit('closed')" id="previewModal" :title="txt.titles.previewMovement">
        <template #body>
            <h5 class="mb-4" v-text="txt.titles.movementData"></h5>
            <div class="group row">
                <div class="col-2">
                    <h6 v-text="txt.fields.status"></h6>
                    <p
                        v-text="
                            Formatter.formatField(
                                $parent.selectList.movementStatusList.find((item) => item.id == movement.statusId)
                            )
                        "
                    ></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.originBranch"></h6>
                    <p
                        v-text="
                            Formatter.formatField(
                                $parent.selectList.branchList.find((item) => item.id == movement.originBranchId)
                            )
                        "
                    ></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.originLocation"></h6>
                    <p
                        v-text="
                            Formatter.formatField(
                                Formatter.formatField(
                                    $parent.selectList.locationList.find((item) => item.id == movement.originLocation.id)
                                )
                            )
                        "
                    ></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.destinationBranch"></h6>
                    <p
                        v-text="
                            Formatter.formatField(
                                $parent.selectList.branchList.find((item) => item.id == movement.destinationBranchId)
                            )
                        "
                    ></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.destinationLocation"></h6>
                    <p
                        v-text="
                            Formatter.formatField(
                                Formatter.formatField(
                                    $parent.selectList.locationList.find((item) => item.id == movement.destinationLocation.id)
                                )
                            )
                        "
                    ></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.expectedDepartureDate"></h6>
                    <p v-text="Formatter.formatDate(movement.expectedDepartureDate)"></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.expectedArrivalDate"></h6>
                    <p v-text="Formatter.formatDate(movement.expectedArrivalDate)"></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.businessUnit"></h6>
                    <p
                        v-text="
                            Formatter.formatField(
                                $parent.selectList.businessUnitList.find((item) => item.id == movement.businessUnitId)
                            )
                        "
                    ></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.businessUnitArticle"></h6>
                    <p
                        v-text="
                            Formatter.formatField(
                                $parent.selectList.businessUnitArticleList.find(
                                    (item) => item.id == movement.businessUnitArticleId
                                )
                            )
                        "
                    ></p>
                </div>
                <div class="col-2">
                    <h6 v-text="txt.fields.units"></h6>
                    <p v-text="Formatter.formatField(movement.vehicleUnits)"></p>
                </div>
                <!-- <div class="col-2">
                    <h6 v-text="txt.fields.provider"></h6>
                    <p
                        v-text="
                            Formatter.formatField($parent.selectList.supplierList.find((item) => item.id == movement.providerId))
                        "
                    ></p>
                </div> -->
                <div class="col-12">
                    <h6 v-text="txt.fields.notes"></h6>
                    <p v-html="Formatter.formatField(movement.notes).replace(/\n/g, '<br>')"></p>
                </div>
            </div>
        </template>

        <template #footer>
            <div class="kt-align-right">
                <button @click="confirm" type="button" class="btn btn-dark kt-label-bg-color-4">
                    <i :class="`la ${$parent.submitButtonClass}`"></i>
                    {{ $parent.submitButton }}
                </button>
            </div>
        </template>
    </erp-modal>
</template>

<script>
import Formatter from "../../../../../SharedAssets/js/formatter";
import ErpModal from "../../../../../SharedAssets/vue/components/modal/ErpModal";

export default {
    name: "MovementOperationPreviewModal",
    components: {
        ErpModal,
    },
    props: {
        movement: Object,
    },
    data() {
        return {
            Formatter,
            txt: {},
        };
    },
    created() {
        this.txt = txtTrans;
    },
    methods: {
        confirm() {
            $("#previewModal").modal("hide");
            this.$parent.submitMovement();
        },
    },
};
</script>

<style></style>
