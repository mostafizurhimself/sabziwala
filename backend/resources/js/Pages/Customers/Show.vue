<template>
    <detail-view title="Customer Details" :breadcrumb="breadcrumb">

        <tabs :options="{ useUrlFragment: false }">
            <tab name="Profile">
                <!-- ID -->
                <detail-section class="border-b" label="ID" :value="customer.id"></detail-section>
                <!-- Profile Photo -->
                <detail-section class="border-b" label="Profile Photo">
                    <image-preview :url="customer.profilePhotoUrl"></image-preview>
                </detail-section>

                <!-- Name -->
                <detail-section class="border-b" label="Name" :value="customer.name"></detail-section>

                <!-- Email -->
                <detail-section class="border-b" label="Email">
                    <a class="text-blue-500" :href="`mailto:${customer.email}`">{{customer.email}}</a>
                </detail-section>

                <!-- Phone -->
                <detail-section class="border-b" label="Phone">
                    <a class="text-blue-500" :href="`tel:${customer.phone}`">{{customer.phone}}</a>
                </detail-section>

                <!-- Last Login -->
                <detail-section class="border-b" label="Last Login">
                    <a class="text-blue-500" :href="`tel:${customer.lastLoginForHuman}`">{{customer.lastLoginForHuman}}</a>
                </detail-section>

                <!-- Balance -->
                <detail-section class="border-b" label="Balance" :value="customer.balanceFormatted"></detail-section>

                <!-- Status-->
                <detail-section label="Status">
                    <jet-badge :value="customer.status"></jet-badge>
                </detail-section>
            </tab>

            <tab name="Address">
                <!-- Billing Address -->
                <detail-section class="border-b" label="Billing Address">
                    <p class="text-90" v-if="customer.billingAddress">{{ customer.billingAddress.street }}, {{ customer.billingAddress.city }}, {{ customer.billingAddress.country }} - {{ customer.billingAddress.zipcode }}</p>
                    <p v-else>-</p>
                </detail-section>

                <!-- Shipping Address -->
                <detail-section class="border-b" label="Shipping Address">
                    <p class="text-90" v-if="customer.shippingAddress">{{ customer.shippingAddress.street }}, {{ customer.shippingAddress.city }}, {{ customer.shippingAddress.country }} - {{ customer.shippingAddress.zipcode }}</p>
                    <p v-else>-</p>
                </detail-section>
            </tab>
        </tabs>

        <template #secondary-view>
            <div class="mt-8">

                <h1 class="font-bold text-xl">Transaction History</h1>
                <datatable :data="transactions">
                    <!--Table Rows -->
                    <template #default="{rows}">
                        <table v-if="rows.length">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>Order Id</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Description</th>
                                </tr>

                            </thead>
                            <tbody>
                                <tr v-for="(row, index) in rows" :key="index">
                                    <td>{{row.id}}</td>
                                    <td>{{row.dateFormatted}}</td>
                                    <td>
                                        <Link class="text-green-500 font-semibold cursor-pointer" :href="route('orders.show', row.order.id)">
                                        {{row.orderId ? row.orderId : "-"}}
                                        </Link>
                                    </td>

                                    <td>{{row.amountFormatted}}</td>
                                    <td>{{row.method}}</td>
                                    <td class="truncate" style="max-width:200px">{{row.description}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </template>
                    <template #nodata>No Transaction History Found</template>

                </datatable>
            </div>
        </template>

    </detail-view>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import DetailView from "@/Views/DetailView.vue";
import DetailSection from "@/Jetstream/DetailSection.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Tabs, Tab } from "vue3-tabs-component";
import ImagePreview from "@/Partials/ImagePreview.vue";
import JetBadge from "@/Jetstream/Badge.vue";
import Datatable from "@/Jetstream/Datatable.vue";

export default {
    name: "customer-details",
    props: {
        customer: Object,
        transactions: Object,
        order: Object,
    },

    components: {
        AppLayout,
        DetailView,
        Datatable,
        DetailSection,
        Link,
        Tabs,
        Tab,
        ImagePreview,
        JetBadge,
    },

    data() {
        return {
            breadcrumb: [
                { label: "Home", route: this.route("dashboard") },
                { label: "Customers", route: this.route("customers.index") },
                { label: this.customer.name, route: null },
            ],
        };
    },
};
</script>
