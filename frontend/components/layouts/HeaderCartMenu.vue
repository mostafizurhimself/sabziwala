<template>
  <div class="bg-white w-60" style=" width: 310px">
    <div v-if="getTotalItem > 0">
      <!-- header -->
      <div class="bg-primary-500 text-white py-2 px-3 flex items-center justify-between">
        <p>{{getTotalItem}} Items Added</p>
        <p @click.prevent="$emit('close')" class="cursor-pointer">Close</p>
      </div>

      <!-- body -->
      <div class="overflow-y-scroll" style="height: 305px;">
        <!-- cart items -->
        <div class="px-4 py-5 border-b border-gray-100" v-for="item in getCartItems" :key="item.id">
          <div class="flex items-start justify-between">
            <div class="flex">
              <div class="h-16 w-16 flex-none">
                <img :src="item.thumbnailMediaUrl" class="w-full  h-full object-cover" alt />
              </div>
              <div class="ml-3">
                <span class="text-md block font-semibold">{{item.name}}</span>
                <span>Price: {{currencyFormat(item.salePrice)}}</span>
              </div>
            </div>

            <div @click.prevent="removeFromCart" class="text-gray-400 hover:text-primary-500 cursor-pointer">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
          </div>

          <!-- items -->
          <div class="flex items-center justify-between font-semibold mt-4">
            <div class="mr-3 relative flex flex-row w-28 h-8">
              <input type="number" @input="changedQuantity(item, $event)" :value="item.quantity" class="w-full font-semibold text-center text-gray-700 border border-gray-200 hover:text-black focus:text-black rounded-lg pl-16" />
              <span class="flex items-center absolute px-4 h-full rounded-l-lg font-semibold text-gray-700 bg-gray-200 uppercase">{{item.unit.code}}</span>
            </div>
            <span>Total: {{currencyFormat(item.salePrice*item.quantity)}}</span>
          </div>
        </div>
      </div>

      <!-- footer -->
      <div class="py-3 px-4 bg-gray-50">
        <!--
                    <div class="text-right flex items-center justify-between text-sm mt-1">
                      <span>Subtotal</span>
                      <span>${{getTotalPrice}}</span>
                    </div>
                    <div class="text-right flex items-center justify-between text-sm mt-1">
                      <span>Shipping</span>
                      <span>$20</span>
                    </div>
        -->
        <div class="text-right flex items-center justify-between font-semibold text-sm mt-1">
          <span>Cart Total</span>
          <span>{{currencyFormat(getTotalPrice)}}</span>
        </div>

        <nuxt-link to="/cart" class="mt-4 mb-1 bg-primary-500 text-white w-full block text-center py-2 rounded-md">
          <span @click="$emit('close')">VIEW CART</span>
        </nuxt-link>
      </div>
    </div>

    <div v-else class="py-3 px-4 h-16 flex items-center justify-center">No Items Added!</div>
  </div>
</template>

<script>
import { mapGetters, mapMutations } from "vuex";
export default {
  name: "HeaderCartMenu",
  computed: {
    ...mapGetters({
      getCartItems: "cart/getCartItems",
      getTotalItem: "cart/getTotalItem",
      getTotalPrice: "cart/getTotalPrice"
    })
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