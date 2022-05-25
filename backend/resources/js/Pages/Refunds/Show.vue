<template>
	<detail-view title="Refund Request Details" :breadcrumb="breadcrumb">
		<!-- ID -->
		<detail-section class="border-b" label="ID" :value="refundRequest.id"></detail-section>

		<!-- Date -->
		<detail-section class="border-b" label="Date" :value="refundRequest.dateFormatted"></detail-section>

		<!-- Invoice No -->
		<detail-section class="border-b" label="Invoice No.">
			<Link class="text-green-500 font-semibold cursor-pointer" :href="route('orders.show', refundRequest.order.id)">
			{{refundRequest.order.invoiceNo}}
			</Link>
		</detail-section>

		<!-- Customer Name -->
		<detail-section class="border-b" label="Customer" :value="refundRequest.customer.name"></detail-section>

		<!-- Grand Total -->
		<detail-section class="border-b" label="Grand Total" :value="refundRequest.order.grandTotalFormatted"></detail-section>

		<!-- Note -->
		<detail-section class="border-b" label="Note" :value="refundRequest.reason"></detail-section>

		<!-- Status -->
		<detail-section class="border-b" label="Status">
			<jet-badge :value="refundRequest.status"></jet-badge>
		</detail-section>

		<!-- Action -->
		<detail-section class="" label="Action" v-if="refundRequest.status == 'pending'">
			<update-refund-status></update-refund-status>
		</detail-section>
	</detail-view>

</template>

<script>
import DetailView from "@/Views/DetailView.vue";
import DetailSection from "@/Jetstream/DetailSection.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetBadge from "@/Jetstream/Badge.vue";
import UpdateRefundStatus from "@/Actions/UpdateRefundStatus.vue";

export default {
	name: "refund-request-details",
	props: {
		refundRequest: Object,
		refundStatusOptions: Array,
	},

	components: {
		DetailView,
		DetailSection,
		Link,
		JetBadge,
		UpdateRefundStatus,
	},

	data() {
		return {
			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{
					label: "Refund Requests",
					route: this.route("refund-requests.index"),
				},
				{ label: this.refundRequest.order.invoiceNo, route: null },
			],
		};
	},
};
</script>
