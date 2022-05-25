<template>
  <div>
    <rider-header></rider-header>
    <div style="padding-top: 80px">
      <nuxt></nuxt>
    </div>
  </div>
</template>

<script>
import RiderHeader from "~/components/layouts/RiderHeader.vue";
export default {
  name: "rider-layout",
  components: { RiderHeader },

  async fetch() {
    try {
      await this.$store.dispatch("config/setConfig", { url: "/config" });
    } catch (error) {
      console.error(error);
    }
  }
};
</script>

<style lan
RiderHeaderg="scss" scoped>
</style>