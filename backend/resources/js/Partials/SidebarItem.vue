<template>
	<li class="text-gray-800 list-none sidebar-item">
		<!-- With Link -->
		<Link v-if="!$slots.submenu" :href="href" class="flex items-center sidebar-link p-1 hover:text-primary-400" :class="{'active': active}">
		<span class="flex items-center justify-center icon h-10 w-10">
			<slot name="icon">
				<i class=" ti-home"></i>
			</slot>
		</span>
		<span class="mx-4 h6" :class="{'lg:hidden' : collapsed}">
			<slot></slot>
		</span>
		</Link>
		<!-- Without link -->
		<div @click="onClick" v-else class="flex items-center sidebar-link p-1 cursor-pointer hover:text-primary-500" :class="{'active': active}">
			<span class="flex items-center justify-center icon h-10 w-10">
				<slot name="icon">
					<i class=" ti-home"></i>
				</slot>
			</span>
			<span class="mx-4 h6 flex-1" :class="{'lg:hidden' : collapsed}">
				<slot></slot>
			</span>

			<div class="px-4" v-if="$slots.submenu && !collapsed">
				<!-- <caret-down :class="{ '-rotate-90' : !showSubmenu}"></caret-down> -->
				<i class="dropdown-icon ti-plus" v-if="!showSubmenu"></i>
				<i class="dropdown-icon ti-minus" v-else></i>
			</div>
		</div>

		<!-- Nested Sub Menu items -->
		<ul v-if="$slots.submenu && showSubmenu" class="pt-2">
			<slot name="submenu"></slot>
		</ul>
	</li>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import CaretDown from "@/Icons/CaretDown.vue";
import CaretRight from "@/Icons/CaretRight.vue";
export default {
	components: {
		Link,
		CaretDown,
		CaretRight,
	},
	data() {
		return {
			showSubmenu: false,
		};
	},
	mounted() {
		if (this.active) this.showSubmenu = true;
		else this.showSubmenu = false;
	},
	methods: {
		onClick(e) {
			e.preventDefault();
			e.stopPropagation();
			this.showSubmenu = !this.showSubmenu;
		},
	},
	props: ["href", "active", "collapsed"],
};
</script>

<style lang="scss" scoped>
.active {
	@apply font-bold rounded-full bg-primary-100 text-primary-500;

	.icon {
		@apply bg-primary-500 text-white rounded-full shadow-lg;
	}
}

.dropdown-icon {
	font-size: 10px !important;
	font-weight: bold !important;
}
</style>
