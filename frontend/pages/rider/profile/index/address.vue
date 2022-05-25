<template>
  <div>
    <p class="bg-gray-200 p-5">
      The following addresses will be used on the checkout page by default.
    </p>

    <form class="lg:flex mt-3" @submit.prevent="saveAddress">
      <div class="lg:w-6/12 py-5 px-0">
        <h5 class="text-xl font-semibold inline ">
          Present Address
        </h5>

        <div class="mt-3 lg:mr-10">
          <input-field label="Street" v-model="formData.presentAddress.street" :error="validationErrors['presentAddress.street']"></input-field>
          <input-field label="City" v-model="formData.presentAddress.city" :error="validationErrors['presentAddress.city']"></input-field>
          <input-field label="State" v-model="formData.presentAddress.state" :error="validationErrors['presentAddress.state']"></input-field>
          <input-field label="Zip-code" v-model="formData.presentAddress.zipcode" :error="validationErrors['presentAddress.zipcode']"></input-field>
          <select-field label="Country" v-model="formData.presentAddress.country" :options="countries" :error="validationErrors['presentAddress.country']"></select-field>
          <checkbox-field tiny class="mt-3" :label="`<span class='font-semibold'>Permanent address</span> is same as <span class='font-semibold'>Present address</span>`" v-model="permanentIsSame" @change="setPermanent"></checkbox-field>
        </div>
      </div>
      <div class="lg:w-6/12 py-5 px-0">
        <h5 class="text-xl font-semibold inline">Permanent Address</h5>

        <div class="mt-3">
          <input-field :disabled="permanentIsSame" class="mt-2" label="Street" v-model="formData.permanentAddress.street" :error="validationErrors['permanentAddress.street']"></input-field>
          <input-field :disabled="permanentIsSame" label="City" v-model="formData.permanentAddress.city" :error="validationErrors['permanentAddress.city']"></input-field>
          <input-field :disabled="permanentIsSame" label="State" v-model="formData.permanentAddress.state" :error="validationErrors['permanentAddress.state']"></input-field>
          <input-field :disabled="permanentIsSame" label="Zip-code" v-model="formData.permanentAddress.zipcode" :error="validationErrors['permanentAddress.zipcode']"></input-field>
          <select-field :disabled="permanentIsSame" label="Country" v-model="formData.permanentAddress.country" :options="countries" :error="validationErrors['permanentAddress.country']"></select-field>

          <div class="flex justify-end mt-4">
            <button-field label="Save" class="bg-primary-500 text-white py-3 px-10"></button-field>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "RiderAddress",
  data() {
    return {
      formData: {
        presentAddress: {
          street: this.$auth.user?.presentAddress?.street,
            city: this.$auth.user?.presentAddress?.city,
            state: this.$auth.user?.presentAddress?.state,
            zipcode: this.$auth.user?.presentAddress?.zipcode,
            country: this.$auth.user?.presentAddress?.country
        },
        permanentAddress: {
          street: this.$auth.user?.permanentAddress?.street,
            city: this.$auth.user?.permanentAddress?.city,
            state: this.$auth.user?.permanentAddress?.state,
            zipcode: this.$auth.user?.permanentAddress?.zipcode,
            country: this.$auth.user?.permanentAddress?.country
        },
      },
      permanentIsSame: false,
      countries: [],
    };
  },
  methods: {
    async saveAddress() {
      try {
        const resAddress = await this.$axios.$post("/rider/address", this.formData);
        this.$auth.setUser(resAddress.data);
        this.$toast.success("Address updated successfully");

        }
         catch (error) {
        console.log(error);
      }
    },

    setPermanent() {
      if(this.permanentIsSame) {
        this.formData.permanentAddress.street = this.formData.presentAddress.street
        this.formData.permanentAddress.city = this.formData.presentAddress.city
        this.formData.permanentAddress.state = this.formData.presentAddress.state
        this.formData.permanentAddress.zipcode = this.formData.presentAddress.zipcode
        this.formData.permanentAddress.country = this.formData.presentAddress.country
      }
    }

    
  },

    	computed: {
		...mapGetters({
			validationErrors: "validation/validationErrors",
		}),
	},
  
 watch: {
   permanentIsSame() {
     this.setPermanent();
   }
 },

    async fetch() {
      const resCountries = await this.$axios.$get("/countries");
      this.countries = resCountries;
  }
};
</script>
