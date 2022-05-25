<template>
	<detail-view title="User Details" :breadcrumb="breadcrumb">

		<!-- ID -->
		<detail-section class="border-b" label="ID" :value="user.id"></detail-section>

		<!-- Name -->
		<detail-section class="border-b" label="Name" :value="user.name"></detail-section>

		<!-- Email -->
		<detail-section class="border-b" label="Email">
			<a class="text-blue-500" :href="`mailto:${user.email}`">{{user.email}}</a>
		</detail-section>

		<!-- Role -->
		<detail-section label="Role" :value="user.role.name"></detail-section>

	</detail-view>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import DetailView from "@/Views/DetailView.vue";
import DetailSection from "@/Jetstream/DetailSection.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Tabs, Tab } from "vue3-tabs-component";

export default {
	name: "user-details",
	// props: ["sessions"],
	props: {
		user: Object,
	},

	components: {
		AppLayout,
		DetailView,
		DetailSection,
		Link,
		Tabs,
		Tab,
	},

	data() {
		return {
			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Users", route: this.route("users.index") },
				{ label: this.user.name, route: null },
			],
		};
	},
};
</script>
