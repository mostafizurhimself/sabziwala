<template>
  <div class="mb-3">
    <label class="form-label">{{ label }}
      <span v-if="required" class="text-red-500">*</span>
    </label>
    <div class="rounded">
      <label v-if="!previewImage" class="custom-file-upload rounded-lg">
        <input class="hidden" type="file" @input="onFile" />
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
        </svg>
        <span>Click to upload</span>
      </label>

      <span :style="{ width: imageWidth, height: imageHeight }" v-else class=" preview-image flex justify-center items-center border rounded-lg">
        <img style="height: 100%; object-fit: contain" :src="previewImage" />
        <span class="image-overlay">
          <svg role="button" @click="removeImage" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 bg-white float-right m-1 rounded" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </span>
      </span>
    </div>
    <span class="text-red-500">{{ error[0] }}</span>
  </div>
</template>

<script>
export default {
  props: {

    url: {
      type: String,
      default: () => ""
    },

    value: {},

    placeholder: {
      type: String,
      default: ""
    },

    required: {
      type: Boolean,
      default: false
    },
    imageWidth: {
      type: String,
      default: "auto"
    },
    imageHeight: {
      type: String,
      default: "160px"
    },
    // Validation error
    error: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      previewImage: null
    };
  },
  methods: {
    onFile(e) {
      const files = e.target.files;

      if (files && files[0]) {
        const reader = new FileReader();
        reader.onload = e => (this.previewImage = e.target.result);
        reader.readAsDataURL(files[0]);

        this.$emit("input", files[0]);
      }
    },
    removeImage() {
      this.previewImage = null;
      this.$emit("input", null);
    }
  },

  computed: {
    isValidated() {
      return this.value?.length ? true : false;
    }
  },
  created() {
    this.previewImage = this.url;
  }
};
</script>

<style lang="scss" scoped>
.custom-file-upload {
  width: 100%;
  height: 160px;
  border: 1px dotted #ccc;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  cursor: pointer;
  transition: all 0.3s ease;
  color: #777;
  &:hover {
    background: #eee;
  }
}
.preview-image {
  position: relative;
  display: inline-block;
  min-height: 80px;
  &:hover {
    .image-overlay {
      display: block;
    }
  }
  .image-overlay {
    display: none;
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba($color: #000000, $alpha: 0.5);
  }
}
</style>
