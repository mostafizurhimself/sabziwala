<template>
    <div class="sidebar shadow-md" :class="{ collapsed: collapsed }">
        <!-- Logo -->
        <Link :href="route('dashboard')" class="flex items-center justify-center px-5 h-20">
        <jet-application-mark class="block h-10 w-10" />
        <div class="ml-4 flex-grow" :class="{ 'lg:hidden': collapsed }">
            <span class="text-lg font-bold leading-3">Sabziwala</span>
            <span class="block text-xs h6 leading-3">Admin Dashboard</span>
        </div>
        </Link>
        <div class="px-4 overflow-auto" style="max-height: calc(100vh - 80px)">
            <!-- Dashboard -->
            <sidebar-item :href="route('dashboard')" :active="route().current('dashboard')" :collapsed="collapsed">
                Dashboard
            </sidebar-item>

            <!-- RESOURCES -->
            <p class="px-4 py-3 text-xs font-bold text-gray-400 uppercase" v-if="
          !collapsed &&
          hasPermissions([
            'viewAnyOrders',
            'viewAnyRefundRequests',
            'viewAnyCategories',
            'viewAnyProducts',
            'viewAnyCustomers',
            'viewAnyRiders',
            'viewAnyRoles',
            'viewAnyUsers',
          ])
        ">
                Resources
            </p>

            <!-- Sales -->
            <sidebar-item :active="isActive(['orders.*', 'refund-requests.*'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyOrders', 'viewAnyRefundRequests'])">
                <template #icon><i class="ti-shopping-cart" title="Orders"></i></template>
                Sales
                <!-- Nested Menu Items -->
                <template #submenu>
                    <submenu-item title="Orders" :href="route('orders.index')" :active="isActive(['orders.*'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyOrders'])">
                        Orders
                    </submenu-item>

                    <!--Refunds -->
                    <submenu-item title="Refunds" :href="route('refund-requests.index')" :active="isActive(['refund-requests.*'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyRefundRequests'])">
                        Refunds
                    </submenu-item>
                </template>
            </sidebar-item>

            <!-- Catalog -->
            <sidebar-item :active="isActive(['categories.*', 'products.*', 'reviews.*'])" :collapsed="collapsed" v-if="
          hasPermissions([
            'viewAnyCategories',
            'viewAnyProducts',
            'viewAnyReviews'
          ])
        ">
                <template #icon><i class="ti-package" title="Catalog"></i></template>
                Catalog

                <!-- Nested Menu Items -->
                <template #submenu>
                    <submenu-item title="Categories" :href="route('categories.index')" :active="isActive(['categories.*'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyCategories'])">
                        Categories
                    </submenu-item>
                    <submenu-item title="Products" :href="route('products.index')" :active="isActive(['products.*'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyProducts'])">
                        Products
                    </submenu-item>

                    <submenu-item title="Products" :href="route('reviews.index')" :active="isActive(['reviews.*'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyReviews'])">
                        Reviews
                    </submenu-item>
                </template>
            </sidebar-item>

            <!-- People -->
            <sidebar-item :active="isActive(['customers.*', 'riders.*', 'employees.*'])" :collapsed="collapsed" v-if="
          hasPermissions([
            'viewAnyCustomers',
            'viewAnyRiders',
            'viewAnyEmployees',
          ])
        ">
                <template #icon>
                    <span title="People">
                        <customer-icon class="h-5 w-5"></customer-icon>
                    </span>
                </template>
                People

                <!-- Nested Menu Items -->
                <template #submenu>
                    <!--Riders -->
                    <submenu-item title="Riders" :href="route('riders.index')" :active="isActive(['riders.*'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyRiders'])">
                        Riders
                    </submenu-item>

                    <submenu-item title="Customers" :href="route('customers.index')" :active="isActive(['customers.*'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyCustomers'])">
                        Customers
                    </submenu-item>

                    <submenu-item title="Employees" :href="route('employees.index')" :active="isActive(['employees.*'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyEmployees'])">
                        Employees
                    </submenu-item>
                </template>
            </sidebar-item>

            <!-- Expense -->
            <sidebar-item :active="
          isActive(['expense-type.*', 'expenses.*', 'loans.*', 'salaries.*'])
        " :collapsed="collapsed" v-if="
          hasPermissions([
            'viewAnyExpenseTypes',
            'viewAnyExpenses',
            'viewAnyLoans',
            'viewAnySalaries',
          ])
        ">
                <template #icon>
                    <span title="Expenses">
                        <i class="ti-wallet"></i>
                    </span>
                </template>
                Expense

                <!-- Nested Menu Items -->
                <template #submenu>
                    <submenu-item title="Expense Type" :href="route('expense-type.index')" :active="isActive(['expense-type.*'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyExpenseTypes'])">
                        Types
                    </submenu-item>

                    <submenu-item title="Expenses" :href="route('expenses.index')" :active="isActive(['expenses.*'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyExpenses'])">
                        Expenses
                    </submenu-item>

                    <submenu-item title="Loans" :href="route('loans.index')" :active="isActive(['loans.*'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyLoans'])">
                        Loans
                    </submenu-item>

                    <submenu-item title="Salaries" :href="route('salaries.index')" :active="isActive(['salaries.*'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnySalaries'])">
                        Salaries
                    </submenu-item>
                </template>
            </sidebar-item>

            <!-- People -->
            <sidebar-item :active="isActive(['roles.*', 'users.*', 'contacts.*'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyRoles', 'viewAnyUsers', 'viewAnyContacts'])">
                <template #icon><i class="ti-user" title="Admins"></i></template>
                Admins
                <!-- Nested Menu Items -->
                <template #submenu>
                    <!-- Roles -->
                    <submenu-item title="Roles" :href="route('roles.index')" :active="isActive(['roles.*'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyRoles'])">
                        Roles
                    </submenu-item>
                    <!-- Users -->
                    <submenu-item title="Users" :href="route('users.index')" :active="isActive(['users.*'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyUsers'])">
                        Users
                    </submenu-item>

                    <!-- Messages -->
                    <submenu-item title="Messages" :href="route('contacts.index')" :active="isActive(['contacts.*'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyContacts'])">
                        Messages
                    </submenu-item>

                </template>
            </sidebar-item>

            <!-- CONFIGURATION -->
            <p class="px-4 py-3 text-xs font-bold text-gray-400 uppercase" v-if="!collapsed && hasPermissions(['viewAnyZones', 'viewAnySettings'])">
                Configuration
            </p>

            <!-- Zones -->
            <sidebar-item :href="route('zones.index')" :active="isActive(['zones.*'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyZones'])">
                <template #icon><i class="ti-map-alt" title="Zones"></i></template>
                Zones
            </sidebar-item>

            <!-- Pages -->
            <sidebar-item :active="
          isActive([
            'appearance.home',
            'appearance.rider',
            'appearance.about',
            'appearance.contact',
            'appearance.terms',
            'appearance.payments',
          ])
        " :collapsed="collapsed" v-if="hasPermissions(['viewAnyAppearances'])">
                <template #icon><i class="ti-files" title="Pages"></i></template>
                Pages
                <!-- Nested Menu Items -->
                <template #submenu>
                    <!-- Home -->
                    <submenu-item title="Home" :href="route('appearance.home')" :active="isActive(['appearance.home'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyAppearances'])">
                        Home
                    </submenu-item>

                    <!-- Rider -->
                    <submenu-item title="Rider" :href="route('appearance.rider')" :active="isActive(['appearance.rider'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyAppearances'])">
                        Rider
                    </submenu-item>

                    <!-- Contact -->
                    <submenu-item title="About" :href="route('appearance.about')" :active="isActive(['appearance.about'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyAppearances'])">
                        About
                    </submenu-item>

                    <!-- Contact -->
                    <submenu-item title="Contact" :href="route('appearance.contact')" :active="isActive(['appearance.contact'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyAppearances'])">
                        Contact
                    </submenu-item>

                    <!--  Terms & Conditions -->
                    <submenu-item title=" Terms & Conditions" :href="route('appearance.terms')" :active="isActive(['appearance.terms'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyAppearances'])">
                        Terms
                    </submenu-item>

                    <!--  Payment & Refunds -->
                    <submenu-item title="Payment" :href="route('appearance.payments')" :active="isActive(['appearance.payments'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnyAppearances'])">
                        Payment
                    </submenu-item>
                </template>
            </sidebar-item>

            <!-- Settings -->
            <sidebar-item :href="route('settings.index')" :active="isActive(['settings.*'])" :collapsed="collapsed" v-if="hasPermissions(['viewAnySettings'])">
                <template #icon><i class="ti-settings" title="Settings"></i></template>
                Settings
            </sidebar-item>
        </div>
    </div>
</template>

<script>
import JetApplicationMark from "@/Jetstream/ApplicationMark.vue";
import SidebarItem from "@/Partials/SidebarItem.vue";
import SubmenuItem from "@/Partials/SubmenuItem.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
    props: {
        collapsed: {
            type: Boolean,
            required: true,
        },
    },
    components: {
        JetApplicationMark,
        Link,
        SidebarItem,
        SubmenuItem,
    },

    methods: {
        isActive(routes) {
            return routes.some((route) => this.route().current(route));
        },
    },
};
</script>

<style lang="scss">
.sidebar {
    @apply h-screen bg-white overflow-hidden w-72 flex-shrink-0 absolute lg:relative transition lg:transition-none duration-500 ease-in-out z-20;
    &.collapsed {
        @apply lg:w-20 -translate-x-full lg:translate-x-0;
    }
}
</style>
