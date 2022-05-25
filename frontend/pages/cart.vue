<template>
  <div class="container my-5 md:my-10 lg:my-20">
    <div class="lg:flex">
      <div class="lg:w-9/12 lg:mr-5">
        <h5 class="font-semibold text-lg mb-3">Cart Items</h5>
        <!-- cart item -->
        <div v-if="getTotalItem > 0" class="overflow-x-scroll md:overflow-hidden w-full">
          <table class="table-auto w-full border border-collapse rounded-md min-w-xl">
            <thead>
              <tr class="bg-gray-100">
                <th class="w-1/6 px-4 py-3 hidden md:block">Product</th>
                <th class="w-1/6 px-4 py-3">Name</th>
                <th class="w-1/6 px-4 py-3">Price</th>
                <th class="w-1/6 px-4 py-3">Quantity</th>
                <th class="w-1/6 px-4 py-3">Total</th>
                <th class="w-1/6 px-4 py-3">Remove</th>
              </tr>
            </thead>
            <tbody class=" divide-y">
              <tr v-for="item in getCartItems" :key="item.id" class="">
                <td class="px-4 py-3 hidden md:flex justify-center p-3">
                  <div class="h-16 w-16">
                    <img :src="item.thumbnailMediaUrl" class="w-full h-full object-cover" alt="">
                  </div>
                </td>
                <td class="px-4 py-3 text-center font-semibold"> {{item.name}} </td>
                <td class="px-4 py-3 text-center">{{currencyFormat(item.salePrice)}}</td>
                <td class="px-4 py-3 ">
                  <div class="relative flex w-28 h-8">
                    <input type="number" @input="changedQuantity(item, $event)" :value="item.quantity" class="w-full font-semibold text-center text-gray-700 border border-gray-200 hover:text-black focus:text-black rounded-lg pl-16" />
                    <span class="flex items-center absolute px-4 h-full rounded-l-lg font-semibold text-gray-700 bg-gray-200 uppercase">{{item.unit.code}}</span>
                  </div>
                </td>
                <td class="px-4 py-3 text-center"><span class="font-semibold">{{currencyFormat(item.salePrice*item.quantity)}} </span> </td>
                <td class="px-4 py-3 text-center">
                  <div @click.prevent="removeFromCart" class="text-gray-400 hover:text-primary-500 cursor-pointer flex justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- if no cart items -->
        <div v-else>
          <div class="flex flex-col items-center justify-center text-gray-300 h-44 bg-gray-50 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
              <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z" />
              <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd" />
            </svg>
            <p class="mt-2 text-gray-400">Your cart is Empty!</p>
          </div>
        </div>
      </div>
      <div class="md:w-6/12 lg:w-3/12 mt-10 lg:mt-0">
        <h5 class="font-semibold text-lg mb-3">Cart Details</h5>

        <div class="bg-gray-200 p-3 rounded-md">
          <h6 class="flex justify-between">
            <span>
              Cart Total:
            </span>
            <span class="font-semibold">
              {{currencyFormat(getTotalPrice)}}
            </span>
          </h6>
        </div>

        <!-- minimum amount notice -->
        <div v-if="minimumAmountNotice" class="flex items-start mt-4 text-primary-500">
          <InfoIcon class="flex-none" />
          <span class="block ml-1">You have to add more than Rs. 100 to place the order.</span>
        </div>

        <nuxt-link to="/checkout" :class="{'disabled' : minimumAmountNotice}" class="mt-3 bg-primary-500 text-white w-full inline-block py-3 px-3 text-center rounded-md">PROCEED TO CHECKOUT</nuxt-link>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapMutations } from "vuex";
export default {
  name: "Cart",
  computed: {
    ...mapGetters({
      getCartItems: "cart/getCartItems",
      getTotalItem: "cart/getTotalItem",
      getTotalPrice: "cart/getTotalPrice"
    }),

    minimumAmountNotice() {
      return !(this.getTotalPrice >= 100);
    }
  },

  methods: {
    ...mapMutations({
      cartItemQuantity: "cart/CART_ITEM_QUANTITY"
    }),

    removeFromCart() {
      this.$store.dispatch("cart/removeFromCart", this.item);
    },

    changedQuantity(item, e) {
      this.cartItemQuantity({
        item,
        val: e.target.value
      });
    }
  }
};
</script>

<style lang="scss" scoped>
.disabled {
  pointer-events: none;
  opacity: 0.6;
}
</style>