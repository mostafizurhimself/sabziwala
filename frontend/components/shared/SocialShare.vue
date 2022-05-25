<template>
  <div class="flex item-center">
    <ShareNetwork v-for="network in networks" :network="network.network" :key="network.network" :url="link" :style="{ color: network.color }" :media="sharingProduct.thumbnailMediaUrl" :title="title" :description="sharingProduct.description" :quote="sharingProduct.description" class="ml-2">
      <component class="h-4 w-4 flex" :is="network.icon"></component>
      <!-- <span class="ml-1">{{ network.name }}</span> -->
    </ShareNetwork>
  </div>
</template>

<script>
export default {
  name: "SocialShare",
  props: {
    link: {
      type: String
    },
    sharingProduct: {
      type: Object
    },
    title: {
      type: String
    }
  },
  data() {
    return {
      sharing: {
        quote: "The hot reload is so fast it's near instant. - Evan You"
      }
    };
  },

  computed: {
    networks() {
      return [
        {
          network: "email",
          name: "Email",
          icon: `EmailClosed`,
          color: "#6B7280"
        },
        {
          network: "facebook",
          name: "Facebook",
          icon: `Facebook`,
          color: "#1877f2"
        }
      ];
    }
  }
};
</script>
