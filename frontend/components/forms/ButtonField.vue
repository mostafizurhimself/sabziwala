<template>
  <button v-if="type !== 'submit'" @click.prevent="$emit('click')" :type="type" :class="[disabled ?'bg-gray-200 text-gray-400 cursor-default': 'bg-primary-500 text-white cursor-pointer']" :disabled="disabled" class="px-4 py-2 rounded text-sm">
    <slot name="label">{{label}}</slot>
  </button>
  <button v-else type="submit" :disabled="disabled" :class="[disabled ?'bg-gray-200 text-gray-400 cursor-default': 'bg-primary-500 hover:bg-primary-600 text-white cursor-pointer']" class="px-4 py-2 rounded text-sm">
    <slot name="label">{{label}}</slot>
  </button>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      default: "Submit"
    },
    disabled: {
      type: Boolean,
      default: false
    },
    type: {
      type: String,
      default: "submit"
    }
  }
};
</script>

<style lang="scss" scoped>
</style>
