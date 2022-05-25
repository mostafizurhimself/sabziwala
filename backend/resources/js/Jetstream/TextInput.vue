<template>
	<textarea rows="5" class="px-4 border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-300 focus:ring-opacity-50 rounded-primary shadow-sm" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="textarea"></textarea>
</template>

<script>
export default {
	props: ["modelValue"],

	emits: ["update:modelValue"],

	methods: {
		focus() {
			this.$refs.textarea.focus();
		},
	},
};
</script>

