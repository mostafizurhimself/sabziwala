<template>
  <div class="container my-5 md:my-10 lg:my-20">
    <div class="mx-auto">
      <div class="lg:w-10/12 mx-auto">
        <h5 class="font-semibold text-xl mb-3">Personal Information</h5>
        <div class="border p-3 md:p-5 rounded-lg">
          <form @submit.prevent="login">
            <!-- number found notice -->
            <div v-if="customerFound  && !$auth.loggedIn" class="flex items-center mb-4 text-green-400">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <h5 class="text-md ml-1">This number already has an account! Please Sign In.</h5>
            </div>

            <!-- input fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
              <input-field @blur="searchCustomer" :disabled="$auth.loggedIn" label="Phone" type="tel" v-model="formData.phone" :error="validationErrors.phone"></input-field>
              <input-field v-if="!customerFound " type="email" :disabled="$auth.loggedIn" label="Email" v-model="formData.email" :error="validationErrors.email"></input-field>
              <input-field v-if="!customerFound" :disabled="$auth.loggedIn" label="First Name" v-model="formData.firstName" :error="validationErrors.firstName"></input-field>
              <input-field v-if="!customerFound" :disabled="$auth.loggedIn" label="Last Name" v-model="formData.lastName" :error="validationErrors.lastName"></input-field>
              <input-field v-if="!$auth.loggedIn" label="Password" type="password" v-model="formData.password" :error="validationErrors.password"></input-field>
              <input-field v-if="!$auth.loggedIn && !customerFound" label="Confirm Password" type="password" v-model="formData.password_confirmation"></input-field>
            </div>

            <!-- button and links -->
            <div v-if="customerFound && !$auth.loggedIn" class="flex items-center justify-between mt-2">
              <nuxt-link to="/customer/forgot-password" class="text-primary-500">Forgot Password?</nuxt-link>
              <button-field label="Sign In" class="w-36 py-3"></button-field>
            </div>
          </form>
        </div>

        <!-- address -->
        <div class="mt-10 border p-3 md:p-5 rounded-lg">
          <form class="lg:flex" @submit.prevent="saveAddress">
            <div class="lg:w-6/12 px-2">
              <h5 class="text-xl font-semibold inline">Billing Address</h5>

              <div class="mt-3">
                <input-field label="Street" v-model="formData.billingAddress.street" :error="validationErrors['billingAddress.street']"></input-field>
                <input-field label="City" v-model="formData.billingAddress.city" :error="validationErrors['billingAddress.city']"></input-field>
                <input-field label="State" v-model="formData.billingAddress.state" :error="validationErrors['billingAddress.state']"></input-field>
                <input-field label="Zip-code" v-model="formData.billingAddress.zipcode" :error="validationErrors['billingAddress.zipcode']"></input-field>
                <select-field label="Country" v-model="formData.billingAddress.country" :options="countries" :error="validationErrors['billingAddress.country']"></select-field>
                <checkbox-field tiny class="mt-3" :label="`<span class='font-semibold'>Shipping address</span> is same as <span class='font-semibold'>Billing address</span>`" v-model="shippingIsSame" @change="setShipping"></checkbox-field>
              </div>
            </div>
            <div class="lg:w-6/12 px-2 mt-5 lg:mt-0">
              <h5 class="text-xl font-semibold inline mt-3">Shipping Address</h5>

              <div class="my-3 md:mb-0">
                <input-field :disabled="shippingIsSame" class="mt-2" label="Street" v-model="formData.shippingAddress.street" :error="validationErrors['shippingAddress.street']"></input-field>
                <input-field :disabled="shippingIsSame" label="City" v-model="formData.shippingAddress.city" :error="validationErrors['shippingAddress.city']"></input-field>
                <input-field :disabled="shippingIsSame" label="State" v-model="formData.shippingAddress.state" :error="validationErrors['shippingAddress.state']"></input-field>
                <input-field :disabled="shippingIsSame" label="Zip-code" v-model="formData.shippingAddress.zipcode" :error="validationErrors['shippingAddress.zipcode']"></input-field>
                <select-field :disabled="shippingIsSame" label="Country" v-model="formData.shippingAddress.country" :options="countries" :error="validationErrors['shippingAddress.country']"></select-field>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="lg:w-10/12 mx-auto md:flex mt-10">
        <div class="md:w-7/12 lg:w-6/12 md:mr-10">
          <h5 class="font-semibold text-lg mb-3">Cart Totals</h5>
          <div class="border rounded-lg p-3 bg-gray-100">
            <div v-for="item in getCartItems" :key="item.id" class="flex justify-between">
              <h5 class="mb-3 pr-8">
                {{ item.name }} ×
                <span class="font-semibold">{{ item.quantity }}</span>
              </h5>
              <h5 class="font-semibold whitespace-nowrap">{{ currencyFormat(item.salePrice * item.quantity) }}</h5>
            </div>
            <div class="font-semibold border-t pt-2 flex justify-between">
              <h5>Order Total :</h5>
              <h5 class="whitespace-nowrap">{{ currencyFormat(getTotalPrice) }}</h5>
            </div>
          </div>
        </div>

        <!-- payment methods -->
        <div class="md:w-5/12 lg:w-6/12 mt-10 md:mt-0">
          <h5 class="font-semibold text-lg ">Payment Method</h5>

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

          <!-- paymemt options -->
          <div class="border rounded-lg py-1 px-4 mt-3">
            <payment-method-button :buttons="paymentButtons" v-model="paymentMethod"></payment-method-button>
          </div>

          <!-- confirmation -->
          <div class="mt-3 mb-2" v-if="getTotalItem > 0">
            <checkbox-field tiny v-model="termsAgreed">
              <template #label>
                <span class="text-gray-800 pl-6">
                  I have read the
                  <nuxt-link to="/terms-and-conditions" class="font-semibold" :class="[termsAgreed ? 'text-gray-800' : 'text-primary-500']" target="_blank">terms and conditions</nuxt-link> of Sabziwalay and agree with them.
                </span>
              </template>
            </checkbox-field>
          </div>

          <!-- payment buttons -->
          <div class="mt-5" v-if="getTotalItem > 0">
            <!-- Stripe -->
            <stripe label="Place Order" :class="{disabledPayment: !termsAgreed || disablePayButton}" v-show="paymentMethod === 'stripe'" @onError="stripeError" @token-generated="handleStripePayment" @onSubmit="onStripeSubmit"></stripe>

            <!-- wallet -->
            <div v-if="paymentMethod === 'walletPay'">
              <span v-if="$auth.loggedIn" class="font-semibold block">Wallet balance: {{currencyFormat($auth.user.balance)}}</span>
              <span v-if="!enoughWalletBalance" class="text-sm text-red-500">Not Enough Wallet Balance</span>
              <button-field @click="handleWalletPayment" type="button" :class="[ !(termsAgreed && enoughWalletBalance) ? 'disabledPayment' : '']" label="PLACE ORDER" class="bg-primary-500 text-white w-full py-3 mt-5"></button-field>
            </div>

            <!-- COD -->
            <button-field v-if="paymentMethod === 'COD'" @click="handleCODPayment" type="button" :class="[ !termsAgreed ? 'disabledPayment' : '']" label="PLACE ORDER" class="bg-primary-500 text-white w-full py-3"></button-field>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import Stripe from "~/components/Stripe.vue";

export default {
  name: "CheckoutPage",
  middleware: ["redirectRider"],
  components: {
    Stripe
  },
  data() {
    return {
      formData: {
        firstName: "",
        lastName: "",
        email: "",
        phone: "",
        password: "",
        password_confirmation: "",
        billingAddress: {
          street: "",
          city: "",
          state: "",
          zipcode: "",
          country: ""
        },
        shippingAddress: {
          street: "",
          city: "",
          state: "",
          zipcode: "",
          country: ""
        }
      },
      customerFound: false,
      paymentMethod: "",
      termsAgreed: false,
      shippingIsSame: false,
      countries: [],
      disablePayButton: false
    };
  },

  computed: {
    ...mapGetters({
      validationErrors: "validation/validationErrors",
      getCartItems: "cart/getCartItems",
      getTotalItem: "cart/getTotalItem",
      getTotalPrice: "cart/getTotalPrice",
      getPaymentMethod: "config/getPaymentMethod",
      getSelectedZone: "zone/getSelectedZone"
    }),

    orderItems() {
      return this.getCartItems.map(item => {
        return {
          productId: item.id,
          rate: item.salePrice,
          quantity: item.quantity,
          amount: item.quantity * item.salePrice,
          unitId: item.unit.id
        };
      });
    },

    // checking if there is enough balance
    enoughWalletBalance() {
      return (
        this.$auth.loggedIn && this.$auth.user.balance >= this.getTotalPrice
      );
    },

    // returning payment buttons
    paymentButtons() {
      return [
        {
          src: "/images/icons/cash-on-delivery.png",
          id: "payment_cod",
          value: "COD",
          name: "payment",
          show: true
        },
        {
          src: "/images/icons/walletPay.png",
          id: "walletPay",
          value: "walletPay",
          name: "payment",
          show: this.$auth.loggedIn
        },
        {
          src: "/images/icons/gplogo.png",
          id: "payment_stripe",
          value: "stripe",
          name: "payment",
          show: true
        }
      ];
    }
  },

  methods: {
    // check if the customer exists
    async searchCustomer(phone) {
      if (!this.$auth.loggedIn) {
        const resCustomer = await this.$axios.$post("/customers/check", {
          phone
        });
        if (resCustomer.data.exists) {
          this.customerFound = true;
        } else {
          this.customerFound = false;
        }
      }
    },

    // user login
    async login() {
      try {
        let resUser = await this.$auth.loginWith("local", {
          data: {
            phone: this.formData.phone,
            password: this.formData.password
          }
        });
        this.customerFound = false;
        this.setAuthData();
        this.$router.push("/checkout");
        this.$toast.success("Logged In Successfully.");
      } catch (error) {
        console.log(err);
        this.$toast.error("Credentials doesn't mached");
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
    },

    // Handle stripe payment
    async handleStripePayment(token) {
      const payload = {
        token: token.id,
        customerId: this.$auth.loggedIn ? this.$auth.user.id : null,
        note: "",
        paymentMethod: this.getPaymentMethod.STRIPE,
        subTotal: this.getTotalPrice,
        totalDiscount: 0,
        orderItems: this.orderItems,
        zoneId: this.getSelectedZone,
        ...this.formData
      };
      try {
        const resStripe = await this.$axios.$post("/orders", payload);
        this.$toast.success("Thank you for the order!");
        this.$store.dispatch("cart/resetCart");
        this.$router.push("/customer/profile/orders");
      } catch (error) {
        console.log(error);
      } finally {
        this.disablePayButton = false;
      }
    },

    // Handle wallet payment
    async handleWalletPayment() {
      const payload = {
        customerId: this.$auth.loggedIn ? this.$auth.user.id : null,
        note: "",
        paymentMethod: this.getPaymentMethod.WALLET,
        subTotal: this.getTotalPrice,
        totalDiscount: 0,
        orderItems: this.orderItems,
        zoneId: this.getSelectedZone,
        ...this.formData
      };
      try {
        const resWallet = await this.$axios.$post("/orders", payload);
        this.$toast.success("Thank you for the order!");
        this.$store.dispatch("cart/resetCart");
        this.$router.push("/customer/profile/orders");
      } catch (error) {
        console.log(error);
      }
    },

    // Handle COD
    async handleCODPayment() {
      const payload = {
        customerId: this.$auth.loggedIn ? this.$auth.user.id : null,
        note: "",
        paymentMethod: this.getPaymentMethod.COD,
        subTotal: this.getTotalPrice,
        totalDiscount: 0,
        orderItems: this.orderItems,
        zoneId: this.getSelectedZone,
        ...this.formData
      };
      try {
        const resWallet = await this.$axios.$post("/orders", payload);
        this.$toast.success("Thank you for the order!");
        this.$store.dispatch("cart/resetCart");
        this.$router.push("/customer/profile/orders");
      } catch (error) {
        console.log(error);
      }
    },

    onStripeSubmit() {
      this.disablePayButton = true;
    },

    stripeError(err) {
      this.disablePayButton = false;
    },

    // set user
    setAuthData() {
      const user = this.$auth.user;
      if (user) {
        const newUser = {
          firstName: user.firstName,
          lastName: user.lastName,
          email: user.email,
          phone: user.phone,
          password: "",
          password_confirmation: "",

          billingAddress: {
            street: user.billingAddress?.street,
            city: user.billingAddress?.city,
            state: user.billingAddress?.state,
            zipcode: user.billingAddress?.zipcode,
            country: user.billingAddress?.country
          },

          shippingAddress: {
            street: user.shippingAddress?.street,
            city: user.shippingAddress?.city,
            state: user.shippingAddress?.state,
            zipcode: user.shippingAddress?.zipcode,
            country: user.shippingAddress?.country
          }
        };
        this.formData = { ...newUser };
      }
    }
  },

  // created
  created() {
    this.setAuthData();
    this.enoughWalletBalance;
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

<style lang="scss" scoped>
.disabledPayment {
  pointer-events: none;
  opacity: 0.6;
}
</style>