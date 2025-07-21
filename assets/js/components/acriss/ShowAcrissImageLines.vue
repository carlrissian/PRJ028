<template>
    <fragment>
        <div class="kt-section">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" id="acrissImageLines">
                        <show-image-line :image-line-data="imageLineValues"/>
                    </div>
                </div>
            </div>
        </div>

    </fragment>
</template>

<script>

    import ShowImageLine from "./ShowImageLine.vue";
    export default {
        name: "ShowAcrissImageLines",
        components: { ShowImageLine },
        props: {
            imageLineData: {},
        },
        data() {
            return {
                txt: {},
                imageLineValues: [],
            }
        },
        methods: {
            addItem(index, description, url) {
                this.imageLineValues.push({index: index, description: description, url: url});
            }
        },
        mounted() {
            this.txt = txtTrans.txtAcriss;

            for(let i = 0; i<this.imageLineData.length; i++){
                this.addItem(this.imageLineData[i].index, this.imageLineData[i].description, this.imageLineData[i].url)
            }
        }
    }
</script>

<style scoped>

</style>
