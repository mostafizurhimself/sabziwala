<template>

    <detail-view title="Payment & Refunds" :breadcrumb="breadcrumb">
        <payment-refund-section></payment-refund-section>
    </detail-view>
</template>

<script>
import DetailView from "@/Views/DetailView.vue";
import { Tabs, Tab } from "vue3-tabs-component";
import { Link } from "@inertiajs/inertia-vue3";
import PaymentRefundSection from "./PaymentRefundSection.vue";

export default {
    name: "show-PaymentRefunds",

    components: {
        Link,
        DetailView,
        Tabs,
        Tab,
        PaymentRefundSection,
    },
    data() {
        return {
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Payment & Refunds", route: null },
            ],
        };
    },
};
</script>
