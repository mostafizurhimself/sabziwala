<template>

    <detail-view title="Rider Page" :breadcrumb="breadcrumb">
        <tabs :options="{ useUrlFragment: false }">
            <tab name="Hero Section">
                <rider-hero-section></rider-hero-section>
            </tab>

            <tab name="Work With Us">
                <work-with-us-section></work-with-us-section>
            </tab>

            <tab name="App Section">
                <rider-apps-section></rider-apps-section>
            </tab>

            <tab name="Faq Section">
               <rider-faq-section></rider-faq-section>
            </tab>
        </tabs>
    </detail-view>
</template>

<script>
import DetailView from "@/Views/DetailView.vue";
import { Tabs, Tab } from "vue3-tabs-component";
import { Link } from "@inertiajs/inertia-vue3";
import RiderHeroSection from "./RiderHeroSection.vue";
import RiderAppsSection from "./RiderAppsSection.vue";
import WorkWithUsSection from "./WorkWithUsSection.vue";
import RiderFaqSection from "./RiderFaqSection.vue";

export default {
    name: "show-riderPage",

    components: {
        Link,
        DetailView,
        Tabs,
        Tab,
        RiderHeroSection,
        RiderAppsSection,
        WorkWithUsSection,
        RiderFaqSection,
    },
    data() {
        return {
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Rider Page", route: null },
            ],
        };
    },
};
</script>
