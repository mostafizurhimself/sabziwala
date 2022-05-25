<template>
  <div>
    <div class="my-3 flex items-center" v-for="(button, i) in buttons" :key="i">
      <input type="radio" v-if="button.show" :id="button.id" :value="button.value" @input="$emit('input', $event.target.value)" :name="button.name" />
      <label :for="button.id" v-if="button.show">
        <img :src="button.src" :alt="button.value" style="max-height: 30px; max-width: 100px" class="ml-2 cursor-pointer inline-block" />
      </label>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    buttons: {
      type: Array
    }
  }
};
</script>

<style lang="scss" scoped>
.button:not(:last-child) {
  margin-bottom: 15px;
}
</style>