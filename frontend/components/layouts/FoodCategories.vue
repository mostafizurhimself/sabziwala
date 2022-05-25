<template>
	<div class="food-categories flex justify-center items-center h-full">
		<div class="container my-20">
			<div class="food-box bg-white ">
				<section-header>
					<template #title>
						Browse Food Category
					</template>
					<template #subtitle>
						Completely network impactful users whereas next-generation
						applications engage out thinking via tactical action.
					</template>
				</section-header>
				<div
					class="mt-10"
					v-if="categories.length"
				>
					<category-slides :categories="categories"></category-slides>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import CategorySlides from "~/components/layouts/CategorySlides.vue";
export default {
	name: "FoodCategories",
	components: {
		CategorySlides,
	},

	data() {
		return {
			categories: [],
		};
	},

	async mounted() {
		try {
			const resCategories = await this.$axios.$get("/categories");
			this.categories = resCategories.data;
		} catch (error) {
			console.error(error);
		}
	},
};
</script>

<style lang="scss" scoped>
.food-categories {
	background-image: linear-gradient(
			rgba(255, 255, 255, 0.2),
			rgba(255, 255, 255, 0.2)
		),
		url("/images/food-categories.jpg");
	background-size: cover;
}
.food-box {
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
