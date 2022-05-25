<template>

	<index-view title="Users" :breadcrumb="breadcrumb">
		<datatable :data="users" searchRoute="users.index" :filters="filters">
			<!-- Left Header -->
			<template #left-header>
				<search-input v-model="filters.search"></search-input>
			</template>

			<template #right-header>
				<!-- Admin -->
				<button-link class="px-6 py-3 ml-4" :href="route('users.create')" v-if="$page.props.can.createUsers">
					<span class="mr-2">+ Add</span>
					<span class="hidden md:inline">users</span>
				</button-link>
			</template>

			<!--Table Rows -->
			<template #default="{rows}">
				<table v-if="rows.length">
					<thead>
						<tr>
							<th>Id</th>
							<th>Name</th>
							<th>Email</th>
							<th>Role</th>
							<th>Action</th>
						</tr>

					</thead>
					<tbody>
						<tr v-for="(row, index) in rows" :key="index">
							<td>{{ row.id }}</td>
							<td>{{ row.name }}</td>
							<td>
								<a class="text-blue-500" :href="`mailto:${row.email}`">{{row.email}}</a>
							</td>
							<td>
								<span class="badge bg-yellow-500">{{row.role.name}}</span>
							</td>

							<td class="flex">

								<div>
									<Link class="btn btn-success mr-2" title="Details" :href="route('users.show', row.id)" v-if="$page.props.can.viewUsers">
									<detail-icon></detail-icon>
									</Link>

									<Link class="btn btn-purple mr-2" title="Edit" :href="route('users.edit', row.id)" v-if="$page.props.can.updateUsers">
									<i class="ti-pencil-alt"></i>
									</Link>

									<jet-danger-button title="Delete" @click="deleteResource(route('users.destroy', row.id))" v-if="$page.props.can.deleteUsers">
										<i class="ti-trash"></i>
									</jet-danger-button>

								</div>

							</td>

						</tr>

					</tbody>
				</table>
			</template>
			<template #nodata>No users Found</template>

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
	name: "Users",

	props: {
		users: Object,
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
				{ label: "Users", route: null },
			],
		};
	},
};
</script>
