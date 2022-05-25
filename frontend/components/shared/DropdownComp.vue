<template>
  <div class="relative">
    <div @click="toggle" v-click-outside="hide">
      <slot>Dropdown button</slot>
    </div>

    <transition name="dropdown">
      <div
        v-show="opened"
        class="absolute mt-2 rounded-lg shadow-md z-40 bg-white overflow-hidden"
        :style="{top: dropdownMarginTop + 'px', right: dropdownMarginRight + 'px'}"
      >
        <slot name="dropdown" :toggle="toggle">Dropdown content</slot>
      </div>
    </transition>
  </div>
</template>

<script>
import ClickOutside from "vue-click-outside";

export default {
  name: "DropdownComp",
  props: {
    // Top property of the dropdown
    dropdownMarginTop: {
      type: Number,
      required: false,
      default: 55
    },
    dropdownMarginRight: {
      type: Number,
      required: false,
      default: 0
    }
  },
  data() {
    return {
      opened: false
    };
  },

  methods: {
    toggle() {
      this.opened = !this.opened;
    },

    hide() {
      this.opened = false;
    }
  },

  mounted() {
    // prevent click outside event with popupItem.
    this.popupItem = this.$el;
  },

  // do not forget this section
  directives: {
    ClickOutside
  }
};
</script>

<style lang="scss" scoped>
.dropdown-enter-active,
.dropdown-leave-active {
  transition: all 0.2s ease;
}

.dropdown-enter,
.dropdown-leave-to {
  opacity: 0;
  transform: translateY(-30%);
}

.dropdown-enter-to,
.dropdown-leave-from {
  opacity: 1;
  transform: translateY(0);
}
</style>
