<template>
  <div>
    <!-- profile image -->
    <div class="w-full sm:flex">
      <div>
        <div class="bg-gray-200 w-40 h-40 rounded-lg">
          <image-attach-field class="w-40" height="160px" v-model="photo" :url="$auth.user.profilePhotoUrl"></image-attach-field>
        </div>
        <button-field type="button" label="Update Photo" v-if="photo" @click="submitImage" class="whitespace-nowrap mt-3 w-40 bg-primary-500 text-white py-3 px-5 rounded"></button-field>
      </div>
      <div class="sm:ml-6 mt-3 sm:mt-0">
        <h2 class="font-bold text-2xl mb-4">Profile Details</h2>
        <h6 class="font-semibold text-lg">{{$auth.user.name}}</h6>
        <p>{{$auth.user.phone}}</p>
        <p class="text-sm text-gray-400 mt-1">{{$auth.user.lastLoginForHuman}} last logged in.</p>
        <nuxt-link to="/customer/change-password" class="block mt-3 text-primary-500 text-sm hover:underline">Change Password</nuxt-link>
      </div>

    </div>

    <!-- details -->
    <form @submit.prevent="updateDetails" class="w-full mt-6">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <input-field label="First name" v-model="formData.firstName" :error="validationErrors['firstName']"></input-field>
        <input-field label="Last name" v-model="formData.lastName" :error="validationErrors['lastName']"> </input-field>
        <input-field type="email" label="Email" v-model="formData.email" :error="validationErrors['email']"></input-field>
        <input-field label="Phone" v-model="formData.phone" :error="validationErrors['phone']"></input-field>
      </div>

      <div class="flex justify-end">
        <button-field label="Update" class="bg-primary-500 text-white py-3 px-10"></button-field>
      </div>
    </form>

  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "Profile",
  data() {
    return {
      formData: {
        firstName: this.$auth.user?.firstName,
        lastName: this.$auth.user?.lastName,
        email: this.$auth.user?.email,
        phone: this.$auth.user?.phone,
        profilePhotoUrl: this.$auth.user?.profilePhotoUrl
      },
      photo: null
    };
  },

  methods: {
    async updateDetails() {
      try {
        const res = await this.$axios.$post("/customer/profile", this.formData);
        this.$toast.success("Profile Updated successfully");
        this.$auth.setUser(res.data);
      } catch (error) {
        console.log(error);
      }
    },

    async submitImage() {
      const formData = new FormData();
      formData.append("photo", this.photo);
      const resPhoto = await this.$axios.$post(
        "/customer/profile-photo",
        formData
      );
      this.$auth.setUser(resPhoto.data);
      this.photo = null;
      this.$toast.success("Profile photo updated successfully");
    }
  },

  computed: {
    ...mapGetters({
      validationErrors: "validation/validationErrors"
    })
  }
};
</script>