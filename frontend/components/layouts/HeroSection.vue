<template>
	<div>
		<div
			class="hero"
			style="background: #F8F5F2"
		>
			<div class="container flex flex-col justify-center lg:flex-row items-center h-full">
				<div
					class="w-full lg:w-1/2 my-5 md:my-10 lg:my-20 text-center lg:text-left"
					v-if="getHeroSection && getHeroSection.data"
				>
					<h1 class="text-4xl font-semibold text-primary-500">{{getHeroSection.data.title}}</h1>
					<h1 class="text-xl mt-2 font-medium text-gray-800">{{getHeroSection.data.subtitle}}</h1>
					<!-- search bar -->
					<div class="flex mx-auto lg:mx-0 my-6 rounded-lg overflow-hidden h-12 md:h-16 shadow-md max-w-md ">
						<input
							@keyup.enter="searchProduct"
							v-model="searchParams"
							class="h-full border-0 bg-white px-4 py-2 rounded-l-lg text-md border-none outline-none w-full"
							type="search"
							name="search"
							placeholder="Search product..."
						/>

						<!-- search button -->
						<button
							@click="searchProduct"
							class="text-gray-500 hover:text-primary-500 bg-gray-100 h-full w-20 flex items-center justify-center "
						>
							<svg
								class=" h-5 w-5 fill-current"
								xmlns="http://www.w3.org/2000/svg"
								xmlns:xlink="http://www.w3.org/1999/xlink"
								version="1.1"
								id="Capa_1"
								x="0px"
								y="0px"
								viewBox="0 0 56.966 56.966"
								style="enable-background:new 0 0 56.966 56.966;"
								xml:space="preserve"
								width="512px"
								height="512px"
							>
								<path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
							</svg>
						</button>

						<div>
						</div>
					</div>
				</div>
				<div
					class="w-full lg:w-1/2"
					v-if="getHeroSection && getHeroSection.primaryMediaUrl"
				>
					<img
						:src="getHeroSection.primaryMediaUrl"
						class="my-5 md:my-10 md:h-64 lg:h-full mx-auto lg:mx-0"
						alt=""
					>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
	name: "HeroSection",
	data() {
		return {
			searchParams: "",
		};
	},

	methods: {
		searchProduct() {
			this.$router.push(`/shop?search=${this.searchParams}`);
		},
	},

	computed: {
		...mapGetters({
			getHeroSection: "config/getHeroSection",
		}),
	},
};
</script>

<style lang="scss" scoped>
.hero {
	height: 700px;
	max-height: 700px;
	@media only screen and (max-width: 500px) {
		height: 600px;
	}
}

.hero-image {
	background-image: linear-gradient(
			to bottom,
			rgba(255, 255, 255, 0.3),
			rgba(0, 0, 0, 0.5)
		),
		url("/images/hero.jpg");
	background-repeat: no-repeat;
	background-size: cover;
}
.hero-search {
	height: 70px;
	border: none;
	outline: none;
}
</style>
