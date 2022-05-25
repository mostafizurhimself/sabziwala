<template>
  <section class="get-app bg-primary-600" v-if="getAppSection">
    <div class="container pt-5">
      <div class="grid grid-cols-1 lg:grid-cols-2">
        <!-- image -->
        <div class="image order-2 lg:order-1 mt-12 lg:mt-0 px-10 sm:px-0 flex justify-center lg:pt-10">
          <img :src="getAppSection.primaryMediaUrl" alt="" class="h-64 lg:h-96" />
        </div>
        <!-- details -->
        <div class="details flex items-center justify-center order-1 lg:order-2 pt-14 lg:pt-0">
          <div class="flex flex-col items-center lg:block">
            <h5 class="text-2xl md:text-4xl font-semibold text-white px-10 sm:px-0">
              {{getAppSection.data.title}}
            </h5>
            <p class="text-white mt-4 px-10 sm:px-0">
              {{getAppSection.data.subtitle}}
            </p>

            <!-- buttons -->
            <div class="food-buttons sm:flex items-center justify-between md:justify-center lg:justify-start mt-8 ">
              <a :href="getAppSection.data.playStore" target="_blank" class="py-4 px-5 shadow rounded-lg bg-white flex items-center ">
                <img src="/images/getapp/google-play.png" alt="" />
                <div class="pl-3">
                  <span class="block text-sm text-gray-700">
                    Download it from
                  </span>
                  <span class="text-primary-500 font-semibold">PLAY STORE</span>
                </div>
              </a>
              <a :href="getAppSection.data.appStore" target="_blank" class="py-4 px-5 shadow rounded-lg bg-white flex items-center sm:ml-5 mt-5 sm:mt-0">
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
  </section>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "GetApp",
  computed: {
    ...mapGetters({
      getAppSection: "config/getAppSection"
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

input {
  height: 70px;

  border: none;
  outline: none;
}
</style>
