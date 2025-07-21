<template>
    <fragment>
        <notifications position="top right" />

        <details-acriss v-if="acriss" :acriss="acriss" />
    </fragment>
</template>

<script>
import Loading from "../../../assets/js/utilities.js";
import DetailsAcriss from "../../components/acriss/DetailsAcriss.vue";

export default {
    name: "AcrissShowPage",
    components: {
        DetailsAcriss,
    },
    props: {
        acriss: Object,
    },
    data() {
        return {
            txt: txtTrans,
        };
    },
    mounted() {
        if (!this.acriss) {
            window.swal
                .fire({
                    title: this.txt.form.acrissNotFound,
                    text: "",
                    type: "warning",
                    confirmButtonColor: "#48465b",
                })
                .then((result) => {
                    Loading.starLoading();
                    setTimeout(() => {
                        window.location.href = this.routing.generate("acriss.list");
                    }, 300);
                });
        }
    },
};
</script>

<style scoped></style>
