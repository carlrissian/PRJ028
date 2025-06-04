<template>
    <div class="row complements-item">
        <div class="col-sm-4 extra-label">
            <label>{{ this.lineData.title }}</label>
        </div>
        <div class="col-sm-1 align-center"><label>{{this.lineData.ud}}</label></div>
        <div class="col-sm-2 align-center"><label>{{this.lineData.taxApply}} %</label></div>
        <div class="col-sm-1 align-right"><label>{{ this.lineData.taxImport}} {{this.coin}}</label></div>
        <div class="col-sm-2 align-center"><label>{{this.lineData.discount}} %</label></div>
        <div class="col-sm-1 align-right"><label>{{ this.lineData.unitImport}} {{this.coin}}</label></div>
        <div class="col-sm-1 align-right"><label>{{ this.lineData.totalImport}} {{this.coin}}</label></div>
    </div>
</template>

<script>
    export default {
        name: "SummaryItem",
        props: {
            lineData: Object,
            coin: String
        }
    }
</script>

<style scoped>
    .complements-item{
        color: #707070;
        font-weight: normal;
    }
    .align-center{
        text-align: center;
    }
    .align-right{
        text-align: right;
    }
</style>