<template>
  <div>
    <!-- top banner -->
    <the-banner v-if="getContactPageHero" :bannerLink="getContactPageHero.primaryMediaUrl">
      <template #header>{{getContactPageHero.data.title}}</template>
      <template #breadcrumbs>
        <li>
          <nuxt-link to="/" class="font-semibold">Home</nuxt-link>
        </li>
        <li><span class="mx-2">-</span></li>
        <li>
          <span class="font-semibold text-primary-500">Contact</span>
        </li>
      </template>
    </the-banner>

    <!-- details -->
    <div class="py-5 md:py-10 lg:py-20" style="background: #F8F5F2">
      <div class="container ">
        <div class="information bg-white shadow-md rounded-lg w-full lg:flex text-gray-700 py-10 px-8">
          <!-- information -->
          <div class="lg:w-1/2" v-if="getWebsiteSettings && getWebsiteSettings.data">
            <h5 class="font-semibold text-xl">Contact Information</h5>
            <!-- 1st -->
            <div class="flex items-start mt-8 w-full">
              <HomeIcon class="h-12 w-12 text-primary-500 flex-none" />
              <div class="ml-3 md:w-3/5">
                <h6 class="uppercase font-semibold">office address</h6>
                <p class="text-gray-600 mt-1">
                  {{getWebsiteSettings.data.street}},
                  {{getWebsiteSettings.data.city}} -
                  {{getWebsiteSettings.data.zip }},
                  {{getWebsiteSettings.data.country}}
                </p>
              </div>
            </div>
            <!-- 2nd -->
            <div class="flex items-start mt-5 w-full">
              <PhoneIcon class="h-12 w-12 text-primary-500 flex-none" />
              <div class="ml-3 md:w-3/5">
                <h6 class="uppercase font-semibold">Phone</h6>
                <p class="text-gray-600 mt-1">
                  {{getWebsiteSettings.data.phone}}
                </p>
              </div>
            </div>
            <!-- 3rd -->
            <div class="flex items-start mt-5 w-full">
              <EmailIcon class="h-12 w-12 text-primary-500 flex-none" />
              <div class="ml-3 md:w-3/5">
                <h6 class="uppercase font-semibold">email address</h6>
                <p class="text-gray-600 mt-1">{{getWebsiteSettings.data.email}}</p>
              </div>
            </div>
          </div>
          <!-- form -->
          <div class="lg:w-1/2 mt-10 lg:mt-0">
            <h5 class="font-semibold text-xl">Send Us A Message</h5>
            <div class="mt-8 grid grid-cols-2 gap-4">
              <input-field class="col-span-2 md:col-span-1" v-model="formData.name" placeholder="Your Name"></input-field>
              <input-field class="col-span-2 md:col-span-1" v-model="formData.email" placeholder="Your Email"></input-field>
              <input-field class="col-span-2" v-model="formData.subject" placeholder="Subject"></input-field>
              <text-field class="col-span-2" placeholder="Your Query" v-model="formData.message" row="5"></text-field>
              <button-field type="button" @click="submit" class="w-44 whitespace-nowrap uppercase py-3" label="Submit message"></button-field>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "Contact",
  data() {
    return {
      formData: {
        name: "",
        email: "",
        subject: "",
        message: ""
      }
    };
  },
  computed: {
    ...mapGetters({
      getContactPageHero: "config/getContactPageHero",
      getWebsiteSettings: "config/getWebsiteSettings"
    })
  },

  methods: {
    async submit() {
      let query = await this.$axios.$post("/contacts", this.formData);
      this.formData = {};
    }
  }
};
</script>

<style lang="scss" scoped>
.information {
  background-image: url("/images/contact-bg.png");
  background-repeat: no-repeat;
  background-position: left bottom;
  background-size: 400px;
}
</style>
