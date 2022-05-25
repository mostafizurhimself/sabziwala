<template>
    <detail-view title="Review Details" :breadcrumb="breadcrumb">

        <!-- ID -->
        <detail-section class="border-b" label="ID" :value="review.id"></detail-section>
        <!-- Date -->
        <detail-section class="border-b" label="Date" :value="review.dateFormatted"></detail-section>
        <!-- Product Name -->
        <detail-section class="border-b" label="Product Name" :value="review.reviewrateable.name"></detail-section>
        <!-- Customer Name -->
        <detail-section class="border-b" label="Customer Name" :value="review.author.name"></detail-section>
        <!-- Rating -->
        <detail-section class="border-b" label="Rating" :value="review.rating"></detail-section>
        <!-- Comment -->
        <detail-section class="border-b" label="Comment" :value="review.body"></detail-section>

        <!--  Approved Status -->
        <detail-section class="border-b" label=" Approved Status">
            <unverified-icon class="text-primary-500" v-if="review.approved == '0'"></unverified-icon>
            <verified-icon class="text-green-500" v-else></verified-icon>
        </detail-section>

    </detail-view>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import DetailView from "@/Views/DetailView.vue";
import DetailSection from "@/Jetstream/DetailSection.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Tabs, Tab } from "vue3-tabs-component";
import VerifiedIcon from "@/Icons/VerifiedIcon.vue";
import UnverifiedIcon from "@/Icons/UnverifiedIcon.vue";
import JetBadge from "@/Jetstream/Badge.vue";

export default {
    name: "review-details",
    props: {
        review: Object,
    },

    components: {
        AppLayout,
        DetailView,
        DetailSection,
        Link,
        Tabs,
        Tab,
        VerifiedIcon,
        UnverifiedIcon,
        JetBadge,
    },

    data() {
        return {
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Reviews", route: this.route("reviews.index") },
                { label: this.review.id, route: null },
            ],
        };
    },
};
</script>
