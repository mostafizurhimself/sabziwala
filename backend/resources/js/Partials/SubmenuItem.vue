<template>
	<!-- With Link -->
	<Link :href="href" class="flex items-center sidebar-link p-1 hover:text-primary-500" :class="{'active': active}">
	<span class="flex items-center justify-center icon h-10 w-10">
		<slot name="icon" v-if="collapsed">
			<i class="ti-angle-double-right text-xs"></i>
		</slot>
	</span>
	<span class="mx-4 h6" :class="{'lg:hidden' : collapsed}">
		<slot></slot>
	</span>
	</Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
export default {
	components: {
		Link,
	},
	props: ["href", "active", "collapsed"],
};
</script>

<style lang="scss" scoped>
.active {
	@apply font-bold rounded-full text-primary-500;

	.icon {
		@apply bg-transparent rounded-none text-primary-500;
	}
}
</style>
