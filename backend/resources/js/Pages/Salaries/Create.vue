<template>
	<form-view @submitted="save('salaries.store')" title="Create Salary" :breadcrumb="breadcrumb">
		<template #form>

			<!--Employee Name -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="employees" value=" Employee Name" required />
				<div class="w-full mt-1">
					<jet-select v-model="form.employeeId" class="w-full" :options="employees" @update:modelValue="setSalary"></jet-select>
					<jet-input-error :message="form.errors.employeeId" class="mt-2" />
				</div>
			</form-group>

			<!-- Salary Month -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="month" value="Salary Month" required />
				<div class="w-full mt-1">
					<jet-input v-model="form.month" id="month" type="month" class="w-full" autocomplete="month" />
					<jet-input-error :message="form.errors.month" class="mt-2" />
				</div>
			</form-group>

			<!-- Salary Amount -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="totalAmount" value="Salary Amount" required />
				<div class="w-full mt-1">
					<jet-input v-model="form.totalAmount" id="totalAmount" type="number" class="w-full" autocomplete="totalAmount" />
					<jet-input-error :message="form.errors.totalAmount" class="mt-2" />
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

		</template>

		<template #actions>
			<Link :href="route('salaries.index')" class="xs:mr-4">Cancel</Link>
			<jet-button @click.prevent="save('salaries.store', true)" class="px-6 xs:mr-2 my-2 xs:my-0" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save & Continue</jet-button>
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

export default {
	name: "create-salary",
	props: {
		employees: Array,
		status: Array,
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
	},
	data() {
		return {
			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Salaries", route: this.route("salaries.index") },
				{ label: "Create", route: null },
			],

			form: this.$inertia.form({
				employeeId: null,
				month: null,
				totalAmount: 0,
			}),
		};
	},

	methods: {
		setSalary() {
			let employee = this.employees.find(
				(employee) => employee.id == this.form.employeeId
			);
			this.form.totalAmount = employee.salary;
		},
	},
};
</script>
