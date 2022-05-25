<template>

    <detail-view title="Terms & Conditions Page" :breadcrumb="breadcrumb">
        <terms-section></terms-section>
    </detail-view>
</template>

<script>
import DetailView from "@/Views/DetailView.vue";
import { Tabs, Tab } from "vue3-tabs-component";
import { Link } from "@inertiajs/inertia-vue3";
import TermsSection from "./TermsSection.vue";
export default {
    name: "show-Terms",

    components: {
        Link,
        DetailView,
        Tabs,
        Tab,
        TermsSection,
    },
    data() {
        return {
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Terms & Conditions", route: null },
            ],
        };
    },
};
</script>
