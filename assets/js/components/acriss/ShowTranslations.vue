<template>
    <div class="row">
        <div class="col-md-12" v-for="translationLine in translationLineList" :key="translationLine.index">
            <label v-if="translationLine.default"><strong v-text="txt.fields.byDefault"></strong></label>

            <div class="kt-checkbox-inline">
                <label class="kt-checkbox control-label">
                    <input type="checkbox" :checked="translationLine.default" onclick="return false;" />
                    <span></span>
                    <div style="display: inline-block" :title="translationLine.language.name">
                        <strong v-text="translationLine.language.iso"></strong>
                    </div>
                    <div style="margin-left:10px; display: inline-block" v-text="translationLine.translation"></div>
                </label>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "ShowTranslations",
    components: {},
    props: {
        translationLineList: Array,
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
