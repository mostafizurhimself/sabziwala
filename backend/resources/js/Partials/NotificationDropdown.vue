<template>
	<jet-dropdown :width="80">
		<template #trigger>
			<button class="ti-bell px-4 relative text-xl text-gray-800 rounded-full hover:text-primary-500 focus:outline-none focus:text-primary-600 transition duration-150 ease-in-out">
				<span class="bg-primary-500 text-white text-xs absolute w-5 h-5 rounded-full flex items-center justify-center border border-white" style="top:-5px; right: 8px" v-if="length">{{length}}</span>
			</button>
		</template>

		<template #content>
			<!-- Header -->
			<div class="p-3 border-b">
				<div class="flex items-center">
					<p class="font-bold">
						Notifications ({{ notifications.length }})
					</p>
					<span v-if="notifications.length" role="button" @click="markAllAsRead" class="font-semibold ml-auto text-sm text-primary-500 hover:underline hover:text-primary-600">Mark As Read</span>
				</div>
			</div>

			<!-- Notification List -->
			<div style="max-height: 245px; overflow: auto">
				<div v-if="notifications.length">
					<div role="button" class="border-b px-4 py-2 text-sm leading-5 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition" @click="handleClick(notification)" v-for="notification in notifications" :key="notification.id" :class="{'bg-gray-50' : notification.read_at === null}">
						<div class="font-semibold">
							<p class="mb-1" :class="{
								'text-indigo-500': notification.data.type == 'info', 
								'text-green-500': notification.data.type == 'success', 
								'text-yellow-500': notification.data.type == 'warning',
								'text-red-500': notification.data.type == 'danger',
								'font-bold' : notification.read_at === null }">{{ notification.data.title }}</p>
							<p class="text-sm text-gray-500 truncate">
								{{ notification.data.subtitle }}
							</p>
						</div>
					</div>
				</div>
				<div v-else>
					<div class="text-gray-500 text-center w-full py-3 font-semibold border-b">No notifications found</div>
				</div>
			</div>

			<!-- Clear Notification -->
			<div class="p-2 text-center">
				<a class="font-semibold text-sm text-primary-500 hover:text-primary-600 hover:underline" href="javascript:void(0)" @click.prevent="clearAll">Clear All</a>
			</div>
		</template>
	</jet-dropdown>
</template>

<script>
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";
import NotificationIcon from "@/Icons/NotificationIcon.vue";
export default {
	components: {
		JetDropdown,
		JetDropdownLink,
		NotificationIcon,
	},

	data() {
		return {
			notifications: this.$page.props.notifications,
		};
	},

	computed: {
		// Filter unread notifications
		unreadNotifications() {
			return this.notifications.filter(
				(notification) => notification.read_at === null
			);
		},

		// Get the unread notification length
		length() {
			return this.unreadNotifications.length > 9
				? "9+"
				: this.unreadNotifications.length;
		},
	},

	methods: {
		markAllAsRead() {
			this.$inertia.post(
				this.route("notifications.markAllAsRead"),
				null,
				{
					onSuccess: (page) =>
						(this.notifications = this.$page.props.notifications),
				}
			);
		},

		handleClick(notification) {
			this.$inertia.post(
				this.route("notifications.markAsRead", notification.id),
				null,
				{
					onSuccess: (page) =>
						(this.notifications = this.$page.props.notifications),
				}
			);
		},

		clearAll() {
			this.$inertia.delete(this.route("notifications.clearAll"), {
				onSuccess: (page) =>
					(this.notifications = this.$page.props.notifications),
			});
		},
	},

	mounted() {
		// Listen for new notification
		Echo.private(
			"App.Models.User." + this.$page.props.user.id
		).notification((notification) => {
			this.notifications.unshift(notification);
			// console.log(notification);
		});
	},
};
</script>

<style lang="scss" scoped>
</style>