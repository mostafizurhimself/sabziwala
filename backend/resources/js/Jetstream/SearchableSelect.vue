<template>
  <div class="main_wrapper bg-white" ref="wrapperEl">
    <div @click="toggleSearchbox" class="search_input_tigger">
      <p class="text-gray-600">{{ selectedText }}</p>
      <Chevrondown />
    </div>
    <!-- Search Wrapper -->
    <div v-if="showSearchbox" class="searchable__select">
      <!-- Input Area -->
      <div class="relative">
        <input
          :value="inputText"
          @input="onInput"
          @focus="onFocus"
          @keydown.down="onArrowDown"
          @keydown.enter.prevent="onSelectOption"
          @keydown.up="onArrowUp"
          @keydown.esc="onESC"
          class="search__input"
          type="text"
          :placeholder="placeholder"
          ref="searchInput"
        />
        <div v-if="loading" class="absolute right-0 top-0">
          <Spinner width="40px" height="40px" />
        </div>
      </div>

      <!-- Outpur Area -->
      <ul v-if="showDropdown" class="search__results">
        <li
          v-for="(option, i) in filteredOptions"
          @click="onSelectOption($event, i)"
          :class="{ active: i == activeIndex }"
          :key="i"
        >
          {{ getOptionTitle(option) }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import {
  reactive,
  toRefs,
  computed,
  ref,
  onMounted,
  onUnmounted,
  nextTick,
} from "vue";
import Spinner from "@/Jetstream/Spinner.vue";
import Chevrondown from "@/Icons/Chevrondown.vue";
export default {
  name: "searchable-select",
  emits: ["update:modelValue", "search"],
  components: {
    Spinner,
    Chevrondown,
  },
  setup(props, ctx) {
    // ///// Data //////
    // /////////////////
    const data = reactive({
      inputText: "",
      activeIndex: 0,
      showDropdown: false,
      showSearchbox: false,
      selectedText: "Click to search",
    });

    // Element Ref
    const searchInput = ref(null);
    const wrapperEl = ref(null);

    // //////// Life Cycle Hooks  /////////
    // ///////////////////////////////////

    // Mounted
    onMounted(() => {
      document.addEventListener("click", handleOutsideClick);
    });
    // Unmounted
    onUnmounted(() => {
      document.removeEventListener("click", handleOutsideClick);
    });

    // //// Computed /////
    // //////////////////

    // Filter options by inputText
    const filteredOptions = computed(() => {
      const searchOptions = (val, i) =>
        val.toLocaleLowerCase().startsWith(data.inputText.toLocaleLowerCase());

      return props.options
        .filter((opt, i) => {
          if (typeof opt === "object") {
            return searchOptions(opt[props.title], i);
          }
          return searchOptions(opt, i);
        })
        .slice(0, props.max);
    });

    // /// Methods //////
    // /////////////////

    // Set Dropdown value
    function toggleDropdown() {
      data.showDropdown = Boolean(
        data.inputText && filteredOptions.value.length
      );
    }
    // Toggle searchbox
    function toggleSearchbox() {
      data.showSearchbox = !data.showSearchbox;
      nextTick(() => {
        if (data.showSearchbox) {
          searchInput.value.focus();
        }
      });
    }

    function handleOutsideClick(e) {
      if (!wrapperEl.value.contains(e.target)) {
        data.showDropdown = false;
        data.showSearchbox = false;
      }
    }

    // On Input Change
    function onInput(e) {
      const value = e.target.value.trim();

      // Updating value
      data.inputText = value;
      data.activeIndex = 0;

      // Emit to parent
      ctx.emit("search", value);

      // toggle dropdown
      toggleDropdown();
    }

    // When focus to input
    function onFocus(e) {
      // toggle dropdown
      toggleDropdown();
    }

    // On Arrow Down press
    function onArrowDown(e) {
      data.activeIndex++;
      if (data.activeIndex >= filteredOptions.value.length) {
        data.activeIndex = 0;
      }
    }
    // On Arrow Up press
    function onArrowUp(e) {
      data.activeIndex--;
      if (data.activeIndex < 0) {
        data.activeIndex = filteredOptions.value.length - 1;
      }
    }

    // On ESC press
    function onESC(e) {
      data.showDropdown = !data.showDropdown;
    }

    // When Select Option
    function onSelectOption(e, index = data.activeIndex) {
      if (!data.showDropdown) {
        return;
      }
      const selected = filteredOptions.value[index];

      data.inputText = "";
      data.selectedText = selected[props.title];
      data.showDropdown = false;
      data.showSearchbox = false;

      ctx.emit("update:modelValue", selected[props.trackby]);
    }
    // Get Options Title
    function getOptionTitle(option) {
      if (typeof option == "object") {
        return option[props.title];
      }
      return option;
    }

    // Return to Template
    return {
      ...toRefs(data),
      wrapperEl,
      onInput,
      getOptionTitle,
      filteredOptions,
      searchInput,
      onArrowUp,
      onArrowDown,
      onESC,
      onFocus,
      onSelectOption,
      toggleSearchbox,
    };
  },

  props: {
    modelValue: {
      type: [String, Number],
      default: null,
    },
    options: {
      type: Array,
      required: true,
    },
    title: {
      type: String,
      default: "name",
    },
    trackby: {
      type: String,
      default: "id",
    },
    autoFocus: {
      type: Boolean,
      default: false,
    },
    placeholder: {
      type: String,
      default: "",
    },
    max: {
      type: Number,
      default: 5,
    },
    loading: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style lang="scss" scoped>
.main_wrapper {
  @apply relative;
}
.searchable__select {
  @apply absolute w-full bg-white border border-primary-500 rounded-primary overflow-hidden z-10;
}
.search__input {
  @apply w-full px-4 border-0 bg-white focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50;
}

.search__results {
  @apply w-full bg-white overflow-auto;
  list-style: none;
  //   max-height: 200px;
  li {
    @apply px-4 py-2 cursor-pointer hover:bg-gray-100;
  }

  li.active {
    @apply bg-primary-500 text-white hover:bg-primary-600;
  }
}

.search_input_tigger {
  @apply flex justify-between px-4 py-2 mb-1 border border-gray-200 rounded-full cursor-pointer shadow-sm;
}
</style>

