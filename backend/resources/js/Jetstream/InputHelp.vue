<template>
	<div v-show="text">
		<p class="text-sm text-gray-600">
			{{ text }}
		</p>
	</div>
</template>

<script>
export default {
	props: ["text"],
};
</script>
