<template>
  <div>
    <!-- alerts -->
    <div>
      <!-- rating -->
      <div v-if="validationErrors && validationErrors.rating" class="flex items-center bg-primary-50 text-primary-700 text-sm font-semibold px-4 py-2  rounded mb-3" role="alert">
        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
          <path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z" />
        </svg>
        <p>{{validationErrors.rating[0]}}</p>
      </div>
      <!-- review -->
      <div v-if="validationErrors && validationErrors.review" class="flex items-center bg-primary-50 text-primary-700 text-sm font-semibold px-4 py-2 mb-3 rounded" role="alert">
        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
          <path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z" />
        </svg>
        <p>{{validationErrors.review[0]}}</p>
      </div>
    </div>

    <!-- product -->
    <div class="flex items-start border-b border-gray-100 pb-5">
      <img :src="orderItem.product.thumbnailMediaUrl" class="h-16" :alt="orderItem.product.name">
      <div class="ml-3">
        <h5 class="text-lg">{{orderItem.product.name}}</h5>
        <h5 class="text-sm">Code: {{orderItem.product.code}}</h5>
      </div>
    </div>

    <!-- rating -->
    <div class="mt-3">
      <h5 class="font-medium mb-1">Rate this item
        <span class="text-primary-500">*</span>
      </h5>
      <!-- rating component -->
      <client-only>
        <star-rating v-model="formData.rating" :error="validationErrors.rating" :read-only="false" :star-size="23" :padding="4" :increment="0.5" :show-rating="false" active-color="#F59E0B" :star-points="[23,2, 14,17, 0,19, 10,34, 7,50, 23,43, 38,50, 36,34, 46,19, 31,17]"></star-rating>
      </client-only>

      <h5 class="font-medium mb-2 mt-5">Write a Review
        <span class="text-primary-500">*</span>
      </h5>
      <text-field v-model="formData.review"></text-field>

      <button-field type='button' @click="submitReview" label="Submit Review"></button-field>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: {
    orderItem: {
      type: Object
    }
  },
  data() {
    return {
      formData: {
        rating: null,
        review: ""
      }
    };
  },

  computed: {
    ...mapGetters({
      validationErrors: "validation/validationErrors"
    })
  },

  methods: {
    async submitReview() {
      try {
        let review = this.formData;
        await this.$axios.$post(
          `order-items/${this.orderItem.id}/reviews`,
          review
        );
        this.$toast.success("Thank you for the review!");
        this.$emit("close");
        this.$emit("reviewed");
      } catch (error) {
        console.log(error);
      }
    }
  }
};
</script>

<style lang="scss" scoped>
</style>