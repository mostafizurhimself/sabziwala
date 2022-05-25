<template>
	<form-view @submitted="update('categories.update', category.id)" title="Edit Category" :breadcrumb="breadcrumb">
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
				<div class="w-full mt-1">
					<jet-text-input v-model="form.description" id="name" type="text" class="mt-1 block w-full" autocomplete="name" />
					<jet-input-error class="mt-2" />
				</div>
			</form-group>

			<!-- Image -->
			<form-group>
				<jet-label for="image" class="md:w-1/4 mt-2" value="Image" />
				<div class="w-full mt-1">
					<jet-image-input :url="category.primaryMediaUrl" v-model="form.image"></jet-image-input>
                     <small class="mt-1 font-thin text-gray-400">* Image should be 1:1 acpect ratio. Maximum file size: 5MB(5120KB).</small>
					<jet-input-error :message="form.errors.image" class="mt-2" />
				</div>
			</form-group>

		</template>

		<template #actions>
			<Link :href="route('categories.index')" class="xs:mr-4">Cancel</Link>
			<jet-button @click.prevent="update('categories.update', category.id, true)" class="px-6 xs:mr-2 my-2 xs:my-0" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Update & Continue</jet-button>
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
import JetImageInput from "@/Jetstream/ImageInput.vue";

export default {
	name: "edit-category",
	props: {
		category: Object,
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
		JetImageInput,
	},
	data() {
		return {
			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Categories", route: this.route("categories.index") },
				{ label: "Edit", route: null },
			],

			form: this.$inertia.form({
				name: this.category.name,
				description: this.category.description,
				image: null,
			}),

		};
	},
};
</script>
