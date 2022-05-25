<template>
	<div class="review-categories flex justify-center items-center h-full">
		<div class="container my-20">
			<div
				class="bg-white mx-auto rounded-lg shadow-md"
				style="max-width: 970px"
			>
				<!-- icon -->
				<div class="h-24 w-24 bg-primary-500 flex justify-center items-center mx-auto">
					<svg
						xmlns="http://www.w3.org/2000/svg"
						class="h-8 w-8 text-white"
						viewBox="0 0 20 20"
						fill="currentColor"
					>
						<path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
						<path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
					</svg>
				</div>

				<div
					class="mt-16"
					v-if="reviews.length"
				>
					<review-slides :reviews="reviews"></review-slides>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import ReviewSlides from "~/components/layouts/ReviewSlides.vue";
export default {
  components: {
    ReviewSlides
  },

  data() {
    return {
      reviews: []
    };
  },

  async mounted() {
    try {
      let reviews = await this.$axios.$get("/testimonial");
      this.reviews = reviews.data;
    } catch (error) {
      console.error(error);
    }
  }
};
</script>

<style lang="scss" scoped>
.review-categories {
  background-image: linear-gradient(
      rgba(255, 255, 255, 0.2),
      rgba(255, 255, 255, 0.2)
    ),
    url("/images/food-categories.jpg");
  background-size: cover;
}
.review-box {
  @media (min-width: 1200px) {
    padding: 110px 70px;
  }
  @media (min-width: 576px) {
    padding: 60px 40px;
  }
  padding: 60px 30px;
  @apply rounded-lg shadow-md;
}
</style>
