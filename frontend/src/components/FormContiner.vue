<template>
  <div class="relative m-auto h-4/5 w-4/5 md:w-1/2 border-4 border-gray-600 rounded-3xl p-5">
    <h2 class="text-4xl text-gray-600 uppercase text-center mb-10">
      {{ title }}
    </h2>
    <slot></slot>
    <div class="absolute bottom-5 right-5">
      <slot name="footer"></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: 'FormContainer',
  props: {
    title: String
  }
}
</script>
