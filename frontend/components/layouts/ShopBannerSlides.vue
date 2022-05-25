<template>
  <div class="w-full mx-auto">
    <vue-slick-carousel v-bind="bannerSettings">
      <!-- banner -->
      <div v-for="(banner, i) in banners" :key="i">
        <img :src="banner.url" class="w-full" alt="">
      </div>
    </vue-slick-carousel>
  </div>
</template>

<script>
export default {
  name: "bannerSlides",
  props: {
    banners: {
      type: Array,
      required: false
    }
  },
  data() {
    return {
      bannerSettings: {
        dots: false,
        autoplay: true,
        arrows: false,
        edgeFriction: 0.35,
        infinite: true,
        speed: 500,
        pauseOnDotsHover: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        responsive: [
          {
            breakpoint: 690,
            settings: {
              arrows: false
            }
          }
        ]
      }
    };
  }
};
</script>

<style lang="scss" scope>
</style>
