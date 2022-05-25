<template>
	<div>
		<!-- Refund history -->
		<div class="flex items-center justify-between pb-5 border-b border-gray-200 w-full">
			<h5 class="font-semibold md:text-xl">Refund History</h5>
			<!-- Refund Request Modal -->
			<modal-comp headerText="Refund request" :maxWidth="600" class="ml-2">
				<template #button>
					<button-field label="New Refund Request"></button-field>
				</template>
				<template #modal-body="{toggle}">
					<RefundRequestModal @close="toggle()" @success="getResults"></RefundRequestModal>
				</template>
			</modal-comp>
		</div>

		<!-- single history -->
		<loading :loading="isLoading">
			<div class="flex py-4 justify-between border-b border-gray-200" v-for="refund in refunds.data" :key="refund.id">
				<div class="">
					<h6 class="font-semibold">
						Request For Order No
						<span class="mr4-">#{{refund.order.invoiceNo}}</span>
						<span class="text-xs text-gray-400 font-normal whitespace-nowrap">{{refund.dateFormatted}}</span>
					</h6>
					<span class="text-sm text-gray-500 mt-2">
						<truncate :value="refund.reason"></truncate>
					</span>
					<span v-if="refund.status == 'pending'" @click="cancelRequest(refund.id)" class="text-sm font-medium cursor-pointer text-primary-500 hover:underline mt-2">Cancel Request</span>
				</div>
				<!-- adding balance amount -->
				<div class="flex flex-col font-semibold text-right ml-5">
					<p class="text-lg whitespace-nowrap">{{currencyFormat(refund.order.grandTotal)}}</p>
					<p class="mt-auto">
						<the-badge :value="refund.status"></the-badge>
					</p>
				</div>
			</div>
		</loading>

		<!-- Mobile Pagination -->
		<div class="mt-5 flex sm:hidden">
			<pagination :data="refunds" @pagination-change-page="getResults" :limit="-1">
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
			<pagination :data="refunds" @pagination-change-page="getResults" :limit="2">
				<span slot="prev-nav">
					<LeftIcon />
				</span>
				<span slot="next-nav">
					<RightIcon />
				</span>
			</pagination>
		</div>
	</div>
</template>

<script>
import RefundRequestModal from "~/components/layouts/RefundRequestModal.vue";
import Truncate from "~/components/shared/Truncate.vue";
export default {
	name: "ProfileWallet",
	components: { RefundRequestModal, Truncate },
	data() {
		return {
			refunds: {},
		};
	},
	methods: {
		// Our method to GET results from a Laravel endpoint
		getResults(page = 1) {
			this.$axios
				.get("/customer/refund-requests?page=" + page)
				.then((response) => {
					this.refunds = response.data;
					this.stopLoading();
				});
		},

		// Confirm to delete the refund request
		cancelRequest(id) {
			this.$swal
				.fire({
					title: "Are you sure?",
					text: "You won't be able to revert this!",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#10B981",
					cancelButtonColor: "#d33",
					confirmButtonText: "Yes, cancel it!",
				})
				.then((result) => {
					if (result.isConfirmed) {
						this.cancel(id);
					}
				});
		},

		// Delete the refund request
		async cancel(id) {
			try {
				const response = await this.$axios.$delete(
					`/customer/refund-requests/${id}`
				);
				this.getResults();
				this.$toast.success("Refund request canceled.");
			} catch (error) {
				console.error(error);
			}
		},
	},

	created() {
		this.getResults();
	},
};
</script>

<style lang="scss">
</style>