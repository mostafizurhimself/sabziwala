<template>
  <loading :loading="isLoading">
    <div>
      <h5 v-if="hasFavourites" class="mb-5 font-semibold md:text-xl">Your wishlist</h5>
      <!-- wishlist items -->
      <div class="overflow-x-scroll md:overflow-hidden w-full">
        <table v-if="hasFavourites" class="table-auto w-full border border-collapse rounded-md min-w-xl">
          <thead>
            <tr class="bg-gray-100">
              <th class="w-0.5/4 px-4 py-3 text-left">Image</th>
              <th class="w-2/4 px-4 py-3 text-left">Name</th>
              <th class="w-1/4 px-4 py-3 text-left whitespace-nowrap">Sale Price</th>
              <th class="w-0.5/4 px-4 py-3 text-left">Remove</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr v-for="(item, i) in favourites" :key="i">
              <td class="px-4 py-3 p-3">
                <div class="h-16 flex justify-start w-full">
                  <nuxt-link :to="`/shop/${item.id}`" class="flex-none">
                    <img :src="item.thumbnailMediaUrl" class=" h-full object-cover" :alt="item.name">
                  </nuxt-link>
                </div>
              </td>
              <td class="px-4 py-3 text-left font-semibold">
                <nuxt-link :to="`/shop/${item.id}`" class="hover:text-primary-500">
                  {{item.name}}
                </nuxt-link>
              </td>
              <td class="px-4 py-3 text-left ">{{currencyFormat(item.salePrice)}}</td>
              <td class="px-4 py-3 text-left">
                <div @click.prevent="removeFromWishlist(item, i)" class="text-gray-400 hover:text-primary-500 cursor-pointer  w-full">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
              </td>
            </tr>
          </tbody>
        </table>

        <div v-else class="py-10 w-full border border-gray-200 flex items-center justify-center">
          <p class="text-gray-600 ">Please add a product to wishlist first!</p>
        </div>
      </div>
    </div>
  </loading>
</template>

<script>
export default {
  name: "ProfileWishlist",
  data() {
    return {
      favourites: []
    };
  },

  computed: {
    hasFavourites() {
      return this.favourites && this.favourites.length;
    }
  },

  methods: {
    async removeFromWishlist(item, i) {
      try {
        const resToggleFav = await this.$axios.$post(
          `/customer/favourites/${item.id}/toggle`
        );
        this.favourites.splice(i, 1);
        // this.favourites = this.favourites.filter(
        //   item => item.id != resresToggleFav.id
        // );
      } catch (error) {
        console.log(error);
      }
    }
  },

  async fetch() {
    let resFav = await this.$axios.$get("/customer/favourites");
    this.favourites = resFav.data;
    this.stopLoading();
  }
};
</script>

<style lang="scss" scoped>
</style>