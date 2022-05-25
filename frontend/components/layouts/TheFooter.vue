<template>
  <footer class="bg-primary-600" v-if="getWebsiteSettings">
    <div class="bg-shape flex items-center justify-center">
      <div class="container">
        <div>
          <div class="footer-top flex flex-col items-center pt-20 pb-16">
            <!-- logo -->
            <div class="brand">
              <img class="h-16" :src="getWebsiteSettings.primaryMediaUrl" alt="">
            </div>
            <!-- social icons -->
            <div class="flex items-center justify-center mt-4" v-if="getWebsiteSettings && getWebsiteSettings.data">
              <a :href="getWebsiteSettings.data.facebook" target="_blank" class="icon">
                <Facebook class="h-5 w-5" />
              </a>
              <a :href="getWebsiteSettings.data.twitter" target="_blank" class="icon ">
                <Twitter class="h-5 w-5" />
              </a>
              <a :href="getWebsiteSettings.data.instagram" target="_blank" class="icon">
                <Instagram class="h-5 w-5" />
              </a>
            </div>
            <!-- footer-menu -->
            <div class="footer-menu mt-4">
              <ul class="flex flex-wrap justify-center">
                <li class="footer-menu-item m-1 px-4 uppercase text-white">
                  <nuxt-link to="/terms-and-conditions">terms & conditions</nuxt-link>
                </li>
                <li class="footer-menu-item m-1 px-4 uppercase text-white">
                  <nuxt-link to="/payment-and-refunds">payment & refunds</nuxt-link>
                </li>
                <li class="footer-menu-item m-1 px-4 uppercase text-white">
                  <nuxt-link to="/rider/become-rider">become a rider</nuxt-link>
                </li>
              </ul>
            </div>
          </div>
          <div class="footer-bottom border-t">
            <p class="text-center my-7 text-white">
              © 2021
              <span v-if="getWebsiteSettings && getWebsiteSettings.data">
                <nuxt-link to='/'>{{getWebsiteSettings.data.name}}</nuxt-link>
              </span>
            </p>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "TheFooter",
  computed: {
    ...mapGetters({
      getWebsiteSettings: "config/getWebsiteSettings"
    })
  }
};
</script>

<style lang="scss" scoped>
.bg-shape {
  background-image: url("/images/bg-shape.png");
  background-repeat: no-repeat;
  background-size: cover;
}

.icon {
  cursor: pointer;
  position: relative;
  width: 40px;
  height: 40px;
  text-align: center;
  padding: 0;
  margin: 5px 8px;
  @apply bg-white flex justify-center items-center rounded-full;
}

.icon:hover {
  transform: translateY(-4px);
}
</style>
