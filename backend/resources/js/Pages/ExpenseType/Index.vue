<template>

	<index-view title="Expense Types" :breadcrumb="breadcrumb">
		<datatable :data="expenseTypes" searchRoute="expense-type.index" :filters="filters">
			<!-- Left Header -->
			<template #left-header>
				<search-input v-model="filters.search"></search-input>
			</template>

			<template #right-header>
				<!-- Admin -->
				<button-link class="px-6 py-3 ml-4" :href="route('expense-type.create')" v-if="$page.props.can.createExpenseTypes">
					<span class="mr-2">+ Add</span>
					<span class="hidden md:inline">Expense Type</span>
				</button-link>
			</template>

			<!--Table Rows -->
			<template #default="{rows}">
				<table v-if="rows.length">
					<thead>
						<tr>
							<th>Id</th>
							<th>Name</th>
							<th>Description</th>
							<th>Action</th>
						</tr>

					</thead>
					<tbody>
						<tr v-for="(row, index) in rows" :key="index">
							<td>{{row.id}}</td>
							<td>{{row.name}}</td>
							<td>
								{{row.description}}
							</td>
							<td class="flex">
								<div>
									<Link class="btn btn-purple mr-2" title="Edit" :href="route('expense-type.edit', row.id)" v-if="$page.props.can.updateExpenseTypes">
									<i class="ti-pencil-alt"></i>
									</Link>

									<jet-danger-button title="Delete" @click="deleteResource(route('expense-type.destroy', row.id))" v-if="$page.props.can.deleteExpenseTypes">
										<i class="ti-trash"></i>
									</jet-danger-button>

								</div>
							</td>

						</tr>

					</tbody>
				</table>
			</template>
			<template #nodata>No Expense Types Found</template>

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
export default {
	name: "Expense Types",

	props: {
		expenseTypes: Object,
		query: Object,
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
	},

	data() {
		return {
			filters: {
				search: this.query.search,
			},
			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Expense Types", route: null },
			],
		};
	},
};
</script>
