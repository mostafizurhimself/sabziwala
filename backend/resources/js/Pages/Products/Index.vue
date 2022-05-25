<template>

	<index-view title="Products" :breadcrumb="breadcrumb">
		<datatable :data="products" searchRoute="products.index" :filters="filters">
			<!-- Left Header -->
			<template #left-header>
				<search-input v-model="filters.search"></search-input>
			</template>

			<template #right-header>
				<!-- Fiter -->
				<filter-dropdown v-model="filters" @reset="reset">
					<slot name="filter">
						<jet-label class="my-2 px-2 font-semibold" for="status" value="Status" />
						<jet-select id="status" track="value" v-model="filters.status" class="w-full" :options="status"></jet-select>

						<jet-label class="my-2 px-2 font-semibold" for="featured" value="Featured" />
						<jet-select id="featured" track="value" v-model="filters.featured" class="w-full" :options="featured"></jet-select>

						<jet-label class="px-2 my-2 font-semibold" for="zoneId" value="Zone" />
						<searchable-select :options="zones" v-model="filters.zone" autoFocus></searchable-select>
					</slot>

				</filter-dropdown>

				<!-- Admin -->
				<button-link class="px-6 py-3 ml-4" :href="route('products.create')" v-if="$page.props.can.createProducts">
					<span class="mr-2">+ Add</span>
					<span class="hidden md:inline">Product</span>
				</button-link>
			</template>

			<!--Table Rows -->
			<template #default="{rows}">
				<table v-if="rows.length">
					<thead>
						<tr>
							<th>Id</th>
							<th>Product</th>

							<th>Code</th>
							<th>Zone</th>
							<th>Price</th>
							<th>Status</th>
							<th>Featured</th>
							<th>Action</th>
						</tr>

					</thead>
					<tbody>
						<tr v-for="(row, index) in rows" :key="index">
							<td>{{row.id}}</td>
							<td>
								<div class="flex">
									<div class="w-10 h-10 mr-4">
										<img :src="row.thumbnailMediaUrl" class="w-100 object-cover">
									</div>
									<div>
										<p class="text-sm text-gray-500">{{row.category.name}}</p>
										<p>{{row.name}}</p>
									</div>
								</div>
							</td>
							<td>{{row.code}}</td>
							<td>{{row.zone.name}}</td>
							<td>{{row.salePriceFormatted}}</td>
							<td>
								<jet-badge :value="row.status"></jet-badge>
							</td>
							<td>
								<span class="text-gray-700" v-if="row.isFeatured == '0'">No</span>
								<span class="text-green-500" v-else>Yes</span>
							</td>

							<td class="flex">
								<div>
									<Link class="btn btn-success mr-2" title="Details" :href="route('products.show', row.id)" v-if="$page.props.can.viewProducts">
									<detail-icon></detail-icon>
									</Link>

									<Link class="btn btn-purple mr-2" title="Edit" :href="route('products.edit', row.id)" v-if="$page.props.can.updateProducts">
									<i class="ti-pencil-alt"></i>
									</Link>

									<jet-danger-button title="Delete" @click="deleteResource(route('products.destroy', row.id))" v-if="$page.props.can.deleteProducts">
										<i class="ti-trash"></i>
									</jet-danger-button>

								</div>
							</td>

						</tr>

					</tbody>
				</table>
			</template>
			<template #nodata>No Products Found</template>

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
import JetLabel from "@/Jetstream/Label.vue";
import JetSelect from "@/Jetstream/Select";
import SearchableSelect from "@/Jetstream/SearchableSelect";
import VerifiedIcon from "@/Icons/VerifiedIcon.vue";
import UnverifiedIcon from "@/Icons/UnverifiedIcon.vue";

export default {
	name: "products",

	props: {
		products: Object,
		query: Object,
		status: Array,
		zones: Array,
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
		JetSelect,
		JetLabel,
		SearchableSelect,
		VerifiedIcon,
		UnverifiedIcon,
	},

	data() {
		return {
			filters: {
				search: this.query.search,
				status: this.query.status,
				zone: this.query.zone,
				featured: this.query.featured,
			},

			featured: [
				{ value: 1, name: "Featured" },
				{ value: 0, name: "Not Featured" },
			],

			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Products", route: null },
			],
		};
	},
};
</script>
