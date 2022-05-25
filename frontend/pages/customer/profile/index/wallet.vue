<template>
  <div>
    <!-- <p class="bg-gray-200 p-5 font-semibold">Sabziwalay Wallet</p> -->

    <div class="pb-5 border-b border-gray-200 flex justify-between items-start">
      <div>
        <h5 class="font-medium text-3xl">{{currencyFormat($auth.user.balance)}}</h5>
        <h6 class="text-sm text-gray-500">Wallet Balance</h6>
      </div>
      <div>
        <!-- modal -->
        <modal-comp headerText="Add Balance">
          <!-- modal button -->
          <template #button>
            <button-field class="text-xs">
              <template #label>
                <span class="flex items-center">
                  <PlusIcon class="mr-2" />Balance
                </span>
              </template>
            </button-field>
          </template>

          <!-- bodal body -->
          <template #modal-body="{toggle}">
            <add-balance @close="toggle()" @success="getResults"></add-balance>
          </template>
        </modal-comp>
      </div>
    </div>

    <!-- Transactions history -->
    <h5 class="py-5 font-semibold md:text-xl">Wallet Transaction History</h5>
    <!-- single history -->
    <loading :loading="isLoading">
      <div class="md:flex justify-between items-start border-t border-gray-200 py-4" v-for="item in transactions.data" :key="item.id">
        <!-- icon and details -->
        <div class="flex items-start">
          <img src="/images/icons/wallet.png" class="h-8" alt />
          <!-- for adding balance -->
          <div class="ml-3">
            <h6 class="font-medium">
              <span v-if="item.orderId">Payment for
                <nuxt-link to="" class="font-semibold hover:text-primary-500 hover:underline"> {{item.order.invoiceNo}} </nuxt-link>
              </span>
              <span v-else>{{item.description}}</span>
              <span>-</span>
              <span class="text-blue-600 capitalize">{{item.method}}</span>
            </h6>
            <!-- Transaction Amount from mediam screen -->
            <span class="font-semibold text-lg whitespace-nowrap block md:hidden" :class="[item.amount > 0 ? 'text-green-500' : 'text-red-500']">{{currencyFormat(item.amount)}}</span>

            <span class="text-sm text-gray-400">{{item.dateFormatted}}</span>
          </div>
        </div>
        <!-- Transaction Amount from mediam screen -->
        <span class="font-semibold text-lg whitespace-nowrap hidden md:block" :class="[item.amount > 0 ? 'text-green-500' : 'text-red-500']">{{currencyFormat(item.amount)}}</span>
      </div>
    </loading>

    <!-- Mobile Pagination -->
    <div class="mt-5 flex sm:hidden">
      <pagination :data="transactions" @pagination-change-page="getResults" :limit="-1">
        <span slot="prev-nav">
          <LeftIcon />
        </span>
        <span slot="next-nav">
          <RightIcon />
        </span>
      </pagination>
    </div>

    <!-- Pagination -->
    <div class="mt-5 hidden sm:flex">
      <pagination :data="transactions" @pagination-change-page="getResults" :limit="2">
        <span slot="prev-nav">
          <LeftIcon />
        </span>
        <span slot="next-nav">
          <RightIcon />
        </span>
      </pagination>
    </div>
  </div>
</template>

<script>
import AddBalance from "~/components/layouts/AddBalance.vue";
export default {
  name: "ProfileWallet",
  components: { AddBalance },
  data() {
    return {
      transactions: {}
    };
  },
  methods: {
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      this.$axios
        .get("/customer/wallet/transactions?page=" + page)
        .then(response => {
          this.transactions = response.data;
          this.stopLoading();
        });
    },

    /**
     * Get the auth user
     */
    async getUser() {
      const res = await this.$axios.$get("/customer/profile");
      this.$auth.setUser(res.data);
    }
  },

  created() {
    this.getUser();
    this.getResults();
  }
};
</script>

<style lang="scss">
</style>