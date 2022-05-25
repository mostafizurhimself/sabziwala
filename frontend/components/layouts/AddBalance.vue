<template>
	<div class>
		<div class="h-full">
			<!-- paymemt options -->
			<div class>
				<div>
					<h5>Amount</h5>
					<input-field class="mt-2" type="number" v-model="addAmount"></input-field>
				</div>

				<h5 class="mt-5">Choose Payment Method</h5>
				<div class="border border-gray-300 rounded p-3 mt-2">
					<payment-method-button :buttons="paymentButtons" v-model="paymentMethod"></payment-method-button>
				</div>
			</div>

			<!-- payment area -->
			<div class="mt-10" :class="{disabledPayment: disablePayButton}">
				<!-- Stripe -->
				<stripe v-show="paymentMethod == 'stripe'" @onError="stripeError" @token-generated="handlePaymentCompleteStripe" @onSubmit="onStripeSubmit"></stripe>
			</div>
		</div>
	</div>
</template>

<script>
import { mapGetters } from "vuex";
import Stripe from "~/components/Stripe.vue";

export default {
	name: "AddBalanceModal",
	components: {
		Stripe,
	},
	data() {
		return {
			addAmount: "",
			paymentMethod: "",
			disablePayButton: false,
			paymentButtons: [
				{
					src: "/images/icons/gplogo.png",
					id: "payment_stripe",
					value: "stripe",
					name: "payment",
					show: true,
				},
			],
		};
	},

	computed: {
		...mapGetters({
			getPaymentMethod: "config/getPaymentMethod",
		}),
	},

	methods: {
		// Handle stripe payment
		async handlePaymentCompleteStripe(token) {
			try {
				const resStripe = await this.$axios.$post(
					"/customer/wallet/add-money",
					{
						token: token.id,
						amount: this.addAmount,
						paymentMethod: this.getPaymentMethod.STRIPE,
					}
				);
				this.$toast.success("Balance added successfully!");
				this.$router.push("/customer/profile/wallet");
				this.addAmount = "";
				this.paymentMethod = "";
				this.$auth.setUser(resStripe.data);
				this.$emit("close");
				this.$emit("success");
			} catch (error) {
				console.log(error);
			} finally {
				this.disablePayButton = false;
			}
		},

		onStripeSubmit() {
			this.disablePayButton = true;
		},

		stripeError(err) {
			this.disablePayButton = false;
		},
	},
};
</script>

<style scoped>
.disabledPayment {
	pointer-events: none;
	opacity: 0.6;
}
</style>
