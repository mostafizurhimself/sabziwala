<template>
  <div>
    <p class="bg-gray-200 p-5">
      The following addresses will be used on the checkout page by default.
    </p>

    <!-- alerts -->
    <div>
      <!-- Billing Address -->
      <div v-if="validationErrors && validationErrors.billingAddress" class="flex items-center bg-primary-50 text-primary-700 text-sm font-semibold px-4 py-3 mt-3" role="alert">
        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
          <path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z" />
        </svg>
        <p>{{validationErrors.billingAddress[0]}}</p>
      </div>

      <!-- Shipping Address -->
      <div v-if="validationErrors && validationErrors.shippingAddress" class="flex items-center bg-primary-50 text-primary-700 text-sm font-semibold px-4 py-3 mt-3" role="alert">
        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
          <path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z" />
        </svg>
        <p>{{validationErrors.shippingAddress[0]}}</p>
      </div>
    </div>

    <form class="lg:flex mt-3" @submit.prevent="saveAddress">
      <div class="lg:w-6/12 py-5">
        <h5 class="text-xl font-semibold inline ">
          Billing Address
        </h5>

        <div class="mt-3 lg:mr-10">
          <input-field label="Street" v-model="formData.billingAddress.street" :error="validationErrors['billingAddress.street']"></input-field>
          <input-field label="City" v-model="formData.billingAddress.city" :error="validationErrors['billingAddress.city']"></input-field>
          <input-field label="State" v-model="formData.billingAddress.state" :error="validationErrors['billingAddress.state']">
          </input-field>
          <input-field label="Zip-code" v-model="formData.billingAddress.zipcode" :error="validationErrors['billingAddress.zipcode']"></input-field>
          <select-field label="Country" v-model="formData.billingAddress.country" :options="countries" :error="validationErrors['billingAddress.country']"></select-field>
          <checkbox-field tiny class="mt-3" :label="`<span class='font-semibold'>Shipping address</span> is same as <span class='font-semibold'>Billing address</span>`" v-model="shippingIsSame" @change="setShipping"></checkbox-field>
        </div>
      </div>
      <div class="lg:w-6/12 py-5">
        <h5 class="text-xl font-semibold inline">Shipping Address</h5>

        <div class="mt-3">
          <input-field :disabled="shippingIsSame" class="mt-2" label="Street" v-model="formData.shippingAddress.street" :error="validationErrors['shippingAddress.street']"></input-field>
          <input-field :disabled="shippingIsSame" label="City" v-model="formData.shippingAddress.city" :error="validationErrors['shippingAddress.city']"></input-field>
          <input-field :disabled="shippingIsSame" label="State" v-model="formData.shippingAddress.state" :error="validationErrors['shippingAddress.state']"></input-field>
          <input-field :disabled="shippingIsSame" label="Zip-code" v-model="formData.shippingAddress.zipcode" :error="validationErrors['shippingAddress.zipcode']"></input-field>
          <select-field :disabled="shippingIsSame" label="Country" v-model="formData.shippingAddress.country" :options="countries" :error="validationErrors['shippingAddress.country']"></select-field>

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
  name: "ProfileAddress",
  data() {
    return {
      formData: {
        billingAddress: {
          street: this.$auth.user?.billingAddress?.street,
          city: this.$auth.user?.billingAddress?.city,
          state: this.$auth.user?.billingAddress?.state,
          zipcode: this.$auth.user?.billingAddress?.zipcode,
          country: this.$auth.user?.billingAddress?.country
        },
        shippingAddress: {
          street: this.$auth.user?.shippingAddress?.street,
          city: this.$auth.user?.shippingAddress?.city,
          state: this.$auth.user?.shippingAddress?.state,
          zipcode: this.$auth.user?.shippingAddress?.zipcode,
          country: this.$auth.user?.shippingAddress?.country
        }
      },
      shippingIsSame: false,
      countries: []
    };
  },
  methods: {
    async saveAddress() {
      try {
        const resAddress = await this.$axios.$post(
          "/customer/address",
          this.formData
        );
        this.$auth.setUser(resAddress.data);
        this.$toast.success("Address updated successfully");
      } catch (error) {
        console.log(error);
      }
    },

    setShipping() {
      if (this.shippingIsSame) {
        this.formData.shippingAddress.street = this.formData.billingAddress.street;
        this.formData.shippingAddress.city = this.formData.billingAddress.city;
        this.formData.shippingAddress.state = this.formData.billingAddress.state;
        this.formData.shippingAddress.zipcode = this.formData.billingAddress.zipcode;
        this.formData.shippingAddress.country = this.formData.billingAddress.country;
      }
    }
  },

  computed: {
    ...mapGetters({
      validationErrors: "validation/validationErrors"
    })
  },

  watch: {
    shippingIsSame() {
      this.setShipping();
    }
  },

  async fetch() {
    const resCountries = await this.$axios.$get("/countries");
    this.countries = resCountries;
  }
};
</script>
