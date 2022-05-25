<template>
	<ol class="list-reset flex text-grey-dark text-gray-500">
		<li v-for="(item, index) in breadcrumb" :key="index" class="flex">
			<p v-if="item.route">
				<Link :href="item.route" :class="{'text-primary-500 font-bold': item.route}">{{item.label}}</Link>
			</p>
			<p v-else>{{item.label}}</p>
			<span class="px-2" v-if="item.route">/</span>
		</li>

	</ol>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
export default {
	props: {
		breadcrumb: {
			type: Array,
			default: () => [],
		},
	},
	components: {
		Link,
	},
};
</script>

<style lang="scss" scoped>
</style>
