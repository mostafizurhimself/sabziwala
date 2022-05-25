<template>
    <detail-view title="Contact Page" :breadcrumb="breadcrumb">
        <contact-hero-section></contact-hero-section>
    </detail-view>
</template>

<script>
import DetailView from "@/Views/DetailView.vue";
import { Tabs, Tab } from "vue3-tabs-component";
import { Link } from "@inertiajs/inertia-vue3";
import ContactHeroSection from "./ContactHeroSection.vue";
export default {
    name: "show-riderPage",

    components: {
        Link,
        DetailView,
        Tabs,
        Tab,
        ContactHeroSection,
    },
    data() {
        return {
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Contact Page", route: null },
            ],
        };
    },
};
</script>
