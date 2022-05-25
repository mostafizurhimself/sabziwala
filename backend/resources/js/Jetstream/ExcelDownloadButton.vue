<template>
	<a :href="href" target="_blank" class="w-full flex items-center text-sm hover:bg-gray-100 py-1 px-2">
		<i class="w-4 h-4 ti-file mr-2"></i>
		<span>Download Excel</span>
	</a>
</template>

<script>
export default {
	props: {
		href: {
			type: String,
			default: "#",
		},
	},
};
</script>

<style lang="scss" scoped>
</style>