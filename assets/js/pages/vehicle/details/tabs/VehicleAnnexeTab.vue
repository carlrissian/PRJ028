<template>
    <erp-ajax-table
        :url="routing.generate('rentalAgreement.listByVehicle')"
        :columns="columns"
        :options="options"
        :parameter-default="{ vehicleId: vehicleId }"
    />
</template>

<script>
import Formatter from "../../../../../SharedAssets/js/formatter";
import ErpAjaxTable from "../../../../../SharedAssets/vue/components/table/ErpAjaxTable";

export default {
    name: "VehicleAnnexeTab",
    components: {
        ErpAjaxTable,
    },
    props: {
        vehicleId: Number,
    },
    data() {
        return {
            columns: [
                {
                    field: "bookingAnnexe.id",
                    title: txtTrans.fields.annexe,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "booking.bookingSearchCode",
                    title: txtTrans.fields.booking,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "booking.salesDocStatus",
                    title: txtTrans.fields.bookingStatus,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "bookingAnnexe.creationDate",
                    title: txtTrans.fields.creationDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "raSearchCode",
                    title: txtTrans.fields.associatedRentalAgreement,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "salesDocStatus",
                    title: txtTrans.fields.rentalAgreementStatus,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "pickUpDate",
                    title: txtTrans.fields.checkInDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "bookingAnnexe.salesDocStatus",
                    title: txtTrans.fields.status,
                    sortable: true,
                    formatter: (value) => Formatter.formatField(value),
                },
                {
                    field: "bookingAnnexe.realPickUpDate",
                    title: txtTrans.fields.pickUpDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                {
                    field: "bookingAnnexe.realDropOffDate",
                    title: txtTrans.fields.dropOffDate,
                    sortable: true,
                    formatter: (value) => Formatter.formatDate(value),
                },
                // {
                //     title: txtTrans.fields.actions,
                //     formatter: this.actionsFormatter,
                //     events: {
                //         "click .details": (e, value, row) =>
                //             this.openModal(row),
                //     },
                //     width: 160,
                // },
            ],
            options: {
                pagination: true,
                pageSize: 30,
                locale: "es-ES",
                scrollX: true,
            },
        };
    },
    methods: {
        // TODO por si se necesita un modal o llevar a pantalla de ver detalle
        actionsFormatter() {
            return `<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md details" data-toggle="modal" data-target="#" title="${txtTrans.form.viewDetails}"><i class="flaticon-eye"></i></button>`;
        },
    },
};
</script>

<style scoped></style>
