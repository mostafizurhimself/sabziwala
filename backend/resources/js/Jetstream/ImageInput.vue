<template>
	<div>
		<!-- Image Preview -->
		<div class="preview bg-gray-100 p-4 rounded-primary mb-5" v-if="modelValue || url">
			<img :src="previewUrl" />
		</div>

		<!-- Add Image Button -->
		<label class="inline-block bg-primary-500 text-white px-6 py-2 rounded-full shadow whitespace-nowrap" role="button">
			<input type="file" @change="handleChange" ref="input" class="hidden" />
			<!-- Change Image -->
			<div class="flex items-center" v-if="modelValue || url">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
				</svg>
				<span>Change Image</span>
			</div>
			<!-- Add Image -->
			<div class="flex items-center" v-else>
				<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
				</svg>
				<span>Add New Image</span>
			</div>

		</label>

	</div>
</template>

<script>
export default {
	emits: ["update:modelValue", "change"],
	props: {
		url: {
			type: String,
			default: null,
		},
		modelValue: Object,
	},
	data() {
		return {
			previewUrl: "",
		};
	},

	methods: {
		focus() {
			this.$refs.input.focus();
		},
		handleChange(e) {
			this.onFileChange(e);
			this.$emit("update:modelValue", e.target.files[0]);
		},

		onFileChange: function (event) {
			const file = event.target.files[0];
			if (!file) {
				return false;
			}
			if (!file.type.match("image.*")) {
				return false;
			}
			const reader = new FileReader();
			const that = this;
			reader.onload = function (e) {
				that.previewUrl = e.target.result;
			};
			reader.readAsDataURL(file);
		},
	},

	mounted() {
		this.previewUrl = this.url;
	},
};
</script>

<style lang="scss" scoped>
.preview {
	height: 150px;
	width: 200px;
	display: flex;
	align-items: center;
	justify-content: center;
	overflow: hidden;

	img {
		height: 100%;
		object-fit: contain;
	}
}
</style>

