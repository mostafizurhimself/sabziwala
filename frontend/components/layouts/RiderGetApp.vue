<template>
  <section class="get-app bg-primary-600" v-if="getRiderAppSection">
    <div class="container pt-5">
      <div class="grid grid-cols-1 lg:grid-cols-2">
        <div class="image order-2 lg:order-1 lg:mt-0 px-10 sm:px-0">
          <img :src="getRiderAppSection.primaryMediaUrl" alt="" class="sm:h-96 mx-auto" />
        </div>
        <div class="details flex items-center order-1 lg:order-2 mt-12 lg:mt-0">
          <div class="flex flex-col items-center lg:block">
            <h5 class="text-4xl font-semibold text-white px-10 sm:px-0">
              {{getRiderAppSection.data.title}}
            </h5>
            <p class="text-white mt-4 px-10 sm:px-0">
              {{getRiderAppSection.data.subtitle}}
            </p>

            <div class="">
              <div class="food-buttons sm:flex items-center justify-between md:justify-center lg:justify-start mt-8 ">
                <a :href="getRiderAppSection.data.playStore" target="_blank" class="py-4 px-5 rounded-lg bg-white flex items-center sm:mr-5 mb-5">
                  <img src="/images/getapp/google-play.png" alt="" />
                  <div class="pl-3">
                    <span class="block text-sm text-gray-700">
                      Download it from
                    </span>
                    <span class="text-primary-500 font-semibold">PLAY STORE</span>
                  </div>
                </a>
                <a :href="getRiderAppSection.data.appStore" target="_blank" class="py-4 px-5 rounded-lg bg-white flex items-center mb-5">
                  <img src="/images/getapp/apple.png" alt="" />
                  <div class="pl-3">
                    <span class="block text-sm text-gray-700">
                      Download it from
                    </span>
                    <span class="text-primary-500 font-semibold">APPSTORE</span>
                  </div>
                </a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters({
      getRiderAppSection: "config/getRiderAppSection"
    })
  }
};
</script>

<style lang="scss" scoped>
.get-app {
  background-image: url("/images/bg-shape.png");
  background-repeat: no-repeat;
  background-size: cover;
}

.container {
  padding: 0;
}
</style>
