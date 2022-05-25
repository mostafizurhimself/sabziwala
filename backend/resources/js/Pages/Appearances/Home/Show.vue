<template>
    <detail-view title="Home Page" :breadcrumb="breadcrumb">
        <tabs :options="{ useUrlFragment: false }">
            <tab name="Hero Section">
                <hero-section></hero-section>
            </tab>

            <tab name="How It Works">
                <how-it-works-section></how-it-works-section>
            </tab>

            <tab name="App Section">
                <apps-section></apps-section>
            </tab>
        </tabs>
    </detail-view>
</template>

<script>
import DetailView from "@/Views/DetailView.vue";
import { Tabs, Tab } from "vue3-tabs-component";
import { Link } from "@inertiajs/inertia-vue3";
import HeroSection from "./HeroSection.vue";
import HowItWorksSection from "./HowItWorksSection.vue";
import AppsSection from "./AppsSection.vue";

export default {
    name: "show-homePage",

    components: {
        Link,
        DetailView,
        Tabs,
        Tab,
        HeroSection,
        HowItWorksSection,
        AppsSection,
    },
    data() {
        return {
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Home Page", route: null },
            ],
        };
    },
};
</script>
