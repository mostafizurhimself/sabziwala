<template>
  <div>
    <div>
      <nuxt-link to="/customer/profile/orders" class="inline-flex items-center mb-3 text-gray-400 hover:text-primary-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
        <span class="ml-1">
          Back
        </span>
      </nuxt-link>
    </div>

    <loading :loading="isLoading">
      <!-- invoice details -->
      <div class="sm:flex justify-between items-start">
        <!-- invoice number -->
        <div>
          <div class="flex items-center">
            <h5 class="font-semibold text-lg">Invoice: {{order.invoiceNo}}</h5>
            <the-badge class="ml-3" :value="order.status"></the-badge>
          </div>
          <h5 class="font-normal text-sm">{{order.dateFormatted}}</h5>
          <!-- payment method -->
          <div>
            <h5 class="font-normal text-md mt-3 mb-5">Payment method:
              <span class="uppercase font-semibold" :class="paymentMethodColor">{{order.paymentMethod}}</span>
            </h5>
          </div>
        </div>
        <!-- customer details -->
        <div v-if="order && order.customer " class="sm:text-right">
          <h4 class="font-semibold"> {{order.customer.name}}</h4>
          <h5> {{order.customer.phone}}</h5>
          <div>
            <span>{{order.shippingAddress.street}} </span>
            <br>
            <span>{{order.shippingAddress.state}},
              {{order.shippingAddress.city}},
              {{order.shippingAddress.country}}
            </span>
          </div>
        </div>
      </div>
      <!-- Order Details -->

      <!-- order items -->
      <h5 class="font-semibold text-lg mt-10 mb-3">Order Items</h5>
      <div class="overflow-x-auto">
        <table class="border-collapse border border-gray-200 w-full">
          <!-- header -->
          <thead class="bg-gray-200">
            <tr>
              <th scope="col" class="p-3 text-left">#</th>
              <th scope="col" class="p-3 text-left">PRODUCT NAME</th>
              <th scope="col" class="p-3 text-left">RATE</th>
              <th scope="col" class="p-3 text-left">UNIT</th>
              <th scope="col" class="p-3 text-left">AMOUNT</th>
              <th scope="col" class="p-3 text-left" v-if="order.status == 'delivered'">ACTION</th>
            </tr>
          </thead>
          <!-- body -->
          <tbody class="divide-y devide-gray-200">
            <tr class="hover:bg-gray-50" v-for="(item, i) in order.orderItems" :key="i">
              <td class="py-3 px-4 font-medium">{{i + 1}}</td>
              <td class="py-3 px-4 font-medium">{{item.product.name}}</td>
              <td class="py-3 px-4 whitespace-nowrap">{{item.rateFormatted}}</td>
              <td class="py-3 px-4">{{item.quantity}}{{item.unit.code}}</td>
              <td class="py-3 px-4">{{item.amountFormatted}}</td>
              <td class="py-3 px-4" v-if="order.status == 'delivered'">
                <!-- Refund Request Modal -->
                <modal-comp v-if="item.reviewId == null" headerText="Share Your Experience" :maxWidth="500" class="ml-2 inline-block">
                  <template #button>
                    <button class="bg-transparent hover:bg-green-500 text-green-500 hover:text-white px-2 py-1 border border-green-500 rounded text-xs">Review</button>
                  </template>
                  <template #modal-body="{toggle}">
                    <ReviewModal :orderItem="item" @close="toggle()" @reviewed="hasReview(item)"></ReviewModal>
                  </template>
                </modal-comp>

                <p v-else class="text-sm text-green-500">Reviewed</p>
              </td>
            </tr>
          </tbody>
          <!-- footer -->
          <tfoot class="divide-y devide-gray-200 bg-gray-100">
            <tr>
              <th scope="row" colspan="4" class="py-3 px-4 text-right">Sub Total</th>
              <td colspan="2" class="py-3 px-4">{{order.subTotalFormatted}}</td>
            </tr>
            <tr>
              <th scope="row" colspan="4" class="py-3 px-4 text-right">Total Discount</th>
              <td colspan="2" class="py-3 px-4">{{order.totalDiscountFormatted}}</td>
            </tr>
            <tr>
              <th scope="row" colspan="4" class="py-3 px-4 text-right">Grand Total</th>
              <td colspan="2" class="py-3 px-4">{{order.grandTotalFormatted}}</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </loading>
  </div>
</template>

<script>
import ReviewModal from "~/components/layouts/ReviewModal.vue";
export default {
  components: { ReviewModal },
  data() {
    return {
      order: []
    };
  },

  computed: {
    paymentMethodColor() {
      if (this.order.paymentMethod == "stripe") {
        return "text-blue-600";
      } else if (this.order.paymentMethod == "wallet") {
        return "text-primary-500";
      } else {
        return "text-yellow-500";
      }
    }
  },

  methods: {
    async hasReview(item) {
      item.reviewId = !null;
    }
  },

  async fetch() {
    let resOrder = await this.$axios.$get(`/orders/${this.$route.params.id}`);
    this.order = resOrder.data;
    this.stopLoading();
  }
};
</script>

<style lang="scss" scoped>
</style>