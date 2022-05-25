<template>
	<input class="" type="file" @change="handleChange" ref="input" multiple />
	<div class="image-container">
		<div v-for="(media, index) in medias" :key="index" class="preview-image">
			<img :src="media.url" />
			<button @click.prevent="remove(media.id)" class="remove">Remove</button>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		medias: {
			type: Array,
			default: () => [],
		},

		modelValue: Object,
	},

	emits: ["update:modelValue", "change"],

	data() {
		return {
			previewUrls: [],
		};
	},

	methods: {
		focus() {
			this.$refs.input.focus();
		},
		handleChange(e) {
			this.$emit("update:modelValue", e.target.files);
		},
		remove(id) {
			this.$inertia.delete(route("media.remove", id));
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

	.remove {
		position: absolute;
		height: 100%;
		width: 100%;
		background: rgba(0, 0, 0, 0.5);
		color: white;
		transform: translateY(-100%);
		opacity: 0;
		transition: all 0.3s;
	}

	&:hover .remove {
		transform: translateY(0);
		opacity: 1;
	}
}
</style>

