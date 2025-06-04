<template>

    <div class="col-12 col-sm-11 card-booking-summary">
        <div class="included-counter-title border-bottom">
            <span>{{txt.summaryTitle1}}</span>
        </div>
        <div class="complements-wrapper">
            <div class="row border-bottom complements-header">
                <div class="col-sm-4 pl-5">{{txt.summaryLine1}}</div>
                <div class="col-sm-1 align-center">{{txt.summaryCol1}}</div>
                <div class="col-sm-2 align-center">
                            <span class="inline-left">{{txt.summaryCol2}}
                                <span class="block-left">{{txt.summaryCol2_2}} %</span>
                            </span>
                </div>
                <div class="col-sm-1 align-right">
                            <span class="inline-left">{{txt.summaryCol3}}
                                <span class="block-left">{{txt.summaryCol3_2}}</span>
                            </span>
                </div>
                <div class="col-sm-2 align-center">{{txt.summaryCol4}} %</div>
                <div class="col-sm-1 align-right">
                            <span class="inline">{{txt.summaryCol5}}
                                <span class="block-left">{{txt.summaryCol5_2}}</span>
                            </span>
                </div>
                <div class="col-sm-1 align-right">
                            <span class="inline">{{txt.summaryCol6}}
                                <span class="block-left">{{txt.summaryCol6_2}}</span>
                            </span>
                </div>
            </div>
            <div v-for="line in summaryData.summaryItem">
                <summary-item
                        :line-data="line"
                        :coin="coin"
                ></summary-item>
            </div>
            <div class="row border-bottom complements-header">
                <div class="col-sm-12 pl-5">
                    <span>{{txt.summaryLine2}}</span>
                </div>
            </div>
            <div v-for="line in summaryData.summaryComplement">
                <summary-item
                        :line-data="line"
                        :coin="coin"
                ></summary-item>
            </div>
            <div class="row border-bottom complements-header">
                <div class="col-sm-12 pl-5">
                    <span>{{txt.summaryLine3}}</span>
                </div>
            </div>
            <div v-for="line in summaryData.summaryCharges">
                <summary-item
                        :line-data="line"
                        :coin="coin"
                ></summary-item>
            </div>
        </div>
        <div class="row border-top final-price-label">
            <div class="col-sm-4">
                <span>{{txt.summaryTitle4}}</span>
            </div>
            <div class="col align-self-end align-right">{{summaryData.subtotal}} {{coin}}</div>
        </div>
    </div>
</template>

<script>
    import SummaryItem from "./SummaryItem";
    export default {
        name: "SummaryBooking",
        components: {SummaryItem},
        props: {
            summaryData: Object,
            coin: String
        },
        data() {
            return {
                txt: {}
            }
        },
        mounted() {
            this.txt = txtTrans.txtForm;
        },
    }
</script>

<style scoped>
    .input-wrapper input{
        margin-bottom: 7px;

        width: 100%;
        padding: 10px;
        padding-left: 40px;
        font: normal normal normal 11pt Roboto;
        color: #576271;
        border: 1px solid #576271;
        border-radius: 5px;

    }
    .info-card .card-content .second-title {
        font: normal normal normal 14pt Roboto;
    }

    .icon {
        position: absolute;
        width: 15px;
        height: 15px;
        line-height: 1em;
        display: inline-block;

        top: 12px;
        left: 20px;
    }
    .final-price-label{
        text-align: left;
        letter-spacing: 0px;
        color: #576271;
        opacity: 1;
        padding: 10px 30px;
        font-size: 1.3rem;
        font-weight: 400;
    }


    .info-card .card-title {
        text-align: left;
        font: normal normal normal 17pt Roboto;
        letter-spacing: 0px;
        color: #576271;
        opacity: 1;
        padding: 15px 15px;
    }

    .table th, .table td{
        color: #576271;
        vertical-align: middle;
        text-align: center;
    }

    .row{
        margin-right: 0px;
        margin-left: 0px;
        margin-bottom: 20px;
        font-family: Roboto;
    }

    .complements-wrapper{
        margin: 10px 30px;
    }
    .complements-header{
        display: flex;
        align-items: flex-end;
        justify-content: center;
        color: #576271;
        font-size: 1.1rem;
        padding-bottom: 5px;
        font-weight: 600;
    }

    .button.v-span span{
        line-height: 54px;
    }

    .included-counter-title{
        text-align: left;
        letter-spacing: 0px;
        color: #576271;
        opacity: 1;
        padding: 25px 30px;
        font-size: 1.3rem;
        font-weight: 400;
    }

    .align-center{
        text-align: center;
    }
    .align-right{
        text-align: right;
    }
    .bill-company input{
        height: 25px;
        width: 25px;
    }
    .bill-company label{
        margin-left: 10px;
        font-size: 1.3rem;
        color: #707070;
    }
    .inline{
        display: inline-block;
    }

    .inline-left{
        display: inline-block;
        text-align: left;
    }

    .block-left{
        display: block; text-align: left;
    }
    #upgradeModal .modal-footer{
        justify-content: center;
    }

    #upgradeModal .modal-title{
        text-align: left;
        font: normal normal medium Roboto;
        font-size: 17pt;
        letter-spacing: 0px;
        color: #576271;
        opacity: 1;
    }
    #upgradeModal .modal-body .subtitle{
        text-align: left;
        font: normal normal normal Roboto;
        font-size: 14pt;
        letter-spacing: 0px;
        color: #576271;
        opacity: 1;

        margin-bottom: 2.5em;
        margin-top: 1em;
    }

    #upgradeModal .modal-body .upgrade-link{
        text-align: left;
        text-decoration: underline;
        font: normal normal medium Roboto;
        letter-spacing: 0px;
        opacity: 1;

        margin-bottom: 10px;
    }
    .upgrade-link a{
        color: #CE2D30;
        font-size: 12pt;
    }

    #upgradeModal .btn-back{
        background: #FFFFFF 0% 0% no-repeat padding-box;
        border: 2px solid #CE2D30;

        color: #CE2D30;
        font-size: 12pt;
        padding: 10px 8em;
    }
    .btn-upgrade{
        background: #C21823 0% 0% no-repeat padding-box;
        color: #FFFFFF;
        font: normal normal medium Roboto;
        font-size: 12pt;

        padding: 12px 20px;
        border-radius: 5px;


    }
</style>