<template>
	<detail-view title="Rider Details" :breadcrumb="breadcrumb">

		<tabs :options="{ useUrlFragment: false }">
			<tab name="Profile">
				<!-- ID -->
				<detail-section class="border-b" label="ID" :value="rider.id"></detail-section>
				<!-- Zone -->
				<detail-section class="border-b" label="Zone" :value="rider.zone.name"></detail-section>
				<!-- Name -->
				<detail-section class="border-b" label="Name" :value="rider.name"></detail-section>

				<!-- Email -->
				<detail-section class="border-b" label="Email">
					<a class="text-blue-500" :href="`mailto:${rider.email}`">{{rider.email}}</a>
				</detail-section>

				<!-- Phone -->
				<detail-section class="border-b" label="Phone">
					<a class="text-blue-500" :href="`tel:${rider.phone}`">{{rider.phone}}</a>
				</detail-section>

				<!-- Last Login -->
				<detail-section class="border-b" label="Last Login">
					<a class="text-blue-500" :href="`tel:${rider.lastLoginForHuman}`">{{rider.lastLoginForHuman}}</a>
				</detail-section>

				<!-- Verified -->
				<detail-section class="border-b" label="Verified">
					<unverified-icon class="text-primary-500" v-if="rider.verified == '0'"></unverified-icon>
					<verified-icon class="text-green-500" v-else></verified-icon>
				</detail-section>

				<!-- Status-->
				<detail-section label="Status">
					  <jet-badge :value="rider.status"></jet-badge>
				</detail-section>
			</tab>

			<tab name="Others">
				<!-- Profile Photo -->
				<detail-section class="border-b" label="Profile Photo">
					<image-preview :url="rider.profilePhotoUrl"></image-preview>
				</detail-section>

				<!-- Verification Front -->
				<detail-section class="border-b">
					<template #label>
						<h6>Front Side</h6>
						<p class="text-xs text-gray-600">NID/Passport/Driving License</p>
					</template>
					<image-preview :url="rider.verificationFrontUrl"></image-preview>
				</detail-section>

				<!-- Verification Back -->
				<detail-section class="border-b">
					<template #label>
						<h6>Back Side</h6>
						<p class="text-xs text-gray-600">NID/Passport/Driving License</p>
					</template>
					<image-preview :url="rider.verificationBackUrl"></image-preview>
				</detail-section>

				<!-- Present Address -->
				<detail-section class="border-b" label="Present Address">
					<p class="text-90" v-if="rider.presentAddress">{{ rider.presentAddress.street }}, {{ rider.presentAddress.state }}, {{ rider.presentAddress.city }}, {{ rider.presentAddress.country }} - {{ rider.presentAddress.zipcode }}</p>
					<p v-else>-</p>
				</detail-section>

				<!-- Permanent Address -->
				<detail-section class="border-b" label="Permanent Address">
					<p class="text-90" v-if="rider.permanentAddress">{{ rider.permanentAddress.street }}, {{ rider.permanentAddress.state }}, {{ rider.permanentAddress.city }}, {{ rider.permanentAddress.country }} - {{ rider.permanentAddress.zipcode }}</p>
					<p v-else>-</p>
				</detail-section>

				<!-- Verification -->
				<detail-section label="Verification">
					<button class="btn mr-2" :class="{'btn-danger' : rider.verified == true, 'btn-success': rider.verified == false}" @click="toggleVerified(rider.id)">

						<div class="flex items-center" v-if="rider.verified == '0'">
							<verified-icon></verified-icon>
							<span class="ml-2">Verify</span>
						</div>

						<div class="flex items-center" v-else>
							<unverified-icon></unverified-icon>
							<span class="ml-2">Unverify</span>
						</div>
					</button>
				</detail-section>

			</tab>
		</tabs>

	</detail-view>
</template>

<script>
import MultipleImagePreview from "@/Partials/MultipleImagePreview.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import DetailView from "@/Views/DetailView.vue";
import DetailSection from "@/Jetstream/DetailSection.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Tabs, Tab } from "vue3-tabs-component";
import ImagePreview from "@/Partials/ImagePreview.vue";
import VerifiedIcon from "@/Icons/VerifiedIcon.vue";
import UnverifiedIcon from "@/Icons/UnverifiedIcon.vue";
import JetBadge from "@/Jetstream/Badge.vue";

export default {
	name: "rider-details",
	props: {
		rider: Object,
	},

	components: {
		AppLayout,
		DetailView,
		DetailSection,
		Link,
		Tabs,
		Tab,
		ImagePreview,
		MultipleImagePreview,
		VerifiedIcon,
		UnverifiedIcon,
        JetBadge,
	},

	data() {
		return {
			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Riders", route: this.route("riders.index") },
				{ label: this.rider.name, route: null },
			],
		};
	},

	methods: {
		toggleVerified(id) {
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
						this.$inertia.post(this.route("riders.verified", id));
					}
				});
		},
	},
};
</script>
