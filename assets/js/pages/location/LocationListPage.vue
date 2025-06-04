<template>
    <div class="kt-portlet kt-portlet--bordered">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title" v-text="txt.titles.locations"></h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-left nav-tabs-line-primary" role="tablist">
                    <li class="nav-item">
                        <a
                            class="nav-link active"
                            data-toggle="tab"
                            href="#internalLocation"
                            role="tab"
                            aria-selected="false"
                            v-text="txt.titles.internalLocations"
                        >
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            data-toggle="tab"
                            href="#externalLocation"
                            role="tab"
                            aria-selected="false"
                            v-text="txt.titles.externalLocations"
                        >
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="internalLocation" role="tabpanel">
                    <internal-location-list />
                </div>
                <div class="tab-pane" id="externalLocation" role="tabpanel">
                    <external-location-list />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import InternalLocationList from "./tabs/InternalLocationList";
import ExternalLocationList from "./tabs/ExternalLocationList";

export default {
    name: "LocationListPage",
    components: {
        InternalLocationList,
        ExternalLocationList,
    },
    data() {
        return {
            txt: {},
        };
    },
    created() {
        this.txt = txtTrans;
    },
};
</script>

<style scoped></style>
