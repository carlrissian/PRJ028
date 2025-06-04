<template>
    <fragment>
        <!-- Tabs row -->
        <div class="kt-portlet__head-toolbar">
            <div class="row">
                <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-left nav-tabs-line-primary" role="tablist">
                    <li class="nav-item">
                        <a
                            class="nav-link active"
                            data-toggle="tab"
                            href="#outside-tab"
                            role="tab"
                            aria-selected="false"
                            v-text="txt.fields.outside"
                        >
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            data-toggle="tab"
                            href="#inside-tab"
                            role="tab"
                            aria-selected="false"
                            v-text="txt.fields.inside"
                        >
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!--  -->

        <div class="tab-content">
            <!-- Exterior -->
            <div class="tab-pane active" id="outside-tab" role="tabpanel">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div style="position: relative">
                            <img width="100%" :src="damageImages.exterior.img" />
                            <iframe v-if="loadDamageWeb" class="damageSvg" id="zoneExterior" :src="damageImages.exterior.zone" />
                            <iframe
                                v-if="loadDamageWeb"
                                class="damageSvg"
                                id="subzoneExterior"
                                :src="damageImages.exterior.subZone"
                            />
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th v-text="txt.fields.code"></th>
                                    <th v-text="txt.fields.zone"></th>
                                    <th v-text="txt.fields.subzone"></th>
                                    <th v-text="txt.fields.associatedRA"></th>
                                    <th v-text="txt.fields.reapired"></th>
                                    <th v-text="txt.fields.reparationDate"></th>
                                    <th v-text="txt.fields.repairOrder"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    :id="'damageRow_' + damage.id"
                                    class="damageRow"
                                    v-for="damage in damagesExterior"
                                    :key="damage.id"
                                >
                                    <td v-text="Formatter.formatField(damage.id)"></td>
                                    <td v-text="Formatter.formatField(damage.zone)"></td>
                                    <td v-text="Formatter.formatField(damage.subZone)"></td>
                                    <td v-text="Formatter.formatField(damage.raHeadId)"></td>
                                    <td v-text="txt.form[Formatter.formatBoolean(damage.repaired)]"></td>
                                    <td v-text="Formatter.formatDate(damage.reparationDate)"></td>
                                    <td v-text="Formatter.formatField(damage.repairOrderId)"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--  -->

            <!-- Interior -->
            <div class="tab-pane" id="inside-tab" role="tabpanel">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div style="position: relative">
                            <img width="100%" height="100%" :src="damageImages.interior.img" />
                            <iframe v-if="loadDamageWeb" class="damageSvg" id="zoneInterior" :src="damageImages.interior.zone" />
                            <iframe
                                v-if="loadDamageWeb"
                                class="damageSvg"
                                id="subzoneInterior"
                                :src="damageImages.interior.subZone"
                            />
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th v-text="txt.fields.code"></th>
                                    <th v-text="txt.fields.zone"></th>
                                    <th v-text="txt.fields.subzone"></th>
                                    <th v-text="txt.fields.associatedRA"></th>
                                    <th v-text="txt.fields.reapired"></th>
                                    <th v-text="txt.fields.reparationDate"></th>
                                    <th v-text="txt.fields.repairOrder"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    :id="'damageRow_' + damage.id"
                                    class="damageRow"
                                    v-for="damage in damagesInterior"
                                    :key="damage.id"
                                >
                                    <td v-text="Formatter.formatField(damage.id)"></td>
                                    <td v-text="Formatter.formatField(damage.zone)"></td>
                                    <td v-text="Formatter.formatField(damage.subZone)"></td>
                                    <td v-text="Formatter.formatField(damage.raHeadId)"></td>
                                    <td v-text="txt.form[Formatter.formatBoolean(damage.repaired)]"></td>
                                    <td v-text="Formatter.formatDate(damage.reparationDate)"></td>
                                    <td v-text="Formatter.formatField(damage.repairOrderId)"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--  -->
        </div>
    </fragment>
</template>

<script>
import Loading from "../../../../../../assets/assets/js/utilities";
import Formatter from "../../../../../SharedAssets/js/formatter";

export default {
    name: "VehicleDamagesTab",
    components: {},
    props: {
        vehicleId: {
            type: Number,
            required: true,
        },
        vehicleTypeId: {
            type: String,
            required: true,
        },
        numberOfSeats: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            Formatter,
            txt: {},

            loadDamageWeb: false,
            damagesExterior: {},
            damagesInterior: {},

            damageImages: {
                exterior: {
                    img: "",
                    zone: "",
                    subZone: "",
                },
                interior: {
                    img: "",
                    zone: "",
                    subZone: "",
                },
            },
            vehicleDamages: [],
        };
    },
    created() {
        this.txt = txtTrans;
    },
    mounted() {
        this.getDamages();
        this.setDamageImages(this.vehicleTypeId, this.numberOfSeats);
        this.loadDamages();
    },
    methods: {
        getDamages: async function() {
            Loading.starLoading();
            await this.axios
                .get(this.routing.generate("damage.filter", { vehicleId: this.vehicleId }))
                .then((response) => {
                    Loading.endLoading();
                    if (response.status) {
                        this.vehicleDamages = response.data;
                    }
                })
                .catch((error) => {
                    Loading.endLoading();
                    console.log(error.response);
                    this.$notify({
                        type: "error",
                        text: error.response.data.message,
                    });
                });
        },
        loadDamages() {
            setTimeout(() => {
                if (
                    $("#subzoneExterior")
                        .contents()
                        .find("*") != "undefined"
                ) {
                    this.manageSvgDamages("subzoneExterior", this.damagesExterior);
                }
                if (
                    $("#subzoneInterior")
                        .contents()
                        .find("*") != "undefined"
                ) {
                    this.manageSvgDamages("subzoneInterior", this.damagesInterior);
                }
            }, 200);
        },
        setDamageImages(vehicleTypeId, numberOfSeats) {
            let vehicleTypeKey = Object.keys(constants.vehicleType).find(
                (clave) => constants.vehicleType[clave] === vehicleTypeId
            );

            let vehicleType = {
                [constants.vehicleType.CAR || constants.vehicleType.VAN]: () =>
                    this.setImagesTypeCarOrVAN(numberOfSeats, vehicleTypeKey),
                [constants.vehicleType.MOTO]: () => this.setImagesTypeMoto(),
            };
            vehicleType[vehicleTypeId]();

            this.loadDamageWeb = true;
        },
        setImagesTypeMoto() {
            this.damageImages.exterior.img = constants.damageMediaUrl.MOTO.IMG_MOTO_EXTERIOR_2_WHEELS;
            this.damageImages.exterior.zone = constants.damageMediaUrl.CAR.SVG_CAR_EXTERIOR_ZONE;
            this.damageImages.exterior.subZone = constants.damageMediaUrl.CAR.SVG_CAR_EXTERIOR_SUBZONE;
        },
        setImagesTypeCarOrVAN(numberOfSeats, vehicleTypeKey) {
            //IMG
            this.damageImages.exterior.img = constants.damageMediaUrl[vehicleTypeKey][`IMG_${vehicleTypeKey}_EXTERIOR`];
            this.damageImages.interior.img =
                constants.damageMediaUrl[vehicleTypeKey][`IMG_${vehicleTypeKey}_INTERIOR_${numberOfSeats}_SEATS`] ??
                constants.damageMediaUrl[vehicleTypeKey][`IMG_${vehicleTypeKey}_INTERIOR_5_SEATS`];
            //SVG
            this.damageImages.exterior.zone = constants.damageMediaUrl.CAR.SVG_CAR_EXTERIOR_ZONE; //There is only SVG Zone for CAR
            this.damageImages.exterior.subZone = constants.damageMediaUrl.CAR.SVG_CAR_EXTERIOR_SUBZONE; //There is only SVG SubZone for CAR

            this.damageImages.interior.zone = constants.damageMediaUrl.CAR.SVG_CAR_INTERIOR_ZONE; //There is only SVG Zone for CAR
            this.damageImages.interior.subZone =
                constants.damageMediaUrl.CAR[`SVG_CAR_INTERIOR_${numberOfSeats}_SUBZONE`] ??
                constants.damageMediaUrl.CAR.SVG_CAR_EXTERIOR_SUBZONE;
        },
        manageSvgDamages(svgId, damageList) {
            var subzona = document.getElementById(svgId);

            Array.prototype.forEach.call(damageList, (damage) => {
                let zone = damage.zone;
                let subZone = damage.subZone;
                let subzoneIdName = "_" + zone + "." + subZone;
                let subzoneWithDamage = subzona.contentWindow.document.getElementById(subzoneIdName);

                if (subzoneWithDamage?.style !== null) {
                    subzoneWithDamage.style.fill = "rgba(255,0,0,0.5)";
                }

                this.$nextTick(() => {
                    if (subzoneWithDamage !== null) {
                        subzoneWithDamage.onclick = function(e) {
                            var damageRows = document.getElementsByClassName("damageRow");
                            Array.prototype.forEach.call(damageRows, (row) => {
                                row.style.backgroundColor = "transparent";
                            });

                            let filteredDamage = damageList.filter(
                                (damage) => damage.subZone === subZone && zone === damage.zone
                            );
                            Array.prototype.forEach.call(filteredDamage, (damageToPaint) => {
                                let damageRow = document.getElementById("damageRow_" + damageToPaint.id);
                                let color = damageToPaint.repaired ? "rgba(0,255,0,0.5)" : "rgba(255,0,0,0.5)";
                                damageRow.style.backgroundColor = color;
                            });
                        };
                    }
                });
            });
            // INFO bucle antiguo
            // for (let i = 0; i < damageList.length; i++) {
            //     let damage = damageList[i];

            //     let zone = damage.zone;
            //     let subZone = damage.subZone;

            //     let subzoneIdName = "_" + zone + "." + subZone;

            //     let subzoneWithDamage = subzona.contentWindow.document.getElementById(subzoneIdName);

            //     if (subzoneWithDamage !== null && subzoneWithDamage.style !== null) {
            //         subzoneWithDamage.style.fill = "rgba(255,0,0,0.5)";
            //     }

            //     this.$nextTick(() => {
            //         if (subzoneWithDamage !== null) {
            //             subzoneWithDamage.onclick = function(e) {
            //                 var damageRows = document.getElementsByClassName("damageRow");
            //                 Array.prototype.forEach.call(damageRows, function(row) {
            //                     row.style.backgroundColor = "transparent";
            //                 });

            //                 let filteredDamage = damageList.filter(
            //                     (damage) => damage.subZone === subZone && zone === damage.zone
            //                 );

            //                 for (let j = 0; j < filteredDamage.length; j++) {
            //                     let damageToPaint = filteredDamage[j];
            //                     let damageRow = document.getElementById("damageRow_" + damageToPaint.id);
            //                     let color = damageToPaint.repaired ? "rgba(0,255,0,0.5)" : "rgba(255,0,0,0.5)";
            //                     damageRow.style.backgroundColor = color;
            //                 }
            //             };
            //         }
            //     });
            // }
        },
    },
    watch: {
        vehicleDamages: {
            handler: function() {
                this.damagesExterior = this.vehicleDamages.filter((damage) => damage.typeZone.id === 3);
                this.damagesInterior = this.vehicleDamages.filter((damage) => damage.typeZone.id === 2);
                this.loadDamages();
            },
            deep: true,
        },
    },
};
</script>

<style scoped>
.damageSvg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    padding-inline: 10px;
}
</style>
