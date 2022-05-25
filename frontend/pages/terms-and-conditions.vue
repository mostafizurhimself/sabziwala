<template>
  <div>
    <!-- top banner -->
    <the-banner bannerLink="/images/banners/terms-condition-banner.jpg">
      <template #header>
        <span class="text-2xl md:text-4xl mt-5 sm:mt-0 inline-block">TERMS AND CONDITIONS</span>
      </template>
      <template #breadcrumbs>
        <li>
          <nuxt-link to="/" class="font-semibold">HOME</nuxt-link>
        </li>
        <li><span class="mx-2">-</span></li>
        <li>
          <span class="font-semibold text-primary-500">TERMS AND CONDITIONS</span>
        </li>
      </template>
    </the-banner>

    <div class="container" v-if="getTermsAndCondition && getTermsAndCondition.data">
      <div class="pb-10">
        <!-- GENERAL TERMS AND CONDITIONS -->
        <div>
          <h2 class="uppercase pt-8 pb-3 font-bold text-2xl terms-header">
            GENERAL TERMS AND CONDITIONS
          </h2>
          <div v-html="getTermsAndCondition.data.general">
          </div>
        </div>

        <!-- Privacy Policy -->
        <div>
          <h2 class="uppercase pt-8 pb-3 mt-0 font-bold text-2xl terms-header">
            Privacy Policy
          </h2>
          <div v-html="getTermsAndCondition.data.privacy">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "terms-and-conditions",
  computed: {
    ...mapGetters({
      getTermsAndCondition: "config/getTermsAndCondition"
    })
  }
};
</script>

<style lang="scss" scoped>
</style>
