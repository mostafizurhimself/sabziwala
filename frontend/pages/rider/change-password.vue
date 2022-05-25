<template>
  <div class="container flex flex-col items-center justify-center" style="min-height: 600px">
    <h3 class="font-bold text-3xl mb-4 text-primary-500">Change Password</h3>
    <form class="w-full max-w-lg px-4 py-8 rounded shadow mt-5" @submit.prevent="changePassword">
      <input-field type="password" label="Old Password" v-model="formData.oldPassword"></input-field>
      <input-field type="password" label="New Password" v-model="formData.password"></input-field>
      <input-field type="password" label="Confirm new password" v-model="formData.password_confirmation"></input-field>

      <button-field label="Change Password" class="bg-primary-500 text-white mt-3 py-3 w-full"></button-field>
    </form>
  </div>
</template>

<script>
    export default {
      name: 'RiderChangePassword',
      middleware: ['auth'],
      layout: 'rider',

        data() {
          return {
            formData: {
          oldPassword: null,
          password: null,
          password_confirmation: null
        }
          }
        },
        methods: {
          async changePassword() {
            try {
              await this.$axios.post('/rider/change-password', this.formData);
              this.$router.push('/rider/profile');
        this.$toast.success("Password updated successfully.");
            } catch (error) {
              console.log(error);
            }
          }
        }
    }
</script>

<style lang="scss" scoped>

</style>