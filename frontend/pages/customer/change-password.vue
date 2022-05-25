<template>
  <div class="container flex flex-col items-center justify-center" style="min-height: 600px">
    <h3 class="font-bold text-3xl mb-4 text-primary-500">Change Password</h3>
    <form class="w-full max-w-lg px-4 py-8 rounded shadow mt-3" @submit.prevent="changePassword">
      <input-field type="password" label="Old Password" v-model="formData.oldPassword" :error="validationErrors.oldPassword"></input-field>
      <input-field type="password" label="New Password" v-model="formData.password" :error="validationErrors.password"></input-field>
      <input-field type="password" label="Confirm new password" v-model="formData.password_confirmation"></input-field>

      <button-field label="Change Password" class="bg-primary-500 text-white mt-3 py-3 w-full"></button-field>
    </form>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "ChangePassword",
  middleware: ["auth"],
  data() {
    return {
      formData: {
        oldPassword: null,
        password: null,
        password_confirmation: null
      }
    };
  },

  computed: {
    ...mapGetters({
      validationErrors: "validation/validationErrors"
    })
  },

  methods: {
    async changePassword() {
      try {
        await this.$axios.post("/customer/change-password", this.formData);
        this.$router.push("/customer/profile");
        this.$toast.success("Password updated successfully.");
      } catch (error) {
        console.log(error);
        // this.$toast.error(error);
      }
    }
  }
};
</script>

<style lang="scss" scoped>
</style>