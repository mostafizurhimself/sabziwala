<template>
	<div class="flex  py-8 px-8">
		<div class="w-5/12">
			<div class="mb-4">
				<h6 class="font-bold text-lg">Country Section</h6>
				<span class=" text-gray-500 ">Add & change country content here</span>
			</div>
			<!-- Admin -->
			<button class="btn btn-primary px-6 py-2" @click.prevent="addCountry" v-if="$page.props.can.createCountries">
				<span class="mr-2">+ Add</span>
				<span class="hidden md:inline">Country</span>
			</button>

		</div>
		<!--Table Rows -->
		<div class="w-7/12 rounded-lg border overflow-x-auto">
			<table v-if="$page.props.countries.length">
				<thead class="head">
					<tr>
						<th>Id</th>
						<th>Country Name</th>
						<th>Code (ISO 2)</th>
						<th>Action</th>
					</tr>

				</thead>
				<tbody>
					<tr v-for="(row, index) in $page.props.countries" :key="index">
						<td>{{row.id}}</td>
						<td>{{row.name}}</td>
						<td>{{row.code}}</td>

						<td class="flex">
							<div>
								<jet-button class="btn btn-success mr-2" title="Edit" @click="editCountry(index)" v-if="$page.props.can.updateCountries">
									<i class="ti-pencil-alt"></i>
								</jet-button>

								<jet-danger-button title="Delete" @click="deleteResource(route('countries.destroy', row.id))" v-if="$page.props.can.deleteCountries">
									<i class="ti-trash"></i>
								</jet-danger-button>
							</div>
						</td>
					</tr>

				</tbody>
			</table>

			<div class="flex justify-center items-center text-gray-800 h-32" v-else>
				<span class="font-semibold">No country added</span>
			</div>
		</div>

		<!-- Add Country modal -->
		<jet-dialog-modal :show="showDialog" @close="closeModal">
			<template #title>Add Country</template>

			<template #content>

				<!-- Name -->
				<form-group class="border-b">
					<jet-label class="md:w-1/4 mt-2" for="name" value="Name" required />
					<div class="w-full mt-1">
						<jet-input v-model="form.name" id="name" type="text" class="w-full" autocomplete="name" />
						<jet-input-error :message="form.errors.name" class="mt-2" />
					</div>
				</form-group>

				<!--Code -->
				<form-group class="border-b">
					<jet-label class="md:w-1/4 mt-2" for="code" value="ISO 2 Code" required />
					<div class="w-full mt-1">
						<jet-input v-model="form.code" id="code" type="text" class="w-full" autocomplete="code" />
						<jet-input-error :message="form.errors.code" class="mt-2" />
					</div>
				</form-group>

			</template>

			<template #footer>
				<button class="" @click="closeModal">Cancel</button>

				<button class="ml-2 btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="save">Save</button>
			</template>
		</jet-dialog-modal>

	</div>
</template>

<script>
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetButton from "@/Jetstream/Button.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";
import JetTextInput from "@/Jetstream/TextInput.vue";
export default {
	name: "countries",

	props: {
		query: Object,
	},

	components: {
		Link,
		JetButton,
		JetDangerButton,
		JetDialogModal,
		JetButton,
		JetInput,
		JetInputError,
		JetLabel,
		FormGroup,
		JetTextInput,
	},

	data() {
		return {
			form: this.$inertia.form({
				id: null,
				name: null,
				code: null,
			}),

			showDialog: false,
			edit: false,
		};
	},

	methods: {
		addCountry() {
			this.edit = false;
			this.form.reset();
			this.showDialog = true;
		},
		save() {
			if (this.edit) {
				this.form.put(route("countries.update", this.form.id), {
					onSuccess: () => {
						this.edit = false;
						this.closeModal();
						this.form.reset();
					},
				});
			} else {
				this.form.post(route("countries.store"), {
					onSuccess: () => {
						this.closeModal();
						this.form.reset();
					},
				});
			}
		},

		closeModal() {
			this.showDialog = false;
		},

		editCountry(index) {
			this.showDialog = true;
			this.edit = true;
			this.form.id = this.$page.props.countries[index].id;
			this.form.name = this.$page.props.countries[index].name;
			this.form.code = this.$page.props.countries[index].code;
		},
	},
};
</script>

<style lang="scss" scoped>
.head {
	@apply bg-gray-50;
}

tr:nth-child(even) {
	@apply bg-gray-50;
}
</style>
