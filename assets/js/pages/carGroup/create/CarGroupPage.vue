<template>
    <fragment>
       <create-car-group-page :select-list="selectList"></create-car-group-page>
    </fragment>
</template>
<script>

import CreateCarGroupPage from "./CreateCarGroupPage";
export default {
    name: "CarGroupPage",
    components: { CreateCarGroupPage },
    props:{
      selectList: {},
    },
    data() {
        return {
            txtTranslations: txtTrans.txtCarGroup
        }
    },
    methods: {

    }
}
</script>

<style scoped>

</style>