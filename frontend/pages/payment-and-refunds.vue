<template>
  <div>
    <!-- top banner -->
    <the-banner bannerLink="/images/banners/payment-banner.jpg">
      <template #header>
        <span class="text-2xl md:text-4xl mt-5 sm:mt-0 inline-block uppercase">Payments and Refunds</span>
      </template>
      <template #breadcrumbs>
        <li>
          <nuxt-link to="/" class="font-semibold">Home</nuxt-link>
        </li>
        <li><span class="mx-2">-</span></li>
        <li>
          <span class="font-semibold text-primary-500 ">Payments and Refunds</span>
        </li>
      </template>
    </the-banner>

    <div class="container" v-if="getPaymentAndRefunds && getPaymentAndRefunds.data">
      <div class="pb-10">
        <!-- TERMS OF PURCHASE -->
        <div>
          <h2 class="uppercase pt-8 pb-3 font-bold text-2xl terms-header">
            TERMS OF PURCHASE
          </h2>
          <div v-html="getPaymentAndRefunds.data.purchase"></div>
        </div>

        <!-- REFUNDS -->
        <div>
          <h2 class="uppercase pt-8 pb-3 mt-0 font-bold text-2xl terms-header">
            REFUNDS
          </h2>
          <div v-html="getPaymentAndRefunds.data.refunds"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "payments-and-refunds",
  computed: {
    ...mapGetters({
      getPaymentAndRefunds: "config/getPaymentAndRefunds"
    })
  }
};
</script>

<style lang="scss" scoped>
</style>
