<template>
	<form-view @submitted="update('users.update', user.id)" title="Edit User" :breadcrumb="breadcrumb">
		<template #form>
			<!-- Name -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="name" value="Name" required />
				<div class="w-full mt-1">
					<jet-input v-model="form.name" id="name" type="text" class="w-full" autocomplete="name" />
					<jet-input-error :message="form.errors.name" class="mt-2" />
				</div>
			</form-group>
			<!-- Email -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="email" value="Email" required />
				<div class="w-full mt-1">
					<jet-input v-model="form.email" id="email" type="email" class="w-full" autocomplete="email" />
					<jet-input-error :message="form.errors.email" class="mt-2" />
				</div>
			</form-group>

			<!-- Role -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="role" value="Role" required />
				<div class="w-full mt-1">
					<jet-select v-model="form.role" id="role" class="w-full" :options="roles" autocomplete="role" />
					<jet-input-error :message="form.errors.role" class="mt-2" />
				</div>
			</form-group>

			<!-- Password -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="password" value="Password" />
				<div class="w-full mt-1">
					<jet-input v-model="form.password" id="password" type="password" class="w-full" autocomplete="password" />
					<jet-input-error :message="form.errors.password" class="mt-2" />
				</div>
			</form-group>

			<!-- Confirm Password -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="password_confirmation" value="Confirm Password" />
				<div class="w-full mt-1">
					<jet-input v-model="form.password_confirmation" id="password_confirmation" type="password" class="w-full" autocomplete="password_confirmation" />
					<jet-input-error :message="form.errors.password_confirmation" class="mt-2" />
				</div>
			</form-group>
		</template>

		<template #actions>
			<Link :href="route('users.index')" class="xs:mr-4">Cancel</Link>
			<jet-button @click.prevent="update('users.update', user.id, true)" class="px-6 xs:mr-2 my-2 xs:my-0" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Update & Continue</jet-button>
			<jet-button class="px-6" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Update</jet-button>
		</template>
	</form-view>

</template>

<script>
import FormView from "@/Views/FormView.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetSelect from "@/Jetstream/Select.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetTextInput from "@/Jetstream/TextInput.vue";
import JetButton from "@/Jetstream/Button.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";

export default {
	name: "create-user",
	props: {
		user: Object,
		roles: Array,
	},

	components: {
		Link,
		FormView,
		JetInput,
		JetSelect,
		JetInputError,
		JetLabel,
		JetTextInput,
		FormGroup,
		JetButton,
	},
	data() {
		return {
			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Users", route: this.route("users.index") },
				{
					label: this.user.name,
					route: this.route("users.show", this.user.id),
				},
				{ label: "Edit", route: null },
			],

			form: this.$inertia.form({
				name: this.user.name,
				email: this.user.email,
				role: this.user.role.id,
				password: null,
				password_confirmation: null,
			}),

			rowItems: [],
		};
	},
};
</script>
