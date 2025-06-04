<template>
    <fragment>
       <create-commercial-group-page :select-list="selectList" />
    </fragment>
</template>

<script>

    import CreateCommercialGroupPage from "./CreateCommercialGroupPage";

    export default {
        name: "CommercialGroupPage",
        components: { CreateCommercialGroupPage },
        props: {
          selectList: {},
        },
        data() {
            return {
                txtTranslations : txtTrans.txtIndex,
            }
        },
        methods: {

        }
    }
</script>
<style scoped>

</style>
