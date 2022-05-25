<template>
  <div class="mb-3">
    <label v-if="label" class="flex mb-1 text-sm">
      {{ label }}
      <span v-if="required" class="text-red-500">*</span>
    </label>
    <input
      class="flex border border-gray-300 w-full px-4 py-2 focus:border-primary-500 rounded"
      :type="type"
      :value="value"
      @blur="$emit('blur', $event.target.value)"
      @input="$emit('input', $event.target.value)"
      ref="input"
      :placeholder="placeholder"
      :disabled="disabled"
    />
    <span class="text-red-500 text-sm">{{ error[0] }}</span>
  </div>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      required: false
    },

    type: {
      type: String,
      default: "text",
      validator: val =>
        val == "text" ||
        val == "number" ||
        val == "password" ||
        "email" ||
        "color"
    },

    value: {
      type: String,
      default: ""
    },

    placeholder: {
      type: String,
      default: ""
    },

    required: {
      type: Boolean,
      default: false
    },

    error: {
      type: Array,
      default: () => []
    },

    disabled: {
      type: Boolean,
      default: false
    }
  }
};
</script>

<style lang="scss" scoped>
</style>
