<template>

    <detail-view title="About Page" :breadcrumb="breadcrumb">
        <tabs :options="{ useUrlFragment: false }">
            <tab name="Hero Section">
                <about-hero-section></about-hero-section>
            </tab>

            <tab name="Owner Comment">
                <owner-comment-section></owner-comment-section>
            </tab>

            <tab name="Why Choose Us">
                <why-choose-us-section></why-choose-us-section>
            </tab>

            <tab name="Faq Section">
                <about-faq-section></about-faq-section>
            </tab>

        </tabs>
    </detail-view>
</template>

<script>
import DetailView from "@/Views/DetailView.vue";
import { Tabs, Tab } from "vue3-tabs-component";
import { Link } from "@inertiajs/inertia-vue3";
import AboutHeroSection from "./AboutHeroSection.vue";
import OwnerCommentSection from "./OwnerCommentSection.vue";
import WhyChooseUsSection from "./WhyChooseUsSection.vue";
import AboutFaqSection from "./AboutFaqSection.vue";
export default {
    name: "About-Page",

    components: {
        Link,
        DetailView,
        Tabs,
        Tab,
        AboutHeroSection,
        OwnerCommentSection,
        WhyChooseUsSection,
        AboutFaqSection,
    },
    data() {
        return {
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "About Page", route: null },
            ],
        };
    },
};
</script>
