<template>
  <div class="food-services">
    <div class="container my-10 lg:my-20">
      <!-- section header -->
      <section-header>
        <template #title>
          Why Work with Us
        </template>
        <template #subtitle>
          Completely network impactful users whereas next-generation
          applications engage out thinking via tactical action.
        </template>
      </section-header>

      <!-- Content -->
      <div class="flex flex-wrap justify-around mt-16">
        <div class="service-item cursor-pointer" v-for="(item, i) in getWorkWithUs" :key="i">
          <div class="service-inner">
            <div class="service-thumb">
              <div>
                <img :src="item.primaryMediaUrl" class="h-10" alt="food-service" />
              </div>

              <span class="service-steps">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
              </span>
            </div>
            <div class="service-content">
              <h6 class="text-lg">{{item.title}}</h6>
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
  data() {
    return {};
  },
  computed: {
    ...mapGetters({
      getWorkWithUs: "config/getWorkWithUs"
    })
  }
};
</script>

<style lang="scss" scoped>
.service-item {
  width: calc(100% / 1);
  margin-bottom: 40px;

  @media (min-width: 768px) {
    width: calc(100% / 2);
  }

  @media (min-width: 1023px) {
    width: calc(100% / 4);
    margin-bottom: 0;
  }

  .service-inner {
    .service-thumb {
      width: 200px;
      height: 200px;
      text-align: center;
      border-radius: 100%;
      margin: 0 auto 35px;
      border: 15px solid #fff;
      box-shadow: 0 0 10px rgb(129 72 17 / 15%);
      position: relative;

      img {
        height: auto;
        max-width: 100%;
        border-radius: 100%;
      }

      .service-steps {
        width: 60px;
        height: 60px;
        padding: 8px;
        line-height: 1;
        position: absolute;
        top: -15px;
        right: -15px;
        text-transform: uppercase;
        transition: all 0.3s ease;

        @apply flex justify-center items-center rounded-full text-white bg-primary-500 border-4 border-white;
      }
    }

    .service-content {
      text-align: center;
      @apply font-semibold;
    }
  }

  .service-inner:hover {
    .service-thumb {
      .service-steps {
        @apply bg-white text-primary-500 border-primary-500;
      }
    }

    .service-content {
      @apply text-primary-500;
    }
  }
}
</style>
