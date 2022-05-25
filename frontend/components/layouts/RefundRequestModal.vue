<template>
	<div>
		<select-field v-model="formData.orderId" :options="orders" placeholder="Select Invoice" label="Invoice No" title="invoiceNo" :error="validationErrors.orderId"></select-field>
		<text-field class="mt-3" v-model="formData.reason" label="Please describe the issue..." :error="validationErrors.reason"></text-field>
		<button-field type="button" @click="submit" class="capitalize w-full" label="submit request"></button-field>
	</div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
	name: "RefundRequestModal",

	computed: {
		...mapGetters({
			validationErrors: "validation/validationErrors",
		}),
	},

	data() {
		return {
			orders: [],
			formData: {
				orderId: null,
				reason: null,
			},
		};
	},

	methods: {
		async submit() {
			try {
				const response = await this.$axios.$post(
					"/customer/refund-requests",
					this.formData
				);
				this.$emit("close");
				this.$emit("success");
			} catch (error) {
				console.error(error);
			}
		},
	},

	async created() {
		let response = await this.$axios.$get("/orders");
		this.orders = response.data;
	},
};
</script>