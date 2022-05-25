<template>
  <div class="food-services">
    <div class="container my-10 md:my-20">
      <!-- section header -->
      <section-header>
        <template #title>
          How it Works
        </template>
        <template #subtitle>
          Completely network impactful users whereas next-generation
          applications engage out thinking via tactical action.
        </template>
      </section-header>

      <!-- Content -->
      <div class="flex flex-wrap justify-around mt-16">
        <div class="service-item cursor-default" v-for="(item, i) in getHowItWorks" :key="i">
          <div class="service-inner">
            <div class="service-thumb">
              <img :src="item.primaryMediaUrl" alt="food-service" />

              <span class="service-steps">{{i+1}} <br> STEP </span>
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
  name: "HowItWorks",

  computed: {
    ...mapGetters({
      getHowItWorks: "config/getHowItWorks"
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
      box-shadow: 0 0 10px rgb(129 72 17 / 20%);
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

        @apply rounded-full text-white bg-primary-500 border-4 border-white;
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
