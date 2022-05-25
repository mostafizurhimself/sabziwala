<template>
  <div>
    <the-banner bannerLink="/images/banners/profile-banner.jpg">
      <template #header>
        <span class="text-2xl md:text-4xl mt-5 sm:mt-0 inline-block">Hello, {{$auth.user.firstName}} {{$auth.user.lastName}}!</span>
      </template>
      <template #breadcrumbs>
        <li>
          <nuxt-link to="/" class="font-semibold">Home</nuxt-link>
        </li>
        <li>
          <span class="mx-2">-</span>
        </li>
        <li>
          <span class="font-semibold text-primary-500">Profile</span>
        </li>
      </template>
    </the-banner>

    <div class="container my-5 md:my-10 lg:my-20">
      <div class="md:flex">
        <div class="md:w-3/12">
          <ul class="border border-gray-200 divide-y devide-gray-200">
            <li class>
              <nuxt-link class="profile-link" to="/customer/profile">
                <span class="items">
                  Profile
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                  </svg>
                </span>
              </nuxt-link>
            </li>
            <!-- wallet -->
            <li>
              <nuxt-link class="profile-link" to="/customer/profile/wallet">
                <span class="items">
                  Wallet
                  <WalletIcon />
                </span>
              </nuxt-link>
            </li>
            <!-- orders -->
            <li>
              <nuxt-link class="profile-link" to="/customer/profile/orders">
                <span class="items">
                  Orders
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                  </svg>
                </span>
              </nuxt-link>
            </li>
            <!-- Wishlist -->
            <li>
              <nuxt-link class="profile-link" to="/customer/profile/wishlists">
                <span class="items">
                  Wishlists
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                  </svg>
                </span>
              </nuxt-link>
            </li>
            <!-- Refunds -->
            <li>
              <nuxt-link class="profile-link" to="/customer/profile/refunds">
                <span class="items">
                  Refunds
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                  </svg>
                </span>
              </nuxt-link>
            </li>
            <li>
              <nuxt-link class="profile-link" to="/customer/profile/address">
                <span class="items">
                  Address
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                  </svg>
                </span>
              </nuxt-link>
            </li>
          </ul>
        </div>

        <div class="md:w-9/12 md:px-10 mt-10 md:mt-0">
          <nuxt-child></nuxt-child>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  middleware: ["customer"]
};
</script>

<style lang="scss" scoped>
.profile-link {
  @apply px-4 py-3 w-full block  border-gray-200;

  .items {
    @apply flex justify-between items-center;
  }
}

.nuxt-link-exact-active {
  @apply bg-primary-500 text-white border border-primary-500;
}
</style>
