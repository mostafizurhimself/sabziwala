<template>
    <detail-view title="Product Details" :breadcrumb="breadcrumb">

        <tabs :options="{ useUrlFragment: false }">
            <tab name="Product Details">
                <!-- ID -->
                <detail-section class="border-b" label="ID" :value="product.id"></detail-section>

                <!-- Zone -->
                <detail-section class="border-b" label="Zone" :value="product.zone.name"></detail-section>

                <!-- Category -->
                <detail-section class="border-b" label="Category" :value="product.category.name"></detail-section>

                <!-- Name -->
                <detail-section class="border-b" label="Name" :value="product.name"></detail-section>

                <!-- Code -->
                <detail-section class="border-b" label="Code" :value="product.code"></detail-section>

                <!-- Description -->
                <detail-section class="border-b" label="Description" :value="product.description"></detail-section>

                <!-- Actual Price -->
                <detail-section class="border-b" label="Actual Price" :value="product.actualPriceFormatted"></detail-section>

                <!-- Sale Price -->
                <detail-section class="border-b" label="Sale Price" :value="product.salePriceFormatted"></detail-section>

                <!-- Unit -->
                <detail-section class="border-b" label="Unit" :value="product.unit.name"></detail-section>

                <!-- Average Ratings -->
                <detail-section class="border-b" label="Average Ratings" :value="product.averageRatings"></detail-section>

                <!-- Status -->
                <detail-section label="Status" class="border-b">
                    <jet-badge :value="product.status"></jet-badge>
                </detail-section>

                <!-- Change Status -->
                <detail-section class="border-b" label="Change Status">
                    <button class="btn mr-2" :class="{'btn-success' : product.status == 'unpublished', 'btn-danger': product.status == 'published'}" @click="togglePublished(product.id)">
                        <div class="flex items-center" v-if="product.status == 'unpublished'">
                            <span class="ml-2">publish</span>
                        </div>

                        <div class="flex items-center" v-else>
                            <span class="ml-2">Unpublish</span>
                        </div>
                    </button>
                </detail-section>

                <!-- Featured -->
                <!-- <detail-section class="border-b" label="Featured" :value="product.isFeatured"></detail-section> -->
                <!-- Featured -->
                <detail-section class="border-b" label="Featured">
                    <unverified-icon class="text-primary-500" v-if="product.isFeatured == '0'"></unverified-icon>
                    <verified-icon class="text-green-500" v-else></verified-icon>
                </detail-section>

                <!-- Change Featured -->
                <detail-section class="border-b" label="Change Featured">
                    <button class="btn mr-2" :class="{'btn-success' : product.isFeatured == '0', 'btn-danger': product.isFeatured == '1'}" @click="toggleIsFeatured(product.id)">
                        <div class="flex items-center" v-if="product.isFeatured == 'unpublished'">
                            <span class="ml-2">Featured</span>
                        </div>

                        <div class="flex items-center" v-else>
                            <span class="ml-2">Not Featured</span>
                        </div>
                    </button>
                </detail-section>

            </tab>

            <!-- Media Tab -->
            <tab name="Others">
                <!-- Tags -->
                <detail-section class="border-b" label="Tags">
                    <p class="text-90">{{ product.tags.map(tag => tag.name).join(", ") }}</p>
                </detail-section>

                <!-- Images -->
                <detail-section class="border-b" label="Images">
                    <multiple-image-preview :medias="product.mediaCollection"></multiple-image-preview>
                </detail-section>

                <!-- Thumbnail -->
                <detail-section class="border-b" label="Thumbnail">
                    <image-preview :url="product.thumbnailMediaUrl"></image-preview>
                </detail-section>
            </tab>
        </tabs>

    </detail-view>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import DetailView from "@/Views/DetailView.vue";
import DetailSection from "@/Jetstream/DetailSection.vue";
import MultipleImagePreview from "@/Partials/MultipleImagePreview.vue";
import ImagePreview from "@/Partials/ImagePreview.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Tabs, Tab } from "vue3-tabs-component";
import JetBadge from "@/Jetstream/Badge.vue";
import VerifiedIcon from "@/Icons/VerifiedIcon.vue";
import UnverifiedIcon from "@/Icons/UnverifiedIcon.vue";

export default {
    name: "product-details",
    props: {
        product: Object,
    },

    components: {
        AppLayout,
        DetailView,
        DetailSection,
        MultipleImagePreview,
        ImagePreview,
        Link,
        Tabs,
        Tab,
        JetBadge,
        VerifiedIcon,
        UnverifiedIcon,
    },

    data() {
        return {
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Products", route: this.route("products.index") },
                { label: this.product.name, route: null },
            ],
        };
    },

    methods: {
        togglePublished(id) {
            this.$swal
                .fire({
                    title: "Are you sure?",
                    text: "",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#EF4444",
                    confirmButtonText: "Yes, do it!",
                    cancelButtonText: "Cancel",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        this.$inertia.post(
                            this.route("products.published", id)
                        );
                    }
                });
        },

        toggleIsFeatured(id) {
            this.$swal
                .fire({
                    title: "Are you sure?",
                    text: "",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#EF4444",
                    confirmButtonText: "Yes, do it!",
                    cancelButtonText: "Cancel",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        this.$inertia.post(
                            this.route("products.isFeatured", id)
                        );
                    }
                });
        },
    },
};
</script>
