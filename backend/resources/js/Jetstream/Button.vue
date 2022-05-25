<template>
	<button :type="type" class="inline-flex items-center justify-center px-6 py-2 bg-primary-500 border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-600 active:bg-primary-700 focus:outline-none focus:border-primary-700 focus:ring focus:ring-primary-200 disabled:opacity-25 transition whitespace-nowrap">
		<slot></slot>
	</button>
</template>

<script>
export default {
	props: {
		type: {
			type: String,
			default: "submit",
		},
	},
};
</script>
