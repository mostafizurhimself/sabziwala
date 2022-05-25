<template>
	<div>
		<stripe-element-card @error="onError" ref="elementRef" :pk="pulishableKey" @token="tokenCreated" :hidePostalCode="true" />
		<button-field @click="submit" type="button" :label="label" class="py-3 w-full"></button-field>
	</div>
</template>

<script>
export default {
	props: {
		label: {
			type: String,
			default: "Pay Now",
		},
	},
	data() {
		return {
			pulishableKey: this.$config.stripePulishableKey,
			token: null,
		};
	},
	emits: ["token-generated"],
	methods: {
		submit() {
			// this will trigger the process
			this.$refs.elementRef.submit();
			this.$emit("onSubmit");
		},
		tokenCreated(token) {
			this.$emit("token-generated", token);

			// handle the token
			// send it to your server
		},
		onError(err) {
			this.$emit("onError", err);
		},
	},
};
</script>

<style lang="scss">
.StripeElement {
	border: 1px solid #ee1d23 !important;
}
</style>
