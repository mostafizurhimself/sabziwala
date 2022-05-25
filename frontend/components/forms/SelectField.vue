<template>
  <div>
    <label v-if="label" class="flex mb-1 text-sm">{{ label }}
      <span v-if="required" class="text-red-500">*</span>
    </label>
    <div class="flex items-center">
      <select class="flex border border-gray-300 w-full px-3 py-2 text-sm  focus:border-primary-500 focus:ring focus:ring-primary-50 rounded cursor-pointer outline-none" :value="value" @input="$emit('input', $event.target.value)" :disabled="disabled" :class="{ 'bg-light': disabled }">
        <option value="" v-if="showPlaceholder">{{ placeholder }}</option>
        <option v-for="(option, index) in options" :key="index" :selected="value == getSelected(option)" :value="getValue(option)">
          <slot :option="option">{{ getTitle(option) }}</slot>
        </option>
      </select>
    </div>
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

    required: {
      type: Boolean,
      default: false
    },

    options: {
      type: Array,
      default: () => []
    },

    // Option title to show
    title: {
      type: String,
      default: "name"
    },

    // Return value for v-model
    track: {
      type: String,
      default: "id"
    },

    // Select placeholder
    placeholder: {
      type: String,
      default: "Select One"
    },

    // Default selected value
    value: {
      default: ""
    },

    // Control select placeholder
    showPlaceholder: {
      type: Boolean,
      default: true
    },

    // Validation error
    error: {
      type: Array,
      default: () => []
    },

    // Disabled
    disabled: {
      type: Boolean,
      default: false
    }
  },

  methods: {
    getSelected(option) {
      if (typeof option == "object") {
        return option[this.track];
      }
      return option;
    },
    getValue(option) {
      if (typeof option == "object") {
        return option[this.track];
      }
      return option;
    },

    getTitle(option) {
      if (typeof option == "object") {
        return option[this.title];
      }
      return option;
    }
  },

  computed: {
    isValidated() {
      return this.value?.length ? true : false;
    }
  }
};
</script>

<style lang="scss" scoped>
</style>
