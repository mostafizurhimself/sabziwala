<template>
  <div>
     <!-- Main slider -->
    <splide :options="primaryOptions" ref="primary">
      <splide-slide v-for="(item, index) in images" :key="index">
          <div class="inline-flex justify-center item-center product-image h-full w-full" >
            <img :src="item.url" class="w-full h-full" style="object-fit: cover" alt="product">
          </div>
      </splide-slide>
    </splide>

    <!-- Thumbnail slider -->
    <splide :options="secondaryOptions" ref="secondary" class="mt-2">
      <splide-slide class="secondarySplide" v-for="(item, index) in images" :key="index">
        <img :src="item.url" />
      </splide-slide>
    </splide>
  </div>
</template>

<script>

export default {
        name: "SingleProductSlides",
  props: {
    images: {
      type: Array,
    },
  },
        data() {
            return {
       primaryOptions: {
        type: "loop",
        pagination: false,
        cover: true,
        focus: "center",
        rewind: true,
        pagination: false, 
        arrows: false
        },

      secondaryOptions: {
        
        type: "loop",
        rewind: true,
        gap: "0.5rem",
        pagination: false,
        fixedHeight: 100,
        cover: true,
        isNavigation: true,
        arrows: false,
        perPage: 3,
      }
            }
        },

          mounted() {
    // Set the sync target.
    if (this.$refs.secondary?.splide) {
      this.$refs.primary.sync(this.$refs.secondary.splide);
    }
  }

    }
</script>

<style lang="scss" scoped>
.slick-current {
  .smallImage {
    border: 1px solid #ee1d23 !important;
  }
}

.splide--nav>.splide__track>.splide__list>.splide__slide {
    border: 1px solid transparent;
}

.splide--nav>.splide__track>.splide__list>.splide__slide.is-active {
    border-color: #ee1d23 !important;
}



</style>