<template>
	<form-view @submitted="save('zones.store')" title="Create Zone" :breadcrumb="breadcrumb">
		<template #form>
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="search-place" value="Search" />
				<div class="w-full mt-1">
					<place-control @setPlace="setPlace" :countries="restrictedCountries">
					</place-control>
				</div>
			</form-group>

			<!-- Name -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="name" value="Name" required />
				<div class="w-full mt-1">
					<jet-input v-model="form.name" id="name" type="text" class="w-full" autocomplete="name" />
					<jet-input-error :message="form.errors.name" class="mt-2" />
				</div>
			</form-group>

			<!-- City -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="city" value="City" required />
				<div class="w-full mt-1">
					<jet-input v-model="form.city" id="city" type="text" class="w-full" autocomplete="city" />
					<jet-input-error :message="form.errors.city" class="mt-2" />
				</div>
			</form-group>

			<!-- State -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="state" value="State" />
				<div class="w-full mt-1">
					<jet-input v-model="form.state" id="state" type="text" class="w-full" autocomplete="state" />
					<jet-input-error :message="form.errors.state" class="mt-2" />
				</div>
			</form-group>

			<!-- Zipcode -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="zipcode" value="Zipcode" />
				<div class="w-full mt-1">
					<jet-input v-model="form.zipcode" id="zipcode" type="text" class="w-full" autocomplete="zipcode" />
					<jet-input-error :message="form.errors.zipcode" class="mt-2" />
				</div>
			</form-group>

			<!-- Country -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="countries" value="Country" required />
				<div class="w-full mt-1">
					<jet-select v-model="form.country" track="name" class="w-full" :options="countries"></jet-select>
					<jet-input-error :message="form.errors.country" class="mt-2" />
				</div>
			</form-group>

		</template>

		<template #actions>
			<Link :href="route('zones.index')" class="xs:mr-4">Cancel</Link>
			<jet-button @click.prevent="save('zones.store', true)" class="px-6 xs:mr-2 my-2 xs:my-0" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save & Continue</jet-button>
			<jet-button class="px-6" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save</jet-button>
		</template>
	</form-view>

</template>

<script>
import JetSelect from "@/Jetstream/Select";
import FormView from "@/Views/FormView.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetTextInput from "@/Jetstream/TextInput.vue";
import JetButton from "@/Jetstream/Button.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";
import PlaceControl from "@/Jetstream/PlaceControl.vue";

export default {
	name: "create-zone",

	props: {
		countries: Object,
	},

	components: {
		Link,
		FormView,
		JetInput,
		JetInputError,
		JetLabel,
		JetTextInput,
		FormGroup,
		JetButton,
		JetSelect,
		PlaceControl,
	},
	data() {
		return {
			showDialog: false,
			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Zones", route: this.route("zones.index") },
				{ label: "Create", route: null },
			],

			form: this.$inertia.form({
				name: null,
				city: null,
				state: null,
				zipcode: null,
				country: null,
			}),
		};
	},

	computed: {
		restrictedCountries() {
			return this.countries.map((country) => country.code);
		},
	},
	methods: {
		setPlace(e) {
			this.form.name = e.name ?? null;
			this.form.city = e.city ?? null;
			this.form.state = e.state ?? null;
			this.form.zipcode = e.zipcode ?? null;
			this.form.country = e.country ?? null;
		},
	},
};
</script>
