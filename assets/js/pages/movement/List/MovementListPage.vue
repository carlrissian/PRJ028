<template>
    <fragment>
        <notifications position="top right" />

        <!-- DRIVER -->
        <div id="driver" v-if="movementTypeId === constants.movementType.driver">
            <list-movement-driver-filter :select-list="selectList" :movementTypeId="movementTypeId" />
            <list-movement-driver
                :select-list="selectList"
                :movementTypeId="movementTypeId"
                :movement-type-name="movementTypeName"
            />
        </div>
        <!--  -->

        <!-- CARRIER -->
        <div id="carrier" v-if="movementTypeId === constants.movementType.carrier">
            <list-movement-carrier-filter :select-list="selectList" :movementTypeId="movementTypeId" />
            <list-movement-carrier
                :select-list="selectList"
                :movementTypeId="movementTypeId"
                :movement-type-name="movementTypeName"
                :login-user="loginUser"
            />
        </div>
        <!--  -->

        <!-- OPERATION -->
        <div id="operation" v-if="movementTypeId === constants.movementType.operation">
            <list-movement-operation-filter :select-list="selectList" :movementTypeId="movementTypeId" />
            <list-movement-operation
                :select-list="selectList"
                :movementTypeId="movementTypeId"
                :movement-type-name="movementTypeName"
            />
        </div>
        <!--  -->
    </fragment>
</template>

<script>
import Loading from "../../../../assets/js/utilities";

import ListMovementDriver from "./Sections/Driver/ListMovementDriver";
import ListMovementCarrier from "./Sections/Carrier/ListMovementCarrier";
import ListMovementOperation from "./Sections/Operation/ListMovementOperation";
import ListMovementDriverFilter from "./Sections/Driver/ListMovementDriverFilter";
import ListMovementCarrierFilter from "./Sections/Carrier/ListMovementCarrierFilter";
import ListMovementOperationFilter from "./Sections/Operation/ListMovementOperationFilter";

export default {
    name: "MovementListPage",
    components: {
        ListMovementDriver,
        ListMovementCarrier,
        ListMovementOperation,
        ListMovementDriverFilter,
        ListMovementCarrierFilter,
        ListMovementOperationFilter,
    },
    props: {
        movementTypeId: Number,
        movementTypeName: String,
        loginUser: Object,
    },
    data() {
        return {
            constants,
            txt: {},
            selectList: {
                movementCategoryList: [],
                movementStatusList: [],
                supplierList: [],
                departmentList: [],
                businessUnitList: [],
                businessUnitArticleList: [],
                locationTypeList: [],
                locationList: [],
                branchList: [],
                countryList: [],
                vehicleTypeList: [],
                vehicleStatusList: [],
                brandList: [],
                modelList: [],
                carGroupList: [],
                saleMethodList: [],
                connectedVehicleList: [],
                extTransportList: [],
            },
        };
    },
    created() {
        this.txt = txtTrans;
    },
    mounted() {
        this.getSelectLists();
    },
    methods: {
        async getSelectLists() {
            Loading.starLoading();

            this.axios
                .all([
                    this.axios.get(this.routing.generate("movement.category.selectList")),
                    this.axios.get(this.routing.generate("movement.status.selectList")),
                    this.axios.get(this.routing.generate("supplier.selectList")),
                    this.axios.get(this.routing.generate("department.selectList")),
                    this.axios.get(this.routing.generate("businessUnit.selectList")),
                    this.axios.get(
                        this.routing.generate("businessUnitArticle.selectList", {
                            movementTypeId: this.movementTypeId,
                        })
                    ),
                    this.axios.get(this.routing.generate("location.type.selectList")),
                    this.axios.get(this.routing.generate("location.selectList")),
                    this.axios.get(this.routing.generate("branch.selectList")),
                    this.axios.get(this.routing.generate("country.selectList")),
                    this.axios.get(this.routing.generate("vehicle.type.selectList")),
                    this.axios.get(this.routing.generate("vehicle.status.selectList")),
                    this.axios.get(this.routing.generate("brand.selectList")),
                    this.axios.get(this.routing.generate("model.selectList")),
                    this.axios.get(this.routing.generate("cargroup.selectList")),
                    this.axios.get(this.routing.generate("saleMethod.selectList")),
                ])
                .then(
                    this.axios.spread(
                        (
                            movementCategory,
                            movementStatus,
                            supplier,
                            department,
                            businessUnit,
                            businessUnitArticle,
                            locationType,
                            location,
                            branch,
                            country,
                            vehicleType,
                            vehicleStatus,
                            brand,
                            model,
                            carGroup,
                            saleMethod
                        ) => {
                            this.selectList.movementCategoryList = movementCategory.data;
                            this.selectList.movementStatusList = movementStatus.data;
                            this.selectList.supplierList = supplier.data;
                            this.selectList.departmentList = department.data;
                            this.selectList.businessUnitList = businessUnit.data;
                            this.selectList.businessUnitArticleList = businessUnitArticle.data;
                            this.selectList.locationTypeList = locationType.data;
                            this.selectList.locationList = location.data;
                            this.selectList.branchList = branch.data;
                            this.selectList.countryList = country.data;
                            this.selectList.vehicleTypeList = vehicleType.data;
                            this.selectList.vehicleStatusList = vehicleStatus.data;
                            this.selectList.brandList = brand.data;
                            this.selectList.modelList = model.data;
                            this.selectList.carGroupList = carGroup.data;
                            this.selectList.saleMethodList = saleMethod.data;
                            this.selectList.connectedVehicleList = [
                                {
                                    id: 1,
                                    name: this.txt.form.yes,
                                },
                                {
                                    id: 2,
                                    name: this.txt.form.no,
                                },
                            ];
                            this.selectList.extTransportList = [
                                {
                                    id: true,
                                    name: this.txt.form.yes,
                                },
                                {
                                    id: false,
                                    name: this.txt.form.no,
                                },
                            ];

                            Loading.endLoading();
                        }
                    )
                )
                .catch((error) => {
                    console.error(error);
                    Loading.endLoading();
                });
        },
    },
};
</script>

<style scoped></style>
