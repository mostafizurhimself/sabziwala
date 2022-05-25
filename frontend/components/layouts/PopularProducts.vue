<template>
	<div
		v-if="selectedZone && featuredProducts.length"
		class="bg-blue-50"
	>
		<div class="container">
			<!-- section header -->
			<section-header class="pt-10 lg:pt-20">
				<template #title>
					Most Popular Items
				</template>
				<template #subtitle>
					Completely network impactful users whereas next-generation
					applications engage out thinking via tactical action.
				</template>
			</section-header>

			<!-- products -->
			<div class="mt-12 grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 pb-20">
				<the-product
					:product="item"
					v-for="(item, i) in featuredProducts"
					:key="i"
				></the-product>
			</div>
		</div>
	</div>
</template>

<script>
import { mapGetters } from "vuex";
import SectionHeader from "../shared/SectionHeader.vue";
export default {
  name: "PopularProducts",
  components: { SectionHeader },
  data() {
    return {
      featuredProducts: []
    };
  },
  computed: {
    ...mapGetters({
      selectedZone: "zone/getSelectedZone"
    })
  },

  async mounted() {
   try {
      let resProducts = await this.$axios.$get(
      `/feature-products?zone=${this.selectedZone}`
    );
    this.featuredProducts = resProducts.data;
   } catch (error) {
     console.error(error);
   }
  }
};
</script>

<style lang="scss" scoped></style>
