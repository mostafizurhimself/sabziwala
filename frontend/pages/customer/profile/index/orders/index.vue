<template>
	<loading :loading="isLoading" height="300px">
		<div>
			<div class="grid grid-cols-1 md:grid-cols-2 gap-4" v-if="orders && orders.data">
				<!-- card 1 -->
				<div class="bg-white py-3 px-4 shadow rounded-lg flex md:block lg:flex items-center" v-for="(status, i) in ordersStatus" :key="i">
					<img :src="status.url" class="h-8" alt="">
					<div class="ml-4 md:ml-0 lg:ml-4 flex md:block lg:flex w-full justify-between">
						<h6 class="font-semibold text-lg">{{status.title}}</h6>
						<h5 class="font-bold text-xl " :class="status.textColor">{{status.amount}}</h5>
					</div>
				</div>
			</div>

			<!-- table -->
			<div class="overflow-x-auto mt-5">
				<table class="border-collapse border border-gray-200 w-full rounded-md" v-if="orders.data && orders.data.length">
					<thead class="bg-gray-200">
						<tr>
							<th class="text-left py-3 px-4">Invoice</th>
							<th class="text-left py-3 px-4">Date</th>
							<th class="text-left py-3 px-4">Total</th>
							<th class="text-left py-3 px-4">Status</th>
							<th class="text-right py-3 px-4"></th>
						</tr>
					</thead>
					<tbody class="divide-y devide-gray-200">
						<tr class="hover:bg-gray-50" v-for="order in orders.data" :key="order.id">
							<td class="py-3 px-4 font-medium">
								<!-- Refund Request Modal -->
								<nuxt-link :to="`/customer/profile/orders/${order.id}`" class="text-primary-500 text-md hover:underline cursor-pointer">{{order.invoiceNo}}</nuxt-link>
							</td>
							<td class="py-3 px-4 whitespace-nowrap">{{order.dateFormatted}}</td>
							<td class="py-3 px-4">{{order.grandTotalFormatted}}</td>
							<td class="py-3 px-4">
								<the-badge :value="order.status"></the-badge>
							</td>
							<td>
								<nuxt-link :to="`/customer/profile/orders/${order.id}`" class="bg-transparent hover:bg-green-500 text-green-500 hover:text-white px-2 py-1 border border-green-500 rounded text-xs">Details</nuxt-link>
							</td>
						</tr>
					</tbody>
				</table>
				<div v-else class="h-16 w-full border border-gray-200 flex items-center justify-center">
					<p class="text-gray-600">No orders found.</p>
				</div>
			</div>

			<!-- Mobile Pagination -->
			<div class="mt-5 flex sm:hidden">
				<pagination :data="orders" @pagination-change-page="getResults" :limit="-1">
					<span slot="prev-nav">
						<LeftIcon />
					</span>
					<span slot="next-nav">
						<RightIcon />
					</span>
				</pagination>
			</div>

			<!-- Pagination -->
			<div class="mt-5 hidden sm:flex">
				<pagination :data="orders" @pagination-change-page="getResults" :limit="2">
					<span slot="prev-nav">
						<LeftIcon />
					</span>
					<span slot="next-nav">
						<RightIcon />
					</span>
				</pagination>
			</div>
		</div>
	</loading>

</template>

<script>
import OrderDetails from "~/components/layouts/OrderDetails.vue";
export default {
	name: "ProfileOrders",
	components: { OrderDetails },
	data() {
		return {
			orders: {},
		};
	},

	computed: {
		ordersStatus() {
			return [
				{
					title: "Total Orders",
					amount: this.orders.data.length,
					url: "/images/icons/total-orders.png",
					textColor: "text-gray-700",
				},
				{
					title: "Delivered",
					amount: this.ordersCount("delivered"),
					url: "/images/icons/orders-delivered.png",
					textColor: "text-green-500",
				},
				{
					title: "Shipped",
					amount: this.ordersCount("shipped"),
					url: "/images/icons/orders-shipped.png",
					textColor: "text-blue-500",
				},
				{
					title: "Pending",
					amount: this.ordersCount("pending"),
					url: "/images/icons/orders-pending.png",
					textColor: "text-yellow-500",
				},
			];
		},
	},

	methods: {
		// Our method to GET results from a Laravel endpoint
		getResults(page = 1) {
			this.$axios.get("/orders?page=" + page).then((response) => {
				this.orders = response.data;
				this.stopLoading();
			});
		},

		ordersCount(status) {
			let ordersStatus = this.orders.data.filter(
				(order) => order.status === status
			);
			return ordersStatus.length;
		},
	},

	created() {
		this.getResults();
	},
};
</script>

<style scoped>
.badge {
	@apply rounded-full px-2 py-0.5 text-xs uppercase;
}

.badge-pending {
	@apply bg-green-500 text-white;
}
</style>
