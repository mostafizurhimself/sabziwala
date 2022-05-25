<template>
  <div :class="`badge ${map[value]} text-white`">
    {{ value }}
  </div>
</template>

<script>
export default {
  props: {
    /**
     * Avilable Value for Badge
     */
    value: {
      type: String,
      require: true
    }
  },
  data() {
    return {
      map: {
        pending: "pending-bg",
        processing: "processing-bg",
        shipped: "shipped-bg",
        delivered: "delivered-bg",
        canceled: "canceled-bg",
        refunded: "refunded-bg",
        accepted: "accepted-bg",
        rejected: "rejected-bg",
        declined: "declined-bg"
      }
    };
  }
};
</script>

<style lang="scss" scoped>
.badge {
  @apply inline-flex items-center justify-center px-3 py-1 text-xs uppercase font-semibold leading-none text-white rounded-full;
}

.pending-bg {
  @apply bg-yellow-100 text-yellow-500;
}

.processing-bg {
  @apply bg-indigo-100 text-indigo-500;
}

.shipped-bg {
  @apply bg-blue-100 text-blue-500;
}

.delivered-bg {
  @apply bg-green-100 text-green-500;
}

.canceled-bg {
  @apply bg-red-100 text-red-500;
}

.refunded-bg {
  @apply bg-gray-100 text-gray-500;
}

.accepted-bg {
  @apply bg-green-100 text-green-500;
}

.rejected-bg {
  @apply bg-red-100 text-red-500;
}

.declined-bg {
  @apply bg-red-100 text-red-500;
}
</style>
