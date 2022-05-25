<template>
  <div class="container flex flex-col items-center justify-center" style="min-height: 600px">
    <h3 class="font-bold text-3xl mb-4 text-primary-500">Reset Password</h3>
    <form class="w-full max-w-lg px-4 py-8 rounded shadow mt-5" @submit.prevent="requestResetPassword">
      <input-field type="email" label="Email" v-model="email"></input-field>

      <button-field label="Send Reset Link" class="bg-primary-500 text-white mt-3 py-3 w-full"></button-field>
    </form>
  </div>
</template>

<script>
export default {
    name: "RiderForgotPassword",
      middleware: ['guest'],
      layout: 'rider',

    data() {
        return {
          email: null
        }
    },
    methods: {
        async requestResetPassword() {
            try {
              let res = await this.$axios.$post("/rider/forgot-password", {email: this.email})
                this.email = null
            } catch (error) {
                 console.log(error);
            }
}
        }
}
</script>