<template>
  <div>
    <!-- banner -->
    <the-banner v-if="getRiderHeroSection && getRiderHeroSection.data" :bannerLink="getRiderHeroSection.primaryMediaUrl">
      <template #header>
        <span class="text-2xl md:text-4xl mt-5 sm:mt-0 inline-block">{{getRiderHeroSection.data.title}}</span>
      </template>
      <template #breadcrumbs>
        <div>
          <h5 class="font-extralight text-lg md:text-2xl text-white">{{getRiderHeroSection.data.subtitle}}</h5>
          <nuxt-link to="/rider/register" class="inline-block mt-5 py-2 px-4 bg-primary-500 rounded-lg text-sm">APPLY NOW</nuxt-link>
        </div>
      </template>
    </the-banner>

    <rider-how-it-works></rider-how-it-works>

    <!-- required details -->
    <!-- <div class="bg-primary-500 text-white rounded-lg py-8 px-12 md:w-10/12 lg:w-7/12 mx-auto shadow">
        <h6 class="text-2xl font-semibold">All that is required to apply</h6>
        <ul class="mt-5 text-md">
          <li class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="ml-1">
              Android phone (4.2 or newer) or iPhone 4S or newer.
            </span>
          </li>
          <li class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="ml-1">
              Bicycle, scooter or motorbike.
            </span>
          </li>
          <li class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="ml-1">
              National Identity Card
            </span>
          </li>
          <li class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="ml-1">
              Must be 18+ years of age
            </span>
          </li>
        </ul>
    </div>-->

    <RiderGetApp class="mt-5 md:mt-10 lg:mt-20"></RiderGetApp>

    <div class="container">
      <!-- faq -->
      <div class="md:w-10/12 lg:w-7/12 mx-auto my-10 lg:my-20">
        <!-- section header -->
        <section-header>
          <template #title>Frequently Asked Questions</template>
          <template #subtitle>Here you'll be able find answers your questions</template>
        </section-header>

        <div class="mt-10">
          <client-only>
            <VueFaqAccordion :items="getRiderFaqs" />
          </client-only>
        </div>
      </div>

      <div class="text-center mb-8 md:mb-16">
        <img src="/images/banners/rider.png" alt="rider image" class="h-36 mx-auto" />
        <h5 class="font-semibold text-xl mt-5">Already a Sabziwalay rider?</h5>
        <a href="/rider/login" @click.prevent="handleUserLogin" class="inline-block mt-3 py-2 px-4 bg-primary-500 rounded-lg text-sm text-white cursor-pointer">LOG IN</a>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import VueFaqAccordion from "vue-faq-accordion";
import RiderGetApp from "~/components/layouts/RiderGetApp.vue";
import RiderHowItWorks from "~/components/layouts/RiderHowItWorks.vue";
export default {
  name: "BecomeRider",
  components: { RiderHowItWorks, RiderGetApp, VueFaqAccordion },

  methods: {
    async handleUserLogin() {
      if (this.$auth.loggedIn && this.$auth.user.type === "customer") {
        await this.$auth.logout();
      }
      this.$router.push("/rider/login");
    }
  },

  computed: {
    ...mapGetters({
      getRiderHeroSection: "config/getRiderHeroSection",
      getRiderFaqs: "config/getRiderFaqs"
    })
  }
};
</script>

<style lang="scss">
.faq-wrapper {
  margin-left: auto !important;
  margin-right: auto !important;
}

.accordion {
  border: none !important;
}

.accordion__item {
  margin-top: 13px !important;
  border-bottom: none !important;

  .accordion__title {
    background-color: #f8f5f2 !important;
    padding: 12px 20px !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
  }

  .accordion__value {
    padding: 10px 20px !important;
  }

  .accordion__toggle-button {
    transition: all 0.01s !important;
  }
}
</style>