<template>
  <div>
    <hero-section></hero-section>
    <food-categories></food-categories>
    <how-it-works></how-it-works>
    <popular-products></popular-products>
    <get-app></get-app>
    <buyer-reviews></buyer-reviews>
  </div>
</template>

<script>
import HeroSection from "~/components/layouts/HeroSection.vue";
import FoodCategories from "~/components/layouts/FoodCategories.vue";
import HowItWorks from "~/components/layouts/HowItWorks.vue";
import PopularProducts from "~/components/layouts/PopularProducts.vue";
import GetApp from "~/components/layouts/GetApp.vue";
import BuyerReviews from "~/components/layouts/BuyerReviews.vue";
export default {
  components: {
    HeroSection,
    FoodCategories,
    HowItWorks,
    PopularProducts,
    GetApp,
    BuyerReviews
  }
};
</script>

<style scoped>
body {
  color: #696969;
}
</style>
