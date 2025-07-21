<template>
    <div class="row">
        <div class="col-md-12" v-for="imageLine in imageLineList" :key="imageLine.index">
            <div class="row" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">
                <div class="col-md-3">
                    <label for="acrissImageDescription"><strong v-text="txt.fields.description"></strong></label>
                    <p
                        id="acrissImageDescription"
                        class="acrissImageDescription pl-3"
                        v-text="imageLine.description"
                    ></p>
                </div>
                <div class="col-md-9">
                    <label for="acrissImageUrl"><strong v-text="txt.fields.image"></strong></label>
                    <p id="acrissImageUrl" class="acrissImageUrl pl-3">
                        <img style="display: inline-block; max-height: 128px; max-width: 128px;" :src="imageLine.url" />
                    </p>
                </div>
            </div>
            <hr />
        </div>
    </div>
</template>
<script>
export default {
    name: "ShowImageLine",
    components: {},
    props: {
        imageLineList: Array,
    },
    data() {
        return {
            txt: {},
        };
    },
    created() {
        this.txt = txtTrans;
    },
    methods: {},
};
</script>

<style scoped>
span {
    margin-top: auto;
    margin-bottom: auto;
}
li input {
    margin-top: auto;
    margin-bottom: auto;
}
li button {
    margin-top: auto;
    margin-bottom: auto;
}
ul.acrissImageList {
    border: 1px solid #e2e5ec;
    border-bottom: none;
    list-style: none;
    margin: 0;
    padding: 0;
}
ul.acrissImageList li {
    background: #f4f4f4;
    border-bottom: 1px solid #e2e5ec;
    border-top: 1px solid #fff;
}
ul.acrissImageList li span {
    display: block;
    padding: 15px 0 15px 20px;
    text-decoration: none;
    margin-top: auto;
    margin-bottom: auto;
}
</style>
