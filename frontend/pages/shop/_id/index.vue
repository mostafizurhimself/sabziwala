<template>
  <div v-if="product">
    <!-- banner -->
    <!-- <the-banner class="hidden sm:block" bannerLink="/images/food-categories2.jpg">
      <template #header>{{product.name}}</template>
      <template #breadcrumbs>
        <li>
          <nuxt-link to="/" class="font-semibold">Home</nuxt-link>
        </li>
        <li><span class="mx-2">-</span></li>
        <li>
          <nuxt-link to="/shop" class="font-semibold">Shop</nuxt-link>
        </li>
        <li><span class="mx-2">-</span></li>
        <li>
          <span class="font-semibold text-primary-500">{{product.name}}</span>
        </li>
      </template>
    </the-banner> -->

    <!-- product -->
    <div class="container lg:flex my-5 md:my-10">
      <!-- left side -->
      <div class="lg:w-9/12 ">
        <div class="lg:flex">
          <!-- Image -->
          <div class="lg:w-6/12">
            <client-only>
              <single-product-slides :images="product.mediaCollection"></single-product-slides>
            </client-only>

          </div>

          <!-- product details -->
          <div class="lg:w-6/12 mt-6 lg:mt-3 lg:px-6">
            <!-- rating -->
            <div class="rating flex items-center">
              <!-- rating component -->
              <client-only>
                <star-rating :rating="product.averageRatings" :read-only="true" :star-size="12" :padding="4" :increment="0.5" :show-rating="false" active-color="#F59E0B" :star-points="[23,2, 14,17, 0,19, 10,34, 7,50, 23,43, 38,50, 36,34, 46,19, 31,17]" style="margin-top: -2px"></star-rating>
              </client-only>

              <span class="text-gray-700 font-bold text-xs ml-1 mt-1">
                <span v-if="product.ratings && product.ratings.length">( {{product.ratings.length}} Reviews )</span>
                <span v-else>( 0 Reviews )</span>
              </span>
            </div>

            <h3 class="font-bold text-xl mt-2">{{product.name}}</h3>

            <!-- price -->
            <div class="mt-2 font-bold text-2xl">
              <span class="text-primary-500">{{currencyFormat(product.salePrice)}}</span>
              <span class="line-through ml-2 text-primary-100">{{currencyFormat(product.actualPrice)}}</span>
            </div>

            <!-- tags -->
            <div class="border-t border-b border-gray-200 py-4 mt-5">
              <h5 class="text-sm ">Tags:
                <span class="ml-2 font-semibold">
                  {{ product.tags.map(tag => tag.name).join(', ') }}
                </span>
              </h5>
            </div>

            <!-- quantity and add to cart button  -->
            <div class="mt-5 flex">
              <div class="w-28 h-12">
                <div class="relative flex flex-row w-full h-12">
                  <input type="number" value="1" class="w-full font-semibold text-center text-gray-700 border border-gray-200 hover:text-black focus:text-black rounded-lg pl-16" />
                  <span class="absolute py-3 px-4 rounded-l-lg font-semibold text-gray-700 bg-gray-200 uppercase">{{product.unit.code}}</span>
                </div>
              </div>
              <button-field :disabled="!selectedZone" type="button" @click="addToCart" label="ADD TO CART" class="rounded-lg ml-4"></button-field>
            </div>

            <p v-if="!selectedZone" class="mt-2 text-sm text-primary-500 font-semibold cursor-pointer">Please select a zone first to check product availability!</p>

            <!-- wishlist -->
            <div class="flex items-center text-sm mt-5">
              <wishlist-button :favourite="product.isFavourite" @click="toggleWishlist"></wishlist-button>
              <span v-if="product.isFavourite == false" class="ml-1">Add to Wishlist</span>
              <span v-else class="ml-1">Added to Wishlist</span>
            </div>

            <!-- share -->
            <div class="border-t border-b border-gray-200 py-4 mt-5 flex">
              <h5 class="text-sm">Share:</h5>
              <div class="flex items-center">
                <client-only>
                  <social-share :link="shareLink" :sharingProduct="product" :title="product.name"></social-share>
                </client-only>
              </div>
            </div>

          </div>
        </div>

        <!-- description and reviews -->
        <div class="mt-12 lg:pr-6">
          <!-- nav -->
          <div class="flex border-b-2 border-gray-200">
            <h5 class="mr-7 pb-4 font-semibold cursor-pointer" :class="{'active' : activeComponent == 'product-description'}" @click="activeComponent = 'product-description'">Description</h5>
            <h5 class="mr-7 pb-4 font-semibold cursor-pointer" :class="{'active' : activeComponent == 'product-reviews'}" @click="activeComponent = 'product-reviews'">Reviews</h5>
          </div>

          <!-- body -->
          <div class="my-8">
            <div v-if="activeComponent == 'product-description'">
              <product-description :description="product.description"></product-description>
            </div>
            <div v-else>
              <product-reviews :reviews="product.ratings" :averageRatings="product.averageRatings"></product-reviews>
            </div>
          </div>
        </div>
      </div>

      <!-- Right side -->
      <div class="lg:w-3/12 ">

        <!-- Related products -->
        <div class="border border-gray-200 mt-6 lg:mt-0 px-5">
          <h4 class="font-semibold my-5">Related products</h4>

          <div>
            <div class="flex border-t border-gray-200 py-5" v-for="relatedProduct in relatedProducts" :key="relatedProduct.id">
              <!-- image -->
              <div class="h-20 w-20 flex-none">
                <img :src="relatedProduct.thumbnailMediaUrl" style="object-fit: contain" alt="product">
              </div>
              <!-- details -->
              <div class="ml-3">
                <div class="rating flex items-center text-yellow-500 text-xs">
                  <!-- rating component -->
                  <client-only>
                    <star-rating :rating="relatedProduct.averageRatings" :read-only="true" :star-size="12" :padding="4" :increment="0.5" :show-rating="false" active-color="#F59E0B" :star-points="[23,2, 14,17, 0,19, 10,34, 7,50, 23,43, 38,50, 36,34, 46,19, 31,17]" style="margin-top: -3px"></star-rating>
                  </client-only>
                </div>
                <!-- name -->
                <nuxt-link :to="`/shop/${relatedProduct.id}`" class="text-md font-semibold mt-2 inline-block">{{relatedProduct.name}}</nuxt-link>
                <!-- price -->
                <div class="font-bold text-sm mt-1">
                  <span class="text-primary-500">{{currencyFormat(relatedProduct.salePrice)}}</span>
                  <span class="line-through ml-2 text-primary-100">{{currencyFormat(relatedProduct.actualPrice)}}</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- banner -->
        <div class="mt-5">
          <client-only>
            <shop-banner-slides :banners="banners"></shop-banner-slides>
          </client-only>
        </div>

      </div>
    </div>

  </div>
</template>

<script>
import ProductDescription from "~/components/layouts/ProductDescription.vue";
import ProductReviews from "~/components/layouts/ProductReviews.vue";
import SingleProductSlides from "~/components/layouts/SingleProductSlides.vue";
import ShopBannerSlides from "~/components/layouts/ShopBannerSlides.vue";
import { mapGetters } from "vuex";

export default {
  name: "ProductSinglePage",

  components: {
    SingleProductSlides,
    ProductDescription,
    ProductReviews,
    ShopBannerSlides
  },

  data() {
    return {
      product: null,
      relatedProducts: null,
      activeComponent: "product-description",
      banners: [
        {
          url: "/images/banners/01.jpg"
        },
        {
          url: "/images/banners/02.jpg"
        }
      ]
    };
  },

  methods: {
    // add to cart method
    addToCart() {
      this.$store.dispatch("cart/addToCart", this.product);
    },

    // toggling wishlist
    async toggleWishlist() {
      if (this.$auth.loggedIn) {
        this.product.isFavourite = !this.product.isFavourite;
        let res = await this.$axios.$post(
          `/customer/favourites/${this.$route.params.id}/toggle`
        );
        this.product.isFavourite = res.isFavourite;
      } else {
        this.$router.push("/login");
      }
    }
  },

  computed: {
    ...mapGetters({
      selectedZone: "zone/getSelectedZone"
    }),

    // genarate link for sharing product
    shareLink() {
      return `${process.env.APP_URL}shop/${this.$route.params.id}`;
    }
  },

  async fetch() {
    if (this.$auth.loggedIn) {
      // fetching product
      let resProduct = await this.$axios.$get(
        `/products/${this.$route.params.id}/auth`
      );
      this.product = resProduct.data;
      this.relatedProducts = resProduct.relatedProducts;
    } else {
      // fetching product
      let resProduct = await this.$axios.$get(
        `/products/${this.$route.params.id}`
      );
      this.product = resProduct.data;
      this.relatedProducts = resProduct.relatedProducts;
    }
  }
};
</script>

<style lang="scss" scoped>
.active {
  margin-bottom: -2px;
  @apply border-b-2 border-primary-500 text-primary-500;
}
</style>