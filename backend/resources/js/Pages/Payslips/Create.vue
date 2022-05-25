<template>
	<form-view @submitted="save" title="Generate Payslip" :breadcrumb="breadcrumb">
		<template #form>

			<!-- Paid Amount-->
			<form-group class="border-b">
				<jet-label class="md:w-2/4 mt-2" for="paidAmount" value="Paid Amount" required />
				<div class="w-full mt-1">
					<jet-input v-model="form.paidAmount" id="paidAmount" type="number" class="w-full" autocomplete="paidAmount" />
					<jet-input-error :message="errors.paidAmount" class="mt-2" />
				</div>
			</form-group>

			<!-- Deduct Amount -->
			<form-group class="border-b">
				<jet-label class="md:w-2/4 mt-2" for="deductedAmount" value="Deduct Amount" required />
				<div class="w-full mt-1">
					<jet-input v-model="form.deductedAmount" id="deductedAmount" type="number" class="w-full" ref="deducted" autocomplete="deductedAmount" />
					<jet-input-error :message="errors.deductedAmount" class="mt-2" />
				</div>
			</form-group>

		</template>

		<template #actions>
			<button @click.prevent="cancel" class="xs:mr-4">Cancel</button>
			<jet-button :class="{ 'opacity-25': processing }" :disabled="processing" class="px-6">Generate</jet-button>
		</template>
	</form-view>

</template>


<script>
import FormView from "@/Views/FormView.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetLabel from "@/Jetstream/Label.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import axios from "axios";
export default {
	name: "generate-payslip",

	props: {
		salary: {
			type: Object,
			required: true,
		},
		deductable: {
			type: Number,
			required: true,
		},
		payslip: {
			type: Object,
		},
	},
	data() {
		return {
			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Salaries", route: this.route("salaries.index") },
				{
					label: this.salary.id,
					route: route("salaries.show", this.salary.id),
				},
				{
					label: "Payslip",
					route: null,
				},
			],
			form: {
				paidAmount: this.salary.totalDue,
				deductedAmount: this.deductable,
			},
			processing: false,
			errors: {},
		};
	},
	watch: {
		"form.deductedAmount": {
			handler: function () {
				this.form.paidAmount =
					this.salary.totalDue - this.form.deductedAmount;
			},
			immediate: true,
		},
	},
	components: {
		FormView,
		Link,
		JetLabel,
		JetInputError,
		FormGroup,
		JetInput,
		JetButton,
	},

	methods: {
		closeModal() {
			this.showDialog = false;
		},
		showModal() {
			this.showDialog = true;
		},

		async save() {
			this.processing = true;
			try {
				const response = await axios.post(
					this.route("payslips.store", this.salary.id),
					this.form
				);
				this.processing = false;
				window.location.replace(
					this.route("payslips.show", response.data.id)
				);
			} catch (error) {
				if (error.response.status === 422) {
					for (const [key, value] of Object.entries(
						error.response.data.errors
					)) {
						this.errors[key] = value[0];
					}
				}
				this.processing = false;
			}
		},

		cancel() {
			window.close();
		},
	},
};
</script>

<style lang="scss" scoped>
</style>
