<template>
    <div
        v-if="footerComponent"
        v-show="showFooter"
        id="kt_footer"
        class="kt-footer kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop flex-shrink-0 shadow-inverse"
        :class="{ 'kt-footer--sticky': stickyFooter }"
    >
        <component :is="footerComponent" />
    </div>
</template>

<script>
export default {
    name: "DynamicFooter",
    data() {
        return {
            footerComponent: null,
            stickyFooter: false,
            showFooter: false,
        };
    },
    mounted() {
        this.eventBus.$on("setFooterComponent", (component) => {
            console.log("setFooterComponent", component);
            this.footerComponent = component;
        });
        this.eventBus.$on("stickyFooter", (sticky) => {
            this.stickyFooter = sticky;
        });
        this.eventBus.$on("showFooter", (show) => {
            this.showFooter = show;
        });
    },
};
</script>

<style scoped>
.kt-footer--sticky {
    position: fixed;
    bottom: 0;
    width: -webkit-fill-available;
}

.shadow-inverse {
    box-shadow: 0px 0px 40px 0px rgba(82, 63, 105, 0.1);
}
</style>
