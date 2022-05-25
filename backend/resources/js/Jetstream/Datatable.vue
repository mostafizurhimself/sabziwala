<template>
	<div>
		<!-- search & add product -->
		<div class="flex flex-col md:flex-row justify-between md:items-center mb-4">
			<div>
				<slot name="left-header"></slot>
			</div>

			<!-- Filter -->
			<div class="flex justify-between mt-4 md:mt-0 ">
				<slot name="right-header"></slot>
			</div>

		</div>

		<!-- Table section -->
		<div class="bg-white rounded-primary shadow overflow-x-auto">
			<slot :rows="data.data" v-if="data.data.length"></slot>
			<div class="flex justify-center items-center text-gray-600 h-32" v-else>
				<span>
					<slot name="nodata">No Data Found</slot>
				</span>
			</div>
		</div>

		<div class="flex flex-col sm:flex-row justify-between items-center mt-6" v-if="data.data.length">
			<div class="text-gray-600 text-sm mb-4 sm:mb-0">Showing {{data.from}}-{{data.to}} of {{data.total}} data</div>
			<jet-pagination :links="data.links" />
		</div>
	</div>
</template>

<script>
import pickBy from "lodash/pickBy";
import mapValues from "lodash/mapValues";
import throttle from "lodash/throttle";
import JetPagination from "@/Jetstream/Pagination.vue";

export default {
	props: {
		data: {
			type: Object,
			required: true,
		},
		searchRoute: {
			type: String,
			default: "",
		},
		filters: {
			type: Object,
			default: () => {},
		},
	},
	components: {
		JetPagination,
	},

	watch: {
		filters: {
			handler: throttle(function () {
				this.getResults(this.searchRoute);
			}, 150),
			deep: true,
		},
	},
	methods: {
		// Get filtered data
		getResults(route) {
			this.$inertia.get(this.route(route), pickBy(this.filters), {
				preserveState: true,
			});
		},
	},
};
</script>

<style lang="scss">
</style>
