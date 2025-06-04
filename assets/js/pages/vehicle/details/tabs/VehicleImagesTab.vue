<template>
    <ssr-carousel v-if="imageList.length > 0" :slides-per-page="4">
        <div v-for="image in imageList" class="slide"><img width="100%" :src="image" /></div>
    </ssr-carousel>
    <p v-else class="text-center" v-text="txt.form.noVehicleImagesAvailable"></p>
</template>

<script>
import SsrCarousel from "vue-ssr-carousel";
import ssrCarouselCss from "vue-ssr-carousel/index.css";

export default {
    name: "VehicleImagesTab",
    components: {
        SsrCarousel,
    },
    props: {
        imageList: {
            type: Array,
            required: true,
        },
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
