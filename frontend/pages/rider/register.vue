<template>
  <div class="container flex flex-col items-center justify-center my-10">
    <h3 class="font-bold text-3xl mb-4 text-primary-500">Sign Up As a Rider</h3>
    <form @submit.prevent="register" class="mt-5 w-full max-w-lg px-4 py-8 rounded shadow">
      <input-field label="First Name" v-model="formData.firstName" :error="validationErrors.firstName"></input-field>
      <input-field label="Last Name" v-model="formData.lastName" :error="validationErrors.lastName"></input-field>
      <input-field label="Email" type="email" v-model="formData.email" :error="validationErrors.email"></input-field>
      <input-field label="Phone" type="tel" v-model="formData.phone" :error="validationErrors.phone"></input-field>
      <input-field label="Password" type="password" v-model="formData.password" :error="validationErrors.password"></input-field>
      <input-field label="Confirm Password" type="password" v-model="formData.password_confirmation"></input-field>
      <p class="text-center mt-5 text-gray-400 text-sm">Please select your working zone</p>
      <div class="grid grid-cols-2 gap-5 mt-3">
        <select-field :options="cities" @input="getZones" v-model="selectedCity" placeholder='Select City'></select-field>
        <select-field placeholder="Select Zone" :disabled="!selectedCity" :options="zones" v-model="formData.zoneId" :error="validationErrors.zoneId"></select-field>
      </div>

      <button-field label="Sign Up" class="bg-primary-500 text-white py-3 mt-5 w-full"></button-field>

      <div class="mt-4 text-center">
        <p class="text-sm">
          Already a rider?
          <nuxt-link to="/rider/login" class="text-primary-500 underline">Sign In</nuxt-link>
        </p>
      </div>
    </form>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "Register",
  layout: "rider",
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
        zoneId: null
      },
      selectedCity: null,
      zones: []
    };
  },
  computed: {
    ...mapGetters({
      validationErrors: "validation/validationErrors",
      cities: "config/getCities"
    })
  },

  methods: {
    async register() {
      let data = this.formData;
      try {
        await this.$axios.$post("/rider/register", data);
        await this.$auth.loginWith("rider", {
          data: {
            phone: this.formData.phone,
            password: this.formData.password
          }
        });
        this.$router.push("/rider/profile");
      } catch (error) {
        console.log(error);
      }
    },

    // get zones from the cities
    async getZones() {
      try {
        const res = await this.$axios.$get(`/zones?city=${this.selectedCity}`);
        this.zones = res.data;
      } catch (error) {
        console.error(error);
      }
    }
  }
};
</script>
