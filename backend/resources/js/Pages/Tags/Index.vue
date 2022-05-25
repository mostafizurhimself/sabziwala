<template>

	<index-view title="Tags" :breadcrumb="breadcrumb">
		<datatable :data="tags" searchRoute="tags.index" :filters="filters">
			<!-- Left Header -->
			<template #left-header>
				<search-input v-model="filters.search"></search-input>
			</template>

			<template #right-header>
				<!-- Fiter -->
				<filter-dropdown>
					<slot name="filter"></slot>
				</filter-dropdown>

				<!-- Admin -->
				<button-link class="px-6 py-3 ml-4" :href="route('tags.create')" v-if="$page.props.can.createTags">
					<span class="mr-2">+ Add</span>
					<span class="hidden md:inline">Tag</span>
				</button-link>
			</template>

			<!--Table Rows -->
			<template #default="{rows}">
				<table v-if="rows.length">
					<thead>
						<tr>
							<th>Id</th>
							<th>Name</th>
							<th>Action</th>
						</tr>

					</thead>
					<tbody>
						<tr v-for="(row, index) in rows" :key="index">
							<td>{{row.id}}</td>
							<td>{{row.name}}</td>

							<td class="flex">
								<div>
									<Link class="btn btn-purple mr-2" :href="route('tags.edit', row.id)" v-if="$page.props.can.updateTags" >
									<i class="ti-pencil-alt"></i>
									</Link>

									<jet-danger-button @click="deleteResource(route('tags.destroy', row.id))" v-if="$page.props.can.deleteTags">
										<i class="ti-trash"></i>
									</jet-danger-button>

								</div>
							</td>

						</tr>

					</tbody>
				</table>
			</template>
			<template #nodata>No Tags Found</template>

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
	name: "tags",

	props: {
		tags: Object,
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
				{ label: "Tags", route: null },
			],
		};
	},
};
</script>
