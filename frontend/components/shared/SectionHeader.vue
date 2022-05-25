<template>
  <div class="section-header text-center">
    <h3 class="text-3xl sm:text-4xl font-semibold">
      <slot name="title">
        Header title
      </slot>
    </h3>
    <p class="mt-2 text-sm sm:text-md">
      <slot name="subtitle">
        Header Subtitle
      </slot>
    </p>
  </div>
</template>
