<template>
	<header>
		<nav
			class="bg-white fixed w-full px-2 shadow"
			style="z-index: 10"
		>
			<div class="container flex items-center justify-between h-full">
				<!-- logo -->
				<div
					class="brand"
					v-if="getWebsiteSettings && getWebsiteSettings.primaryMediaUrl"
				>
					<nuxt-link
						to="/"
						class="inline-flex items-end"
					>
						<img
							class="h-10"
							:src="getWebsiteSettings.primaryMediaUrl"
							alt=""
						>
						<h1 class="text-gray-900 font-semibold text-2xl ml-2">{{getWebsiteSettings.data.name}}</h1>
					</nuxt-link>
				</div>
				<div v-else>
					<nuxt-link
						to="/"
						class="inline-flex items-end"
					>
						<h1 class="text-gray-900 font-semibold text-2xl ml-2">Logo</h1>
					</nuxt-link>
				</div>

				<!-- nav items -->
				<div class="navigation hidden md:flex items-center h-full">
					<!-- links -->
					<ul class="flex items-center border-r h-full px-7">
						<li class="nav-item">
							<nuxt-link
								to="/shop"
								class="nav-link"
							>SHOP</nuxt-link>
						</li>
						<li class="nav-item">
							<nuxt-link
								to="/about"
								class="nav-link"
							>ABOUT</nuxt-link>
						</li>
						<li class="nav-item">
							<nuxt-link
								to="/contact"
								class="nav-link"
							>CONTACT</nuxt-link>
						</li>
					</ul>

					<!-- Cart -->
					<div
						class="flex items-center border-r h-full px-7"
						v-if="$route.path !== '/checkout'"
					>
						<!-- dropdown -->
						<dropdown-comp :dropdownMarginTop="48">
							<template>
								<div class="cursor-pointer">
									<CartIcon class="relative" />
									<div
										v-if="getTotalItem > 0"
										class="absolute -top-2.5 -right-2.5 bg-primary-500 h-5 w-5 rounded-full flex items-center justify-center"
									>
										<span class="inline-block mb-0 text-xs text-white whitespace-nowrap">{{ getTotalItem }}</span>
									</div>
								</div>
							</template>

							<template #dropdown="{ toggle }">
								<!-- cart body component -->
								<header-cart-menu @close="toggle"></header-cart-menu>
							</template>
						</dropdown-comp>
					</div>

					<!-- profile -->
					<div class="flex items-center h-full pl-7">
						<!-- dropdown -->
						<dropdown-comp>
							<template>
								<div
									:class="
                    $auth.loggedIn ? 'border-primary-500' : 'border-gray-900'
                  "
									class="w-10 h-10 rounded-full overflow-hidden border-2 cursor-pointer shadow-sm flex items-center justify-center"
								>
									<svg
										v-if="!$auth.loggedIn || $auth.user.profilePhotoUrl == ''"
										xmlns="http://www.w3.org/2000/svg"
										class="h-5 w-5"
										fill="none"
										viewBox="0 0 24 24"
										stroke="currentColor"
									>
										<path
											stroke-linecap="round"
											stroke-linejoin="round"
											stroke-width="2"
											d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
										/>
									</svg>
									<img
										v-if="$auth.loggedIn && $auth.user.profilePhotoUrl"
										:src="$auth.user.profilePhotoUrl"
										alt
										class="w-full h-full object-cover"
									/>
								</div>
							</template>
							<template #dropdown>
								<div
									class="p-2 w-44"
									v-if="$auth.loggedIn"
								>
									<nuxt-link
										v-if="$auth.user.type == 'rider'"
										to="/rider/profile"
										class="dropdown-link"
									>Profile</nuxt-link>
									<nuxt-link
										v-else
										to="/customer/profile"
										class="dropdown-link"
									>Profile</nuxt-link>
									<button-field
										@click="logout"
										type="button"
										label="Logout"
										class="dropdown-link w-full text-left"
									>Logout</button-field>
								</div>

								<div
									class="p-2 w-44"
									v-else
								>
									<nuxt-link
										to="/login"
										class="dropdown-link"
									>Sign In</nuxt-link>
									<nuxt-link
										to="/register"
										class="dropdown-link"
									>Sign Up</nuxt-link>
								</div>
							</template>
						</dropdown-comp>
					</div>
				</div>

				<!-- mobile nav items -->
				<div class="flex block md:hidden">
					<!-- cart on mobile nav -->
					<nuxt-link
						to="/cart"
						v-if="$route.path !== '/checkout'"
					>
						<div class="cursor-pointer relative">
							<CartIcon class="text-gray-800" />
							<div
								v-if="getTotalItem > 0"
								class="absolute -top-2.5 -right-2.5 bg-primary-500 h-5 w-5 rounded-full flex items-center justify-center"
							>
								<span class="inline-block mb-0 text-xs text-white whitespace-nowrap">{{ getTotalItem }}</span>
							</div>
						</div>
					</nuxt-link>

					<!-- burger on mobile nav -->
					<div
						@click="toggleMobileNav"
						class="toggleIcon text-primary-500 ml-6"
					>
						<svg
							xmlns="http://www.w3.org/2000/svg"
							class="h-7 w-7"
							viewBox="0 0 20 20"
							fill="currentColor"
						>
							<path
								fill-rule="evenodd"
								d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
								clip-rule="evenodd"
							/>
						</svg>
					</div>
				</div>
			</div>
		</nav>
		<!-- mobile-nav -->
		<transition
			name="mobile-nav"
			mode="out-in"
			appear
		>
			<ul
				v-show="mobileNav"
				class="sidebar px-3 shadow-md"
				v-click-outside="hide"
			>
				<li class="nav-item">
					<nuxt-link
						to="/shop"
						class="nav-link"
					>
						SHOP
						<svg
							xmlns="http://www.w3.org/2000/svg"
							class="h-4 w-4"
							fill="none"
							viewBox="0 0 24 24"
							stroke="currentColor"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								d="M12 6v6m0 0v6m0-6h6m-6 0H6"
							/>
						</svg>
					</nuxt-link>
				</li>
				<li class="nav-item">
					<nuxt-link
						to="/about"
						class="nav-link"
					>
						ABOUT
						<svg
							xmlns="http://www.w3.org/2000/svg"
							class="h-4 w-4"
							fill="none"
							viewBox="0 0 24 24"
							stroke="currentColor"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								d="M12 6v6m0 0v6m0-6h6m-6 0H6"
							/>
						</svg>
					</nuxt-link>
				</li>
				<li class="nav-item">
					<nuxt-link
						to="/contact"
						class="nav-link"
					>
						CONTACT
						<svg
							xmlns="http://www.w3.org/2000/svg"
							class="h-4 w-4"
							fill="none"
							viewBox="0 0 24 24"
							stroke="currentColor"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								d="M12 6v6m0 0v6m0-6h6m-6 0H6"
							/>
						</svg>
					</nuxt-link>
				</li>
				<div v-if="$auth.loggedIn">
					<li
						v-if="$auth.user.type == 'rider'"
						class="nav-item"
					>
						<nuxt-link
							to="/rider/profile"
							class="nav-link"
						>
							MY PROFILE
							<svg
								xmlns="http://www.w3.org/2000/svg"
								class="h-4 w-4"
								fill="none"
								viewBox="0 0 24 24"
								stroke="currentColor"
							>
								<path
									stroke-linecap="round"
									stroke-linejoin="round"
									stroke-width="2"
									d="M12 6v6m0 0v6m0-6h6m-6 0H6"
								/>
							</svg>
						</nuxt-link>
					</li>

					<li
						v-else
						class="nav-item"
					>
						<nuxt-link
							to="/customer/profile"
							class="nav-link"
						>
							MY PROFILE
							<svg
								xmlns="http://www.w3.org/2000/svg"
								class="h-4 w-4"
								fill="none"
								viewBox="0 0 24 24"
								stroke="currentColor"
							>
								<path
									stroke-linecap="round"
									stroke-linejoin="round"
									stroke-width="2"
									d="M12 6v6m0 0v6m0-6h6m-6 0H6"
								/>
							</svg>
						</nuxt-link>
					</li>
					<li class="nav-item">
						<p
							@click="logout"
							class="nav-link cursor-pointer"
						>
							LOGOUT
							<svg
								xmlns="http://www.w3.org/2000/svg"
								class="h-4 w-4"
								fill="none"
								viewBox="0 0 24 24"
								stroke="currentColor"
							>
								<path
									stroke-linecap="round"
									stroke-linejoin="round"
									stroke-width="2"
									d="M12 6v6m0 0v6m0-6h6m-6 0H6"
								/>
							</svg>
						</p>
					</li>
				</div>
				<div
					v-else
					class="mt-5"
				>
					<nuxt-link to="/login">
						<button-field
							label="SIGN IN"
							class="bg-primary-500 text-white w-full"
						></button-field>
					</nuxt-link>
				</div>
			</ul>
		</transition>
	</header>
</template>

<script>
import { mapGetters } from "vuex";
import ClickOutside from "vue-click-outside";
import HeaderCartMenu from "~/components/layouts/HeaderCartMenu.vue";
export default {
  components: { HeaderCartMenu },
  name: "TheHeader",
  data() {
    return {
      mobileNav: false
    };
  },

  computed: {
    ...mapGetters({
      getTotalItem: "cart/getTotalItem",
      getWebsiteSettings: "config/getWebsiteSettings"
    })
  },

  methods: {
    toggleMobileNav() {
      this.mobileNav = !this.mobileNav;
    },
    async logout() {
      await this.$auth.logout();
      this.$router.push("/");
    },

    hide() {
      this.mobileNav = false;
    }
  },

  mounted() {
    // prevent click outside event with popupItem.
    this.popupItem = this.$el;
  },

  // do not forget this section
  directives: {
    ClickOutside
  }
};
</script>

<style lang="scss" scoped>
header {
  z-index: 99;
  box-shadow: 0 0 10px rgb(136 136 136 / 10%);
}

nav {
  height: 80px;
}

.nav-link {
  font-weight: 600;
  font-size: 14px;
  text-transform: uppercase;
  transition: all 0.2s ease;
  @apply hover:text-primary-500 px-2 md:px-4 lg:px-6;
}

.toggleIcon {
  cursor: pointer;
}

.sidebar {
  width: 100%;
  max-width: 250px;
  height: 100%;
  top: 80px;
  left: 0;
  z-index: 100;
  padding-top: 0 !important;
  @apply flex flex-col py-4 fixed bg-white md:hidden;

  .nav-item {
    .nav-link {
      @apply m-0 p-0 flex items-center justify-between;
    }
    @apply py-3 px-1;
  }
  .nav-item {
    @apply border-t border-gray-200;
  }
}

.dropdown-link {
  @apply block px-4 py-2 mt-2 text-sm font-semibold bg-transparent text-gray-900 rounded-lg md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none cursor-pointer;
}

.nuxt-link-exact-active {
  @apply text-primary-500;
}

.mobile-nav-enter-active,
.mobile-nav-leave-active {
  transition: all 0.5s ease-in-out;
}

.mobile-nav-enter,
.mobile-nav-leave-to {
  transform: translateX(-100%);
}
</style>
