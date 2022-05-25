<template>
	<form-view @submitted="save('categories.store')" title="Create Category" :breadcrumb="breadcrumb">
		<template #form>
			<!-- Name -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="name" value="Name" required />
				<div class="w-full mt-1">
					<jet-input v-model="form.name" id="name" type="text" class="w-full" autocomplete="name" />
					<jet-input-error :message="form.errors.name" class="mt-2" />
				</div>
			</form-group>

			<!--  Description -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="name" value=" Description" />
				<div class="w-full">
					<jet-text-input v-model="form.description" id="name" type="text" class="mt-1 block w-full" autocomplete="name" />
					<jet-input-error class="mt-2" />
				</div>

			</form-group>

			<!-- Image -->
			<form-group>
				<jet-label for="image" class="md:w-1/4 mt-2" value="Image" />
				<div class="w-full mt-1">
					<jet-image-input v-model="form.image"></jet-image-input>
					<small class="mt-1 font-thin text-gray-400">* Image should be 1:1 acpect ratio. Maximum file size: 5MB/5120KB.</small>
					<jet-input-error :message="form.errors.image" class="mt-2" />
				</div>
			</form-group>

		</template>

		<template #actions>
			<Link :href="route('categories.index')" class="xs:mr-4">Cancel</Link>
			<jet-button @click.prevent="save('categories.store', true)" class="px-6 xs:mr-2 my-2 xs:my-0" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save & Continue</jet-button>
			<jet-button class="px-6" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save</jet-button>
		</template>
	</form-view>

</template>

<script>
import FormView from "@/Views/FormView.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetImageInput from "@/Jetstream/ImageInput.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetTextInput from "@/Jetstream/TextInput.vue";
import JetButton from "@/Jetstream/Button.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";

export default {
	name: "create-user",

	components: {
		Link,
		FormView,
		JetInput,
		JetInputError,
		JetLabel,
		JetTextInput,
		FormGroup,
		JetButton,
		JetImageInput,
	},
	data() {
		return {
			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Categories", route: this.route("categories.index") },
				{ label: "Create", route: null },
			],

			form: this.$inertia.form({
				name: null,
				description: null,
				image: null,
			}),
		};
	},
};
</script>
