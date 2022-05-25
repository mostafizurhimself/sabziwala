<template>
  <div>
    <h2 class="font-semibold text-xl">Customer Reviews</h2>

    <!-- rating -->
    <div class="rating flex items-center text-sm mt-3 pb-8">
      <!-- rating component -->
      <client-only>
        <star-rating :rating="averageRatings" :star-size="15" :increment="0.5" :padding="5" :show-rating="false" active-color="#F59E0B" :read-only="true" :star-points="[23,2, 14,17, 0,19, 10,34, 7,50, 23,43, 38,50, 36,34, 46,19, 31,17]" style="margin-top: -2px"></star-rating>
      </client-only>

      <span class="text-gray-700 font-bold ml-1 mt-1">
        <span v-if="reviews && reviews.length">( {{reviews.length}} Reviews )</span>
        <span v-else>( 0 Reviews )</span>
      </span>
    </div>

    <!-- users -->
    <div v-for="(item, i) in reviews" :key="i" class="flex items-start border-t border-gray-200 py-8">
      <!-- user image -->
      <div>
        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full overflow-hidden shadow-sm flex items-center justify-center bg-gray-100">
          <img v-if="item.author && item.author.profilePhotoUrl" :src="item.author.profilePhotoUrl" alt="" class="w-full h-full object-cover" />

          <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>

        </div>
      </div>

      <div class="ml-5 w-full">
        <div class="sm:flex justify-between items-center">
          <div>
            <h3 v-if="item.author" class="font-semibold text-lg">{{item.author.name}}</h3>
            <!-- rating -->
            <div class="rating flex items-center text-yellow-500 text-sm">
              <!-- rating component -->
              <client-only>
                <star-rating v-model="item.rating" :read-only="true" :star-size="15" :padding="5" :increment="0.5" :show-rating="false" active-color="#F59E0B" :star-points="[23,2, 14,17, 0,19, 10,34, 7,50, 23,43, 38,50, 36,34, 46,19, 31,17]" style="margin-top: -3px"></star-rating>
              </client-only>

            </div>
          </div>
          <div class="mt-1 sm:mt-0">
            <span class="hidden sm:block border border-gray-200 py-1 px-3 rounded-full text-xs md:text-sm">{{item.dateFormatted}}</span>
            <span class="block sm:hidden rounded-full text-xs md:text-sm">{{item.dateFormatted}}</span>
          </div>
        </div>

        <!-- review -->
        <div class="mt-4">
          <p>{{item.body}}</p>
        </div>
      </div>

    </div>

  </div>
</template>

<script>
export default {
  name: "ProductReview",
  props: {
    reviews: {
      type: Array
    },
    averageRatings: {
      type: Number
    }
  }
};
</script>

<style lang="scss" scoped>
</style>