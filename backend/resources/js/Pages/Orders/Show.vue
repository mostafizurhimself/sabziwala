<template>
	<detail-view title="Order Details" :breadcrumb="breadcrumb">

		<tabs :options="{ useUrlFragment: false }">
			<tab name="Order Details">
				<!-- ID -->
				<detail-section class="border-b" label="ID" :value="order.id"></detail-section>

				<!-- Date -->
				<detail-section class="border-b" label="Date" :value="order.dateFormatted"></detail-section>

				<!-- Invoice No -->
				<detail-section class="border-b" label="Invoice No." :value="order.invoiceNo"></detail-section>

				<!-- Customer Name -->
				<detail-section class="border-b" label="Customer" :value="order.customer.name"></detail-section>

				<!-- Note -->
				<detail-section class="border-b" label="Note" :value="order.note"></detail-section>

				<!-- Sub Total -->
				<detail-section class="border-b" label="Sub Total" :value="order.subTotalFormatted"></detail-section>

				<!-- Total Discount -->
				<detail-section class="border-b" label="Total Discount" :value="order.totalDiscountFormatted"></detail-section>

				<!-- Grand Total -->
				<detail-section class="border-b" label="Grand Total" :value="order.grandTotalFormatted"></detail-section>

				<!-- Method -->
				<detail-section class="border-b" label="Method" :value="order.paymentMethod"></detail-section>

				<!-- Status -->
				<detail-section class="border-b" label="Status">
					<jet-badge :value="order.status"></jet-badge>
				</detail-section>

                <!-- Action -->
                <detail-section class="" label="Action" v-if="hasPermissions(['updateOrders'])">
                    <div class="flex ">
                        <update-order-status :selectedIds="[order.id]" :zone="order.zone" type="single"></update-order-status>
                        <assign-rider :selectedIds="[order.id]" :zone="order.zoneId" class="ml-4"></assign-rider>
                    </div>

				</detail-section>

			</tab>

			<tab name="Address">
				<!-- Billing Address -->
				<detail-section class="border-b" label="Billing Address">
					<p class="text-90" v-if="order.billingAddress">{{ order.billingAddress.street }}, {{ order.billingAddress.city }}, {{ order.billingAddress.country }} - {{ order.billingAddress.zipcode }}</p>
					<p v-else>-</p>
				</detail-section>

				<!-- Shipping Address -->
				<detail-section class="border-b" label="Shipping Address">
					<p class="text-90" v-if="order.shippingAddress">{{ order.shippingAddress.street }}, {{ order.shippingAddress.city }}, {{ order.shippingAddress.country }} - {{ order.shippingAddress.zipcode }}</p>
					<p v-else>-</p>
				</detail-section>

			</tab>

			<tab name="Rider Info" v-if="order.rider">

				<!-- Name -->
				<detail-section class="border-b" label="Name" :value="order.rider.name"></detail-section>

				<!-- Assign Date -->
				<detail-section class="border-b" label="Assign Date" :value="order.assignDateFormatted"></detail-section>

				<!-- Phone -->
				<detail-section class="border-b" label="Phone" :value="order.rider.phone"></detail-section>

				<!-- Email -->
				<detail-section class="border-b" label="Email" :value="order.rider.email"></detail-section>

			</tab>
		</tabs>

		<template #secondary-view>
			<div class="mt-8">

				<h1 class="font-bold text-xl">Order Items</h1>
				<datatable :data="orderItems">
					<!--Table Rows -->
					<template #default="{rows}">
						<table v-if="rows.length">
							<thead>
								<tr>
									<th>Id</th>
									<th>Name</th>
									<th>Rate</th>
									<th>Unit</th>
									<th>Amount</th>
								</tr>

							</thead>
							<tbody>
								<tr v-for="(row, index) in rows" :key="index">
									<td>{{row.id}}</td>
									<td>{{row.product.name}}</td>
									<td>{{row.rateFormatted}}</td>
									<td>{{row.quantity}} {{row.unit.code}}</td>
									<td>{{row.amountFormatted}}</td>

								</tr>
							</tbody>
						</table>
					</template>
					<template #nodata>No Order Items Found</template>

				</datatable>
			</div>
		</template>

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
import Datatable from "@/Jetstream/Datatable.vue";
import JetBadge from "@/Jetstream/Badge.vue";
import UpdateOrderStatus from "@/Actions/UpdateOrderStatus.vue";
import AssignRider from "@/Actions/AssignRider.vue";

export default {
	name: "order-details",
	props: {
		order: Object,
		orderItems: Object,
		statusOptions: Array,
		riders: Object,
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
		Datatable,
		UpdateOrderStatus,
		JetBadge,
		AssignRider,
	},

	data() {
		return {
			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Orders", route: this.route("orders.index") },
				{ label: this.order.invoiceNo, route: null },
			],
		};
	},
};
</script>
