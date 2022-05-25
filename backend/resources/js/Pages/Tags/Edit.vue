<template>
	<form-view @submitted="update('tags.update', tag.id)" title="Edit Tag" :breadcrumb="breadcrumb">
		<template #form>
			<!-- Name -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="name" value="Name" required />
				<div class="w-full mt-1 ">
					<jet-input v-model="form.name" id="name" type="text" class="w-full" autocomplete="name" />
					<jet-input-error :message="form.errors.name" class="mt-2" />
				</div>
			</form-group>

		</template>

		<template #actions>
			<Link :href="route('tags.index')" class="xs:mr-4">Cancel</Link>
			<jet-button @click.prevent="update('tags.update', tag.id, true)" class="px-6 xs:mr-2 my-2 xs:my-0" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Update & Continue</jet-button>
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
	name: "edit-tag",
	props: {
		tag: Object,
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
				{ label: "Tags", route: this.route("tags.index") },
				{ label: "Edit", route: null },
			],

			form: this.$inertia.form({
				name: this.tag.name,
			}),

			rowItems: [],
		};
	},
};
</script>
