<template>
    <erp-modal :title="title" modal-id="vehicle-history-modal">
        <template slot="body">
            <div class="row">
                <div v-for="info in dataInfo" class="col-md-3">
                    <div class="col-md-12">
                        <label v-text="info.title"></label>
                    </div>
                    <div class="col-md-12">
                        <p v-text="info.value"></p>
                    </div>
                </div>
                <div class="border-bottom col-md-12 mt-5 mb-5" />

                <hr />

                <div v-for="salesLine in dataInfoSalesLines" class="col-md-12">
                    <div class="col-md-12">
                        <label>{{ salesLine.title }}</label>
                    </div>
                    <div class="col-md-12">
                        <p>{{ salesLine.value }}</p>
                    </div>
                </div>
            </div>
        </template>
        <template slot="footer"> </template>
    </erp-modal>
</template>

<script>
import Axios from "axios";
import Loading from "../../../../../assets/js/utilities";
import ErpModal from "../../../../components/modal/ErpModal";

export default {
    name: "VehicleHistoryModal",
    components: { ErpModal },
    props: {
        row: {},
        licensePlate: String,
    },
    watch: {
        row() {
            this.checkStatus(this.row);
        },
    },
    data() {
        return {
            txt: {},
            constants: {},
            title: "",
            dataInfo: [],
            dataInfoSalesLines: [],
        };
    },
    mounted() {
        this.txt = txtTrans;
        this.constants = constants.vehicleStatus;
        this.checkStatus(this.row);
    },
    methods: {
        async checkStatus(row) {
            let resp = {};
            let data = {};
            Loading.starLoading();

            this.dataInfo = [];
            this.dataInfoSalesLines = [];
            this.title = "";

            this.urlToGetData = this.routing.generate(
                "vehicle.history.details",
                {
                    vehicleId: row.vehicleId,
                    documentTypeId: row.statusChangeDocType.documentTypeId,
                    vehicleLicensePlate: this.licensePlate,
                    documentId: row.statusChangeDocType.id,
                    actualLoadDate: row.statusChangeDate,
                }
            );

            resp = await Axios.get(this.urlToGetData);
            data = resp.data.statusChangeDocType.documentData;
            Loading.endLoading();
            this.title = row.status.name;

            switch (row.status.id) {
                case this.constants.ON_RENT:
                    this.dataInfo.push({
                        title: this.txt.fields.contractId,
                        value: data.contractId,
                    });
                    this.dataInfo.push({
                        title: this.txt.fields.contractSignatureDate,
                        value: data.contractSignatureDate,
                    });
                    this.dataInfo.push({
                        title: this.txt.fields.dropOffDate,
                        value: data.dropOffDate,
                    });
                    this.dataInfo.push({
                        title: this.txt.fields.bookedAcriss,
                        value: data.bookedAcriss.name,
                    });
                    this.dataInfo.push({
                        title: this.txt.fields.bookedGroup,
                        value: data.bookedCarGroup.name,
                    });
                    this.dataInfo.push({
                        title: this.txt.fields.acrissHired,
                        value: data.acrissHired.name,
                    });
                    this.dataInfo.push({
                        title: this.txt.fields.groupHired,
                        value: data.groupHired.name,
                    });
                    this.dataInfo.push({
                        title: this.txt.fields.pickUpBranch,
                        value: data.pickUpBranch.name,
                    });
                    this.dataInfo.push({
                        title: this.txt.fields.dropOffBranch,
                        value: data.dropOffBranch.name,
                    });
                    this.dataInfo.push({
                        title: this.txt.fields.startKilometers,
                        value: data.startKilometers,
                    });
                    this.dataInfo.push({
                        title: this.txt.fields.kmsPolicy,
                        value: data.kmsPolicyName,
                    });
                    this.dataInfo.push({
                        title: this.txt.fields.kmsPolicyLimit,
                        value: data.kmsPolicyLimit,
                    });

                    for (let i = 0; i < data.salesLines.length; i++) {
                        this.dataInfoSalesLines.push({
                            title: i + 1,
                            value: data.salesLines[i].description,
                        });
                    }

                    break;

                case this.constants.ON_TRANSPORT:
                case this.constants.ON_TRANSPORT_SALE:
                case this.constants.SOLD_ON_TRANSPORT:
                case this.constants.ON_TRANSPORT_WORKSHOP:
                    this.dataInfo.push({
                        title: this.txt.fields.movementId,
                        value: data.movementId,
                    });
                    this.dataInfo.push({
                        title: this.txt.fields.expectedUnLoadDate,
                        value: data.expectedUnLoadDate,
                    });
                    this.dataInfo.push({
                        title: this.txt.fields.originIATACodeLocation,
                        value:
                            data.pickUpBranch.branchIATA +
                            "-" +
                            data.originLocation.name,
                    });
                    this.dataInfo.push({
                        title: this.txt.fields.destinationIATACodeLocation,
                        value:
                            data.dropOffBranch.branchIATA +
                            "-" +
                            data.destinationLocation.name,
                    });

                    break;

                case this.constants.PENDING_REPAIR:
                case this.constants.MAINTENANCE_WORKSHOP:
                case this.constants.SOLD_REPAIR:
                    this.dataInfo.push({
                        title: this.txt.fields.vehicleMaintenaceExpectedEndDate,
                        value: data.vehicleMaintenaceEndDate,
                    });

                    break;

                case this.constants.SALE:
                    // this.dataInfo.push({title: this.txt.fields.saleBlockDate, value: data.saleBlockDate});
                    // this.dataInfo.push({title: this.txt.fields.saleDate, value: data.saleDate});
                    this.dataInfo.push({ title: "Pendiente", value: "" });

                    break;

                case this.constants.CRANE:
                case this.constants.WORKSHOP_SALE:
                case this.constants.PENDING_WS_SALE:
                case this.constants.SOLD:
                    this.dataInfo.push({ title: "Sin implementar", value: "" });
                    break;
            }
        },
    },
};
</script>

<style>
.modal-footer {
    border-top: none !important;
}
</style>
