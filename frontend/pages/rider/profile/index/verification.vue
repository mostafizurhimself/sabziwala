<template>
  <div>
    <p class="bg-gray-200 p-5">
      The following documents will be used to verify your identity.
      <br>
      <span class="font-semibold">
        Please attach all the real documents.
      </span>
    </p>
    <p class="bg-green-100 p-5 mt-5" v-if="$auth.user.verified == 0 && $auth.user.verificationFrontUrl.length">
      <span class="font-semibold">
        Your verification is in progress.
      </span>
      <br>
      Thank you for submitting the documents.
      We will verify the documents as soon as possible.
    </p>

    <div class="mt-5">
      <p class="text-gray-500">
        * Attach your NID / PASSPORT / DRIVING LICENCE verificable documents here.
        <br>
        * Image should be 1:1 acpect ratio. Maximum file size: 10MB(10240KB).
      </p>
    </div>

    <div class="mt-10 mx-auto lg:mx-0">
      <div class="">
        <h6 class="font-semibold text-md text-gray-600">Front side</h6>
        <image-attach-field class="mt-2 w-80" v-model="formData.frontImage" :url="$auth.user.verificationFrontUrl"></image-attach-field>
      </div>

      <div class="mt-10">
        <h6 class="font-semibold text-md text-gray-600">Back side</h6>
        <image-attach-field class="mt-2 w-80" v-model="formData.backImage" :url="$auth.user.verificationBackUrl"></image-attach-field>
      </div>
    </div>

    <button-field type="button" label="Submit Documents" :disabled="formData.frontImage == null || formData.backImage == null" @click="submitDocuments" class=" whitespace-nowrap mt-5 py-3 px-5 rounded"></button-field>

  </div>
</template>

<script>
import ImageAttachField from "~/components/forms/ImageAttachField.vue";
export default {
  components: { ImageAttachField },
  name: "RiderVerification",
  data() {
    return {
      formData: {
        frontImage: null,
        backImage: null
      }
    };
  },

  methods: {
    async submitDocuments() {
      const formData = new FormData();
      formData.append("verificationFront", this.formData.frontImage);
      formData.append("verificationBack", this.formData.backImage);
      const res = await this.$axios.$post(
        "/rider/update-verification",
        formData
      );
      this.$auth.setUser(res.data);
      (this.frontImage = null),
        (this.backImage = null),
        this.$toast.success("Thank you for submitting the documents!");
    }
  }
};
</script>

<style lang="scss" scoped>
</style>