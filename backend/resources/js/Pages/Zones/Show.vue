<template>
	<detail-view title="Zone Details" :breadcrumb="breadcrumb">
		<!-- ID -->
		<detail-section class="border-b" label="ID" :value="zone.id"></detail-section>

		<!-- Name -->
		<detail-section class="border-b" label="Zone Name" :value="zone.name"></detail-section>

		<!-- City -->
		<detail-section class="border-b" label="City" :value="zone.city"></detail-section>

		<!-- State -->
		<detail-section class="border-b" label="State" :value="zone.state"></detail-section>

		<!-- Zipcode -->
		<detail-section class="border-b" label="Zipcode" :value="zone.zipcode"></detail-section>

		<!-- Country -->
		<detail-section class="border-b" label="Country" :value="zone.country"></detail-section>
	</detail-view>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import DetailView from "@/Views/DetailView.vue";
import DetailSection from "@/Jetstream/DetailSection.vue";
import { Link } from "@inertiajs/inertia-vue3";
export default {
	name: "zone-details",
	props: {
		zone: Object,
	},

	components: {
		AppLayout,
		DetailView,
		DetailSection,
		Link,
	},

	data() {
		return {
			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Zones", route: this.route("zones.index") },
				{ label: this.zone.name, route: null },
			],
		};
	},
};
</script>

<style lang="scss" scoped>
</style>
