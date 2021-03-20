<template>
  <button 
    class="px-4 py-2 rounded shadow bg-gradient-to-r from-yellow-300 to-yellow-400 hover:bg-gradient-to-l hover:from-yellow-500 hover:to-yellow-400 uppercase text-gray-800"
    @click="$emit('click')"
  >
    {{ text }}
  </button>
</template>

<script>
export default {
  name: 'FormButton',
  props: {
    text: String
  }
}
</script>
