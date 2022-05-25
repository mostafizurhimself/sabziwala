<template>
	<div class="image-container">
		<a :href="media.url" target="_blank" v-for="(media, index) in medias" :key="index" class="preview-image">
			<img :src="media.url" />
		</a>
	</div>
</template>

<script>
export default {
	props: {
		medias: {
			type: Array,
			default: () => [],
		},
	},
};
</script>


<style lang="scss" scoped>
.image-container {
	display: flex;
	flex-wrap: wrap;
}

.preview-image {
	@apply bg-gray-100 p-4 rounded-primary;
	height: 150px;
	width: 200px;
	display: flex;
	align-items: center;
	justify-content: center;
	position: relative;
	overflow: hidden;

	img {
		object-fit: contain;
		height: 100%;
		width: 100%;
	}
	margin-right: 1rem;
	margin-top: 1rem;
}
</style>


