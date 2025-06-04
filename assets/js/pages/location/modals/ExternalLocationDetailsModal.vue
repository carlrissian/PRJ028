<template>
    <erp-modal
        id="external-location-details-modal"
        :title="`${txt.titles.locationDetails} ${Formatter.formatField(location.id)}`"
    >
        <template #body>
            <div class="row">
                <div class="col-3">
                    <h6 v-text="txt.fields.locationCode"></h6>
                    <p v-text="Formatter.formatField(location.id)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.providerCode"></h6>
                    <p v-text="Formatter.formatField(location.providerCode)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.locationName"></h6>
                    <p v-text="Formatter.formatField(location.name)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.officeManager"></h6>
                    <p v-text="Formatter.formatField(location.officeManager)"></p>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <h6 v-text="txt.fields.address"></h6>
                    <p v-text="Formatter.formatField(location.address)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.phone"></h6>
                    <p v-text="Formatter.formatField(location.phone)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.email"></h6>
                    <p v-text="Formatter.formatField(location.email)"></p>
                </div>
            </div>

            <div class="row">
                <div class="col-3">
                    <h6 v-text="txt.fields.postalCode"></h6>
                    <p v-text="Formatter.formatField(location.postalCode)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.city"></h6>
                    <p v-text="Formatter.formatField(location.city)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.state"></h6>
                    <p v-text="Formatter.formatField(location.state)"></p>
                </div>
                <div class="col-3">
                    <h6 v-text="txt.fields.country"></h6>
                    <p v-text="Formatter.formatField(location.country)"></p>
                </div>
            </div>
        </template>
    </erp-modal>
</template>

<script>
import Formatter from "../../../../SharedAssets/js/formatter";
import ErpModal from "../../../../SharedAssets/vue/components/modal/ErpModal";

export default {
    name: "ExternalLocationDetailsModal",
    components: {
        ErpModal,
    },
    props: {
        locationData: {
            type: Object,
            default: null,
        },
    },
    watch: {
        locationData: function(data) {
            this.location.id = data?.id;
            this.location.name = data?.name;
            this.location.providerCode = data?.provider.code;
            this.location.officeManager = data?.officeManager;
            this.location.address = data?.address;
            this.location.postalCode = data?.postalCode;
            this.location.city = data?.city;
            this.location.state = data?.state;
            this.location.country = data?.country;
            this.location.phone = data?.phone;
            this.location.email = data?.email;
        },
    },
    data() {
        return {
            Formatter,
            txt: {},
            location: {
                id: null,
                name: null,
                providerCode: null,
                officeManager: null,
                address: null,
                postalCode: null,
                city: null,
                state: null,
                country: null,
                phone: null,
                email: null,
            },
        };
    },
    created() {
        this.txt = txtTrans;
    },
};
</script>

<style scoped></style>
