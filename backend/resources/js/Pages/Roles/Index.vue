<template>
	<index-view title="Roles" :breadcrumb="breadcrumb">
		<datatable :data="roles" searchRoute="roles.index" :filters="filters">
			<!-- Left Header -->
			<template #left-header>
				<search-input v-model="filters.search"></search-input>
			</template>

			<template #right-header>

				<!-- Admin -->
				<button-link class="px-6 py-3 ml-4" :href="route('roles.create')" v-if="$page.props.can.createRoles">
					<span class="mr-2">+ Add</span>
					<span class="hidden md:inline">Roles</span>
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
							<td>{{ row.id }}</td>
							<td>{{ row.name }}</td>
							<td class="truncate" style="max-width: 300px">{{ row.description }}</td>

							<td class="flex">

								<div>
									<Link class="btn btn-success mr-2" title="Details" :href="route('roles.show', row.id)" v-if="$page.props.can.viewRoles">
									<detail-icon></detail-icon>
									</Link>
									<Link class="btn btn-purple mr-2" title="Edit" :href="route('roles.edit', row.id)" v-if="$page.props.can.updateRoles">
									<i class="ti-pencil-alt"></i>
									</Link>
									<jet-danger-button title="Delete" @click="deleteResource(route('roles.destroy', row.id))" v-if="$page.props.can.deleteRoles">
										<i class="ti-trash"></i>
									</jet-danger-button>
								</div>

							</td>

						</tr>

					</tbody>
				</table>
			</template>
			<template #nodata>No Roles Found</template>

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
	name: "roles",
	// props: ["sessions"],

	props: {
		roles: Object,
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
				{ label: "Roles", route: null },
			],
		};
	},

	methods: {
		toggleStatus(id) {
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
							this.route("customers.update-status", id)
						);
					}
				});
		},
	},
};
</script>
