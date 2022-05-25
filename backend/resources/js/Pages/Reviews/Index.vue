<template>

	<index-view title="Reviews" :breadcrumb="breadcrumb">
		<datatable :data="reviews" searchRoute="reviews.index" :filters="filters">
			<!-- Left Header -->
			<template #left-header>
				<search-input v-model="filters.search"></search-input>
			</template>

			<template #right-header>
				<!-- Fiter -->
				<!-- Filters -->
				<filter-dropdown v-model="filters" @reset="reset">
					<slot name="filter">
						<jet-label class="mb-2 px-2 font-semibold" for="status" value="Status" />
						<jet-select id="status" track="value" v-model="filters.status" class="w-full" :options="status"></jet-select>
					</slot>
				</filter-dropdown>

				<!-- Admin -->

			</template>

			<!--Table Rows -->
			<template #default="{rows}">
				<table v-if="rows.length">
					<thead>
						<tr>
							<th>Id</th>
							<th>Date</th>
							<th>Product Name</th>
							<th>Customer Name</th>
							<th>Rating</th>
							<th>Comment</th>
							<th>Approved</th>
							<th>Action</th>
						</tr>

					</thead>
					<tbody>
						<tr v-for="(row, index) in rows" :key="index">
							<td>{{row.id}}</td>
							<td>{{row.dateFormatted}}</td>
							<td>{{row.reviewrateable?.name}}</td>
							<td>{{row.author?.name}}</td>
							<td>{{row.rating}}</td>
							<td class="truncate" style="max-width:250px">{{row.body}}</td>
							<td>
								<unverified-icon class="text-primary-500" v-if="row.approved == '0'"></unverified-icon>
								<verified-icon class="text-green-500" v-else></verified-icon>
							</td>

							<td class="flex">
								<div v-if="$page.props.can.updateRiders">
									<button class="btn mr-2" title="Toggle Approved" :class="{'btn-danger' : row.approved == true, 'btn-success': row.approved == false}" @click="toggleApproved(row.id)">
										<active-icon v-if="row.approved == '0'"></active-icon>
										<inactive-icon v-else></inactive-icon>
									</button>
								</div>

								<div>
									<Link class="btn btn-success" title="Details" :href="route('reviews.show', row.id)" v-if="hasPermissions(['viewReviews'])">
									<detail-icon></detail-icon>
									</Link>

								</div>
							</td>

						</tr>

					</tbody>
				</table>
			</template>
			<template #nodata>No Reviews Found</template>

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
import VerifiedIcon from "@/Icons/VerifiedIcon.vue";
import UnverifiedIcon from "@/Icons/UnverifiedIcon.vue";
import ActiveIcon from "@/Icons/ActiveIcon.vue";
import InactiveIcon from "@/Icons/InactiveIcon.vue";
import JetSelect from "@/Jetstream/Select";
import JetLabel from "@/Jetstream/Label.vue";
export default {
	name: "Reviews",

	props: {
		reviews: Object,
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
		VerifiedIcon,
		UnverifiedIcon,
		ActiveIcon,
		InactiveIcon,
		JetSelect,
		JetLabel,
	},

	data() {
		return {
			filters: {
				search: this.query.search,
				status: this.query.status,
			},

			status: [
				{ value: 1, name: "Approved" },
				{ value: 0, name: "Unapproved" },
			],

			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Reviews", route: null },
			],
		};
	},

	methods: {
		toggleApproved(id) {
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
						this.$inertia.post(this.route("reviews.approved", id));
					}
				});
		},
	},
};
</script>
