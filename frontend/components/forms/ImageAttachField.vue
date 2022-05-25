<template>
  <div>
    <input :id="id" class="input" type="file" @change="handleChange">
    <label :for="id" class="input-label " :style="{'height' : height}" v-if="!previewUrl">
      <span>
        <svg xmlns="http://www.w3.org/2000/svg" class="label-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
        </svg>
        <p class="text-gray-600">
          Click to upload
        </p>
      </span>
    </label>
    <div class="preview-image" :style="{'height' : height}" v-if="previewUrl">
      <img :src="previewUrl" alt="">
      <div class="overlay">
        <span @click="removeImage">
          <svg class="overlay-button" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </span>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        props: {
            height: {
                type: String,
                default: "200px"
            },
            url: {
                type: String,
                default: null
            }
        },
         data() {
            return {
                id: null,
                previewUrl: null
            };
        },
        methods: {
            handleChange(e) {
                this.onFileChange(e);
                this.$emit("input", e.target.files[0]);
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
            removeImage(){
                this.previewUrl = null;
                this.$emit("input", null);
            },
        },

        created () {
            this.previewUrl = this.url;
        },
       
        mounted () {
            this.id = this._uid
        }
    }
</script>

<style lang="scss" scoped>
    .input {
        display: none;
    }

    .input-label {
        display: flex;
        justify-content: center;
        align-items: center;
        background: #F3F4F6;
        color: #6B7280;
        cursor: pointer;
        border-radius: 10px;

        &:hover {
            background: #D1D5DB;
        }

        .label-icon { 
            height: 1.5rem;
            margin-bottom: 0.75rem;
            margin-left: auto;
            margin-right: auto;
        }
    }

    .preview-image{
        @apply relative w-full bg-gray-100 rounded-lg overflow-hidden;

        img{
            height: 100%;
            width: 100%;
            object-fit: contain;
        }

        .overlay{
            content: "";
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0,0, 0, 0.6);
            opacity: 0;
            transition: all 0.3s;
            color: #fff;

            &-button {
                height: 1.2rem;
                color: red;
                background: #fff;
                position: absolute;
                border-radius: 3px;
                margin: 5px;
                top: 0.5rem;
                right: 0.5rem  
            }
        }

        &:hover .overlay{
            opacity: 1;
        }

    }
</style>