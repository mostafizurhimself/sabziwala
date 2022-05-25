<template>
	<div class="relative">
		<div class='tag-input'>
			<div v-for='(tag, index) in tags' :key='index' class='tag-input__tag'>
				{{ tag }}
				<span role="button" class="ml-2 text-xs font-bold" @click="removeTag(index)"> &#10005; </span>
			</div>
			<input type="text" class='tag-input__text' v-model="search" :placeholder="placeholder" @input="onChange" @keydown.enter="onEnter" @keydown.delete="removeLastTag" @keydown.down="onArrowDown" @keydown.up="onArrowUp" />
		</div>
		<ul ref="scrollContainer" class="tag-input__dropdown" v-if="showDropdown">
			<li :ref="`option-${index}`" v-for=" (suggestion, index) in matches" :key="index" :class="{'active': isActive(index)}" @click="suggestionClick(index)">
				{{ suggestion }}
			</li>
		</ul>
	</div>
</template>
<script>
export default {
	props: {
		placeholder: {
			type: String,
			default: "Search tags",
		},
		modelValue: {
			type: Array,
			default: () => [],
		},
		suggestions: {
			type: Array,
			default: () => [],
		},
	},
	data() {
		return {
			tags: [],
			search: "",
			isOpen: false,
			arrowCounter: -1,
		};
	},
	computed: {
		/**
		 * Filter suggestions based on search
		 */
		matches() {
			return this.suggestions.filter((str) => {
				return (
					str.toLowerCase().startsWith(this.search.toLowerCase()) &&
					!this.tags.includes(str)
				);
			});
		},

		/**
		 * Boolean value for dropdown open
		 */
		showDropdown() {
			return (
				this.search !== "" &&
				this.matches.length != 0 &&
				this.isOpen === true
			);
		},
	},
	watch: {
		tags(newValue) {
			this.$emit("update:modelValue", this.tags);
		},
	},
	methods: {
		/**
		 * Add new tag to the tag list
		 */
		addTag() {
			if (this.search.length > 0) {
				this.tags.push(this.search.trim());
				this.search = "";
			}
			this.isOpen = false;
			this.setUnique();
		},

		/**
		 * Set the unique values
		 */
		setUnique() {
			let uTags = new Map(this.tags.map((s) => [s.toLowerCase(), s]));
			this.tags = [...uTags.values()];
		},

		/**
		 * Remove tag from the tag list
		 */
		removeTag(index) {
			this.tags.splice(index, 1);
		},

		/**
		 * Remove tag on backspace or delete
		 */
		removeLastTag(event) {
			if (event.target.value.length === 0) {
				this.removeTag(this.tags.length - 1);
			}
		},

		/**
		 * On up arrow press
		 */
		onArrowUp() {
			if (this.arrowCounter > 0) {
				this.arrowCounter--;
			}
			this.setScroll();
		},

		/**
		 * On down arrow press
		 */
		onArrowDown() {
			if (this.arrowCounter < this.matches.length - 1) {
				this.arrowCounter++;
			}
			this.setScroll();
		},

		onEnter(event) {
			event.preventDefault();
			if (this.arrowCounter >= 0) {
				this.search = this.matches[this.arrowCounter];
			}
			this.addTag();
			this.arrowCounter = -1;
		},

		/**
		 * When the user changes input
		 */
		onChange() {
			if (this.isOpen == false) {
				this.isOpen = true;
				this.arrowCounter = -1;
			}
		},

		/**
		 * Highlight the selected element
		 */
		isActive(index) {
			return index === this.arrowCounter;
		},

		/**
		 * When one of the suggestion is clicked
		 */
		suggestionClick(index) {
			this.search = this.matches[index];
			this.addTag();
		},

		/**
		 * Close the dropdown on outside click
		 */
		handleClickOutside(event) {
			if (!this.$el.contains(event.target)) {
				this.isOpen = false;
				this.arrowCounter = -1;
			}
		},

		/**
		 * Set scrolling on arrow key press
		 */
		setScroll() {
			const height =
				this.$refs[`option-${this.arrowCounter}`].offsetHeight;
			this.$refs.scrollContainer.scrollTop = height * this.arrowCounter;
		},
	},

	mounted() {
		document.addEventListener("click", this.handleClickOutside);
	},

	destroyed() {
		document.removeEventListener("click", this.handleClickOutside);
	},

	created() {
		this.tags = this.modelValue;
	},
};
</script>
<style lang="scss" scoped>
.tag-input {
	@apply w-full flex flex-wrap rounded-primary border border-gray-300 text-sm items-center px-4 focus-within:border-primary-300 focus-within:ring focus-within:ring-primary-200 focus-within:ring-opacity-50 shadow-sm;
}

.tag-input__tag {
	@apply flex items-center rounded-primary bg-primary-500 text-white h-6 px-4 mr-2 mt-2 mb-2;
}

.tag-input__text {
	@apply py-2 flex-grow;
	border: none !important;
	outline: none !important;
	box-shadow: none !important;

	&:focus {
		border: none !important;
		outline: none !important;
		box-shadow: none !important;
	}
}

.tag-input__dropdown {
	@apply w-full absolute bg-white border border-gray-300 rounded-primary overflow-auto;
	list-style: none;
	max-height: 200px;
	li {
		@apply px-4 py-2 cursor-pointer hover:bg-gray-100;
	}

	li.active {
		@apply bg-primary-500 text-white hover:bg-primary-600;
	}
}
</style>
