<template>
  <div class="p-food-item">
    <div class="p-food-inner">
      <!-- image -->
      <div class="p-food-thumb">
        <img :src="product.thumbnailMediaUrl" alt="p-food" />
        <p class="price">{{product.salePriceFormatted}}
          <span class="line-through">{{product.actualPriceFormatted}} </span>
        </p>
      </div>
      <!-- details -->
      <div class="p-food-content">
        <nuxt-link :to="`shop/${product.id}`" class="text-lg font-semibold mb-2">{{product.name}}</nuxt-link>

        <div class="p-food-footer mt-2">
          <div class="flex justify-center items-center w-full pb-5">
            <div class="rating">
              <!-- rating component -->
              <client-only>
                <star-rating :rating='product.averageRatings' :read-only="true" :star-size="15" :padding="5" :increment="0.5" :show-rating="false" active-color="#F59E0B" :star-points="[23,2, 14,17, 0,19, 10,34, 7,50, 23,43, 38,50, 36,34, 46,19, 31,17]" style="margin-top: -3px"></star-rating>
              </client-only>
            </div>
            <p class="font-medium text-gray-400 text-sm">
              <span v-if="product.ratings && product.ratings.length">( {{product.ratings.length}} Reviews )</span>
              <span v-else>( 0 Reviews )</span>
            </p>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TheProduct",
  props: {
    product: {
      type: Object
    }
  }
};
</script>

<style lang="scss" scoped>
.p-food-item {
  .p-food-inner {
    background: #fff;
    box-shadow: 0 0 10px rgb(136 136 136 / 10%);
    border-radius: 10px;
    transition: all 0.3s ease;
    overflow: hidden;

    .p-food-thumb {
      border: 15px solid #fff;
      overflow: hidden;
      position: relative;

      img {
        width: 100%;
        border-radius: 10px;
        transition: all 0.3s ease;
      }

      .price {
        display: inline-block;
        font-weight: 500;
        padding: 5px 10px;
        font-size: 14px;
        text-align: center;
        color: #fff;
        box-shadow: 0 10px 10px rgb(228 129 106 / 10%);
        background: #ee1d23;
        position: absolute;
        top: 15px;
        left: 15px;
        border-radius: 4px;
      }
    }

    .p-food-content {
      padding: 0 20px 0;
      text-align: center;
      position: relative;

      .p-food-group {
        justify-content: center;
        @apply text-sm text-gray-600;
      }

      .p-food-footer {
        @apply flex flex-wrap justify-between;

        .right {
          width: 50%;
          padding: 10px 0;
          @apply flex items-center pl-3 text-sm text-gray-600;
        }
      }
    }
  }

  .p-food-inner:hover {
    .p-food-thumb {
      img {
        transform: scale(1.1);
      }
    }
  }
}
</style>
