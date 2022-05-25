<template>

	<index-view title="Refund Requests" :breadcrumb="breadcrumb">
		<datatable :data="refunds" searchRoute="refund-requests.index" :filters="filters">
			<!-- Left Header -->
			<template #left-header>
				<search-input v-model="filters.search"></search-input>
			</template>

			<template #right-header>
				<!-- Fiter -->
				<filter-dropdown v-model="filters" @reset="reset">
					<!-- Filters -->
					<slot name="filter">
						<jet-label class="mb-2 px-2 font-semibold" for="status" value="Status" />
						<jet-select id="status" track="value" v-model="filters.status" class="w-full" :options="statusFilterOptions"></jet-select>
					</slot>
				</filter-dropdown>
			</template>

			<!--Table Rows -->
			<template #default="{rows}">
				<table v-if="rows.length">
					<thead>
						<tr>
							<th>Id</th>
							<th>Invoice</th>
							<th>Date</th>
							<th>Customer Name</th>
							<th> Grand Total</th>
							<th>Status</th>
							<th>Action</th>
						</tr>

					</thead>
					<tbody>
						<tr v-for="(row, index) in rows" :key="index">
							<td>{{row.id}}</td>
							<td>
								<Link class="text-green-500 font-semibold cursor-pointer" :href="route('orders.show', row.order.id)">
								{{row.order.invoiceNo}}
								</Link>
							</td>
							<td>{{row.dateFormatted}}</td>
							<td>{{row.customer.name}}</td>
							<td>{{row.order.grandTotalFormatted}}</td>
							<td>
								<jet-badge :value="row.status"></jet-badge>
							</td>

							<td class="flex">
								<div>
									<Link class="btn btn-success mr-2" title="Details" :href="route('refund-requests.show', row.id)" v-if="$page.props.can.viewAnyRefundRequests">
									<detail-icon></detail-icon>
									</Link>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</template>
			<template #nodata>No Requests Found</template>

		</datatable>
	</index-view>

</template>

<script>
import IndexView from "@/Views/IndexView.vue";
import { Link } from "@inertiajs/inertia-vue3";
import ButtonLink from "@/Jetstream/ButtonLink.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import Datatable from "@/Jetstream/Datatable.vue";
import SearchInput from "@/Jetstream/SearchInput.vue";
import FilterDropdown from "@/Jetstream/FilterDropdown.vue";
import DetailIcon from "@/Icons/DetailIcon.vue";
import JetBadge from "@/Jetstream/Badge.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetSelect from "@/Jetstream/Select";
import JetLabel from "@/Jetstream/Label.vue";
export default {
	name: "refunds",

	props: {
		refunds: Object,
		query: Object,
		statusFilterOptions: Array,
	},

	components: {
		IndexView,
		Link,
		ButtonLink,
		JetDangerButton,
		Datatable,
		SearchInput,
		FilterDropdown,
		DetailIcon,
		JetBadge,
		JetCheckbox,
		JetSelect,
		JetLabel,
	},

	data() {
		return {
			filters: {
				search: this.query.search,
				status: this.query.status,
			},
			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Refund Requests", route: null },
			],
		};
	},
};
</script>
