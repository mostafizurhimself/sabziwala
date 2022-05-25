<template>
	<form-view @submitted="save('loans.store')" title="Create Loan" :breadcrumb="breadcrumb">
		<template #form>

			<!-- Employees -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="employees" value="Employees" required />
				<div class="w-full mt-1">
					<!-- Searchabel Select -->
					<searchable-select :options="employees" v-model="form.employeeId" autoFocus></searchable-select>

					<jet-input-error :message="form.errors.employeeId" class="mt-2" />
				</div>
			</form-group>

			<!-- Loan Date -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="loanDate" value="Loan Date" required />
				<div class="w-full mt-1">
					<jet-input v-model="form.loanDate" id="loanDate" type="date" class="w-full" autocomplete="loanDate" />
					<jet-input-error :message="form.errors.loanDate" class="mt-2" />
				</div>
			</form-group>

			<!-- Loan Amount -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="loanAmount" value="Loan Amount" required />
				<div class="w-full mt-1">
					<jet-input v-model="form.loanAmount" id="loanAmount" type="number" class="w-full" autocomplete="loanAmount" />
					<jet-input-error :message="form.errors.loanAmount" class="mt-2" />
				</div>
			</form-group>

			<!-- Paid Amount -->
			<!-- <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="paidAmount" value="Paid Amount" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.paidAmount" id="paidAmount" type="number" class="w-full" autocomplete="paidAmount" />
                    <jet-input-error :message="form.errors.paidAmount" class="mt-2" />
                </div>
            </form-group> -->

			<!-- Status -->
			<!-- <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="status" value="Status" required />
                <div class="w-full mt-1">
                    <jet-select v-model="form.status" track="value" class="w-full" :options="status"></jet-select>
                    <jet-input-error :message="form.errors.status" class="mt-2" />
                </div>
            </form-group> -->

		</template>

		<template #actions>
			<Link :href="route('loans.index')" class="xs:mr-4">Cancel</Link>
			<jet-button @click.prevent="save('loans.store', true)" class="px-6 xs:mr-2 my-2 xs:my-0" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save & Continue</jet-button>
			<jet-button class="px-6" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save</jet-button>
		</template>
	</form-view>

</template>

<script>
import FormView from "@/Views/FormView.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetTextInput from "@/Jetstream/TextInput.vue";
import JetButton from "@/Jetstream/Button.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";
import JetSelect from "@/Jetstream/Select";
import SearchableSelect from "@/Jetstream/SearchableSelect";

export default {
	name: "create-loan",
	props: {
		employees: Array,
		status: Array,
	},

	components: {
		SearchableSelect,
		Link,
		FormView,
		JetInput,
		JetInputError,
		JetLabel,
		JetTextInput,
		FormGroup,
		JetButton,
		JetSelect,
	},
	data() {
		return {
			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Loan", route: this.route("loans.index") },
				{ label: "Create", route: null },
			],

			form: this.$inertia.form({
				employeeId: "",
				loanDate: null,
				loanAmount: null,
				// paidAmount: null,
				// status: null,
			}),
		};
	},
};
</script>
