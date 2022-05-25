<template>
  <div class="container flex flex-col items-center justify-center" style="min-height: 600px">
    <h3 class="font-bold text-3xl mb-4 text-primary-500">Welcome Back Rider!!</h3>
    <form class="w-full max-w-lg px-4 py-8 rounded shadow mt-5" @submit.prevent="login">
      <input-field type="tel" label="Phone" v-model="formData.phone" :error="validationErrors.phone"></input-field>
      <input-field type="password" label="Password" v-model="formData.password" :error="validationErrors.password"></input-field>
      <div class="text-right my-4">
        <nuxt-link to="/rider/forgot-password" class="text-sm text-primary-500 hover:underline">Forgot your Password?</nuxt-link>
      </div>
      <button-field label="Sign In" class="bg-primary-500 text-white py-3 w-full"></button-field>
      <div class="mt-4 text-center">
        <p class="text-sm">
          Not a rider yet?
          <nuxt-link to="/rider/register" class="text-primary-500 underline">Register here</nuxt-link>
        </p>
      </div>
    </form>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
	name: "login",
	layout: "rider",
	middleware: ['guest'],
	data() {
		return {
			formData: {
				phone: null,
				password: null,
			},
		};
	},
	computed: {
		...mapGetters({
			validationErrors: "validation/validationErrors",
		}),
	},
	methods: {
		async login() {
			try {
				let response = await this.$auth.loginWith("rider", {
					data: this.formData,
				});
				this.$router.push("/rider/profile");
				this.$toast.success("Logged In successfully.");
			} catch (err) {
				console.log(err);
				this.$toast.error("Credentials doesn't mached");
			}
		},
	},
};
</script>
