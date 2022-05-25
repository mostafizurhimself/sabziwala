<template>
  <div class="container flex flex-col items-center justify-center" style="min-height: 600px">
    <h3 class="font-bold text-3xl mb-4 text-primary-500">Reset Password</h3>
    <form autocomplete="off" class="w-full max-w-lg px-4 py-8 rounded shadow mt-5" @submit.prevent="resetPassword">
      <input-field type="email" label="Your Email" v-model="email" :error="validationErrors.email"></input-field>
      <input-field type="password" label="Password" v-model="password" :error="validationErrors.password"></input-field>
      <input-field type="password" label="Confirm Password" v-model="password_confirmation"></input-field>

      <button-field label="Update" class="bg-primary-500 text-white mt-3 py-3 w-full"></button-field>
    </form>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
	layout: "auth",
	name: "ResetPassword",
    middleware: ['guest'],
    layout: 'rider',

	data() {
		return {
			token: null,
			email: null,
			password: null,
			password_confirmation: null,
		};
	},

	computed: {
		...mapGetters({
			validationErrors: "validation/validationErrors",
		}),
	},

	methods: {
		resetPassword() {
			this.$axios
				.$post("/rider/reset-password", {
					token: this.$route.params.token,
					email: this.email,
					password: this.password,
					password_confirmation: this.password_confirmation,
				})
				.then(
					(result) => {
						this.$toast.success("Password reset successfully");
						this.$router.push("/rider/login");
					},
					(error) => {
						this.$toast.error("Something went wrong");
						console.error(error);
					}
				);
		},
	},
};
</script>
