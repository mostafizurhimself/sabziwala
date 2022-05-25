<template>
  <div>
    <!-- Shop Products -->
    <div class="bg-white shadow-sm hover:shadow-lg border border-gray-100 hover:border-gray-200 rounded-lg overflow-hidden mx-auto relative product sm:flex">
      <!-- image -->
      <div class="bg-gray-100 flex justify-center item-center product-image sm:w-48 md:w-80 relative flex-none">
        <img :src="product.thumbnailMediaUrl" class="h-full w-full" alt="product" style="object-fit: cover;">

        <!-- options on hover -->
        <div class="product-options absolute flex items-center justify-center">

          <!-- view button -->
          <nuxt-link :to="`/shop/${product.id}`" class="h-12 w-12 bg-white hover:bg-primary-500 rounded-full shadow-md flex justify-center items-center text-primary-500 hover:text-white cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </nuxt-link>

          <!-- add to cart button -->
          <div class="ml-4 h-12 w-12 bg-white hover:bg-primary-500 rounded-full shadow-md flex justify-center items-center text-primary-500 hover:text-white cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
          </div>

          <!-- wishlist button -->
          <!-- <div class="ml-4 h-12 w-12 bg-white hover:bg-primary-500 rounded-full shadow-md flex justify-center items-center text-primary-500 hover:text-white cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
          </div> -->
        </div>

        <!-- badge -->
        <!-- <div class="absolute top-3 right-3">
          <span class="bg-primary-500 text-white text-xs px-3 py-1 rounded font-semibold">NEW</span>
        </div> -->
      </div>

      <!-- details -->
      <div class="details p-5 sm:p-6 flex-grow">
        <!-- name -->
        <nuxt-link :to="`/shop/${product.id}`" class="text-xl font-semibold block">{{product.name}}</nuxt-link>

        <!-- rating component -->
        <client-only>
          <star-rating :rating='product.averageRatings' :read-only="true" :star-size="15" :padding="4" :increment="0.5" :show-rating="false" active-color="#F59E0B" :star-points="[23,2, 14,17, 0,19, 10,34, 7,50, 23,43, 38,50, 36,34, 46,19, 31,17]"></star-rating>
        </client-only>

        <!-- price -->
        <div class="mt-2 font-bold text-lg">
          <span class="text-primary-500">{{currencyFormat(product.salePrice)}}</span>
          <span class="line-through ml-2 text-primary-100">{{currencyFormat(product.actualPrice)}}</span>
        </div>

        <p class="text-md mt-3"> {{product.description}} </p>
      </div>
    </div>
    <!-- End Shop Products -->

  </div>
</template>

<script>
export default {
  name: "HorizontalProduct",
  props: {
    product: { type: Object }
  }
};
</script>

<style lang="scss" scoped>
.product-options {
  opacity: 0;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -20%);
  transition: all 0.3s ease-in;
}

.product:hover {
  .product-image {
    @apply bg-gray-300;
    transition: all 0.2s ease-in;

    .product-options {
      color: red;
      transform: translate(-50%, -50%);
      opacity: 1;
    }
  }
}
</style>