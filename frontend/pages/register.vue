<template>
	<div class="container flex flex-col items-center justify-center my-10">
		<h3 class="font-bold text-3xl mb-4 text-primary-500">Sign Up</h3>
		<form @submit.prevent="register" class="w-full max-w-lg px-4 py-8 rounded shadow mt-5">
			<input-field label="First Name" v-model="formData.firstName" :error="validationErrors.firstName"></input-field>
			<input-field label="Last Name" v-model="formData.lastName" :error="validationErrors.lastName"></input-field>
			<input-field label="Email" type="email" v-model="formData.email" :error="validationErrors.email"></input-field>
			<input-field label="Phone" type="tel" v-model="formData.phone" :error="validationErrors.phone"></input-field>
			<input-field label="Password" type="password" v-model="formData.password" :error="validationErrors.password"></input-field>
			<input-field label="Confirm Password" type="password" v-model="formData.password_confirmation"></input-field>

			<button-field label="Sign Up" class="bg-primary-500 text-white py-3 mt-3 w-full"></button-field>

			<div class="my-4 text-center">
				<p class="text-sm">
					Already registered?
					<nuxt-link to="/login" class="text-primary-500 underline">Sign In</nuxt-link>
				</p>
			</div>
		</form>
	</div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
	name: "Register",
	middleware: ["guest"],
	data() {
		return {
			formData: {
				firstName: "",
				lastName: "",
				email: "",
				phone: "",
				password: "",
				password_confirmation: "",
			},
		};
	},
	computed: {
		...mapGetters({
			validationErrors: "validation/validationErrors",
		}),
	},

	methods: {
		async register() {
			let data = this.formData;
			try {
				await this.$axios.$post("/customer/register", data);
				await this.$auth.loginWith("local", {
					data: {
						phone: this.formData.phone,
						password: this.formData.password,
					},
				});
				this.$router.push("/customer/profile");
			} catch (error) {
				console.log(error);
			}
		},
	},
};
</script>
