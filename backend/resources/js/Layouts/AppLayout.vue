<template>
	<div class="overlay h-screen w-full lg:hidden" v-if="!collapsed" @click="$store.dispatch('setCollapsed', true)"></div>
	<div class="flex">
		<sidebar :key="$page.url" :collapsed="collapsed"></sidebar>
		<div class="flex-grow overflow-x-hidden">

			<Head :title="title" />
			<div class="min-h-screen bg-gray-100">
				<nav class="bg-white border-b border-gray-100 shadow-md">
					<!-- Primary Navigation Menu -->
					<div class="px-8">
						<div class="flex justify-between h-20 items-center">
							<!-- left content -->
							<div class="items-center flex">
								<menu-icon class="cursor-pointer" @click="toggleSidebar"></menu-icon>
							</div>

							<!-- Right content -->
							<div class="flex items-center ml-6">
								<!-- Notification Dropdown -->
								<notification-dropdown class="mr-3"></notification-dropdown>
								<!-- Settings Dropdown -->
								<settings-dropdown></settings-dropdown>
							</div>

						</div>
					</div>
				</nav>

				<!-- Page Content -->
				<main class="px-4 sm:px-6 lg:px-8 py-8  overflow-y-auto w-full" style="height: calc(100vh - 100px);" scroll-region>
					<jet-banner />
					<slot></slot>
				</main>
			</div>
		</div>
	</div>
</template>

<script>
import Sidebar from "@/Partials/Sidebar.vue";
import NotificationDropdown from "@/Partials/NotificationDropdown.vue";
import JetBanner from "@/Jetstream/Banner.vue";
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import MenuIcon from "@/Icons/MenuIcon.vue";
import SettingsDropdown from "@/Partials/SettingsDropdown.vue";

export default {
	name: "AppLayout",
	props: {
		title: String,
	},

	components: {
		Head,
		JetBanner,
		JetDropdown,
		JetDropdownLink,
		JetResponsiveNavLink,
		Link,
		Sidebar,
		MenuIcon,
		NotificationDropdown,
		SettingsDropdown,
	},

	computed: {
		collapsed() {
			return this.$store.state.isCollapsed;
		},
	},
	mounted() {
		// Hide Sidebar menu in Medium device
		this.handleResize();
		// Handle Window Resize
		window.addEventListener("resize", this.handleResize);
	},
	destroyed() {
		window.removeEventListener("resize", this.handleResize);
	},

	methods: {
		handleResize() {
			const baseWidth = 1024;
			if (window.innerWidth <= baseWidth) {
				this.$store.dispatch("setCollapsed", true);
			}
		},

		toggleSidebar() {
			this.$store.dispatch("toggleCollapsed");
		},
	},
};
</script>

<style lang="scss">
@import "vue-next-select/dist/index.css";

.vue-select {
	// width: 100%;
	// border-radius: 20px;
	@apply w-full px-4 border-gray-300  focus:ring-0  rounded-primary shadow-sm;
}

.vue-select[aria-expanded="true"].direction-bottom {
	border-bottom-left-radius: 20px;
	border-bottom-right-radius: 20px;
}

.vue-input {
	padding: 10px;
}

.vue-dropdown {
	border-radius: 20px !important;
}

.vue-dropdown li {
	padding-left: 20px;
}

.vue-dropdown li:hover {
	color: white;
}

.vue-tag.selected {
	background-color: transparent;
}

.vue-tag.selected {
	div {
		@apply px-4 rounded-primary;
	}
}
</style>

