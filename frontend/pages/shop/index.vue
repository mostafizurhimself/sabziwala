<template>
  <div>
    <!-- banner -->
    <the-banner class="hidden sm:block" bannerLink="/images/banners/shop-banner.jpg">
      <template #header>Shop</template>
      <template #breadcrumbs>
        <li>
          <nuxt-link to="/" class="font-semibold">Home</nuxt-link>
        </li>
        <li><span class="mx-2">-</span></li>
        <li>
          <span class="font-semibold text-primary-500">Shop</span>
        </li>
      </template>
    </the-banner>

    <!-- shop -->
    <div class="container lg:flex my-5 md:my-10 lg:my-20" v-if="selectedZone">
      <!-- left side -->
      <div class="lg:w-9/12">
        <!-- filter bar -->
        <div class="lg:mr-5 mb-5 rounded-lg md:bg-transparent flex items-center justify-between">

          <!-- product layout view buttons -->
          <div class="flex items-center">
            <button @click="productView = 'vertical'" :class="{'active' : productView == 'vertical'}" class="text-gray-500 hover:text-primary-500 bg-gray-100 p-2 rounded">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
              </svg>
            </button>
            <button @click="productView = 'horizontal'" :class="{'active' : productView == 'horizontal'}" class="text-gray-500 hover:text-primary-500 ml-2 bg-gray-100 p-2 rounded">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>

          <!-- sort button -->
          <select-field class="text-md font-light ml-4" v-model="filters.sort" track=value :options="sortOptions"></select-field>
        </div>

        <!-- small screen search bar -->
        <div class="flex w-full mb-4 lg:hidden border border-gray-300 focus-within:border-primary-600 focus-within:ring focus-within:ring-primary-50 rounded-md overflow-hidden">
          <input v-model="filters.search" class="h-full border-0 bg-white px-4 py-2 rounded text-sm border-none outline-none w-full" type="search" name="search" placeholder="Search product..." />

          <!-- filter button for small devices -->
          <button @click="toggleFilter" class="text-gray-500 hover:text-primary-500 bg-gray-100 h-10 w-12 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
            </svg>
          </button>
          <div>
          </div>
        </div>

        <!-- mobile filters -->
        <div v-if="filtersOnMobile" class="w-full bg-white p-5 mb-5 border rounded-md">
          <h3 class="flex text-lg font-semibold">
            <span>Choose filters</span>
            <button @click="toggleFilter" class="ml-auto text-red-500">&#10006;</button>
          </h3>
          <div class="pt-5">
            <h3 class="font-semibold mb-3">Categories</h3>
            <checkbox-field isFilterCheck tiny :label="category.name" :value="category.id" :id="category.id" class="mt-2" v-for="category in categories" :key="`categoryId:${category.id}`" v-model="filters.categories"></checkbox-field>

          </div>
        </div>

        <!-- products -->
        <div>
          <!-- products -->
          <div v-if="productView == 'vertical'" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:pr-5">
            <shop-product v-for="(product, i) in products" :key="i" :product="product"></shop-product>
          </div>

          <div v-if="productView == 'horizontal'" class="grid grid-cols-1 gap-8 lg:pr-5">
            <horizontal-shop-product v-for="(product, i) in products" :key="i" :product="product"></horizontal-shop-product>
          </div>

          <!-- infinite loading -->
          <client-only>
            <infinite-loading @distance="10" @infinite="handleLoadMore" :identifier="infiniteId">
              <span slot="no-more"></span>
            </infinite-loading>
          </client-only>
        </div>

      </div>

      <!-- right side -->
      <div class="lg:w-3/12 hidden lg:block">
        <div class="pl-2 sticky" style="top: 110px">
          <!-- search -->
          <div>
            <input v-model="filters.search" class="h-full border-0 bg-white px-3 py-2 rounded text-md font-light border border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-50 w-full" type="search" name="search" placeholder="Search product..." />
          </div>

          <!-- categories -->
          <div class="py-5">
            <h3 class="text-md font-semibold mb-3">Product Categories</h3>
            <checkbox-field isFilterCheck tiny :label="category.name" :value="category.id" :id="category.id" v-model="filters.categories" class="mt-2" v-for="category in categories" :key="`categoryId:${category.id}`"></checkbox-field>
          </div>

          <!-- banners -->
          <div>
            <shop-banner-slides :banners="banners"></shop-banner-slides>
          </div>
        </div>
      </div>
    </div>
    <div class="container border text-center md:my-10 lg:my-20" v-else>
      <div class="my-16">
        <p class="text-primary">
          Please select a zone to see the products.
        </p>
        <button-field type="button" @click="showZoneModal" class="mt-4" label="Select Zone"></button-field>
      </div>
    </div>
  </div>
</template>

<script>
import ShopProduct from "~/components/layouts/ShopProduct.vue";
import HorizontalShopProduct from "~/components/layouts/HorizontalShopProduct.vue";
import ShopBannerSlides from "~/components/layouts/ShopBannerSlides.vue";
import { mapGetters } from "vuex";

export default {
  name: "ShopPage",
  components: {
    ShopProduct,
    HorizontalShopProduct,
    ShopBannerSlides
  },
  data() {
    return {
      productView: "vertical",
      products: [],
      categories: [],
      filtersOnMobile: false,
      page: 1,
      infiniteId: +new Date(),
      filters: {
        categories: [],
        search: "",
        sort: "created_at,desc"
      },
      sortOptions: [
        { value: "created_at,desc", name: "Newest First" },
        { value: "sale_price,asc", name: "Lowest Price Frist" },
        { value: "sale_price,desc", name: "Highest Price Frist" }
      ],
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

  watch: {
    filters: {
      handler: function() {
        this.infiniteId++;
        this.products = [];
        this.page = 1;
      },
      deep: true
    }
  },

  computed: {
    ...mapGetters({
      selectedZone: "zone/getSelectedZone"
    })
  },

  methods: {
    showZoneModal() {
      this.$store.dispatch("zone/toggleZoneModal");
    },
    toggleFilter() {
      this.filtersOnMobile = !this.filtersOnMobile;
    },

    getQueries() {
      let queryString = "";
      for (const key in this.filters) {
        if (this.filters[key] && this.filters[key].length) {
          queryString += `&${key}=${this.filters[key]}`;
        }
      }
      return queryString;
    },

    handleLoadMore($state) {
      this.$axios
        .$get(
          `/products?page=${this.page}${this.getQueries()}&zone=${
            this.selectedZone
          }`
        )
        .then(res => {
          const result = res.data;
          if (result.length) {
            result.forEach(value => {
              this.products.push(value);
            });
            $state.loaded();
          } else {
            $state.complete();
          }
        });
      this.page = this.page + 1;
    }
  },

  mounted() {
    // adding query data to search
    if (this.$route.query.search) {
      this.filters.search = this.$route.query.search;
    } else if (this.$route.query.category) {
      this.filters.categories.push(parseInt(this.$route.query.category));
    }
  },

  async fetch() {
    // fetching products
    let response = await this.$axios.$get("/categories");
    this.categories = response.data;
  }
};
</script>
<style lang="scss" scoped>
.active {
  color: #ee1d23;
}
</style>