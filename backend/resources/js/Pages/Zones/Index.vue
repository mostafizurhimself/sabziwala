<template>

	<index-view title="Zones" :breadcrumb="breadcrumb">
		<datatable :data="zones" searchRoute="zones.index" :filters="filters">
			<!-- Left Header -->
			<template #left-header>
				<search-input v-model="filters.search"></search-input>
			</template>

			<template #right-header>
				<!-- Downloads -->
				<download-dropdown class="mr-4">
					<pdf-download-button :href="route('zones.pdf', searchQuery)"></pdf-download-button>
					<excel-download-button :href="route('zones.excel', searchQuery)"></excel-download-button>
				</download-dropdown>

				<!-- Fiter -->
				<filter-dropdown v-model="filters" @reset="reset">
					<slot name="filter">
						<jet-label class="mb-2 px-2 font-semibold" for="country" value="Country" />
						<jet-select id="country" track="name" v-model="filters.country" class="w-full" :options="countries"></jet-select>
					</slot>
				</filter-dropdown>

				<!-- Admin -->
				<button-link class="px-6 py-3 ml-4" :href="route('zones.create')" v-if="$page.props.can.createZones">
					<span class="mr-2">+ Add</span>
					<span class="hidden md:inline">Zone</span>
				</button-link>
			</template>

			<!--Table Rows -->
			<template #default="{rows}">
				<table v-if="rows.length">
					<thead>
						<tr>
							<th>Id</th>
							<th>Name</th>
							<th>City</th>
							<th>State</th>
							<th>Country</th>
							<th>Action</th>
						</tr>

					</thead>
					<tbody>
						<tr v-for="(row, index) in rows" :key="index">
							<td>{{row.id}}</td>
							<td>{{row.name}}</td>
							<td>{{row.city}}</td>
							<td>{{row.state}}</td>
							<td>{{row.country}} </td>

							<td class="flex">
								<div>
									<Link class="btn btn-success mr-2" title="Details" :href="route('zones.show', row.id)" v-if="$page.props.can.viewZones">
									<detail-icon></detail-icon>
									</Link>

									<Link class="btn btn-purple mr-2" title="Edit" :href="route('zones.edit', row.id)" v-if="$page.props.can.updateZones">
									<i class="ti-pencil-alt"></i>
									</Link>

									<jet-danger-button title="Delete" @click="deleteResource(route('zones.destroy', row.id))" v-if="$page.props.can.deleteZones">
										<i class="ti-trash"></i>
									</jet-danger-button>

								</div>
							</td>

						</tr>

					</tbody>
				</table>
			</template>
			<template #nodata>No Zone Found</template>

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
import JetSelect from "@/Jetstream/Select";
import JetInput from "@/Jetstream/Input";
import JetLabel from "@/Jetstream/Label.vue";
import DownloadDropdown from "@/Jetstream/DownloadDropdown.vue";
import ExcelDownloadButton from "@/Jetstream/ExcelDownloadButton.vue";
import PdfDownloadButton from "@/Jetstream/PdfDownloadButton.vue";
export default {
	name: "zones",

	props: {
		zones: Object,
		query: Object,
		countries: Array,
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
		JetSelect,
		JetInput,
		JetLabel,
		DownloadDropdown,
		ExcelDownloadButton,
		PdfDownloadButton,
	},

	data() {
		return {
			filters: {
				search: this.query.search,
			},
			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Zones", route: null },
			],
		};
	},
};
</script>
