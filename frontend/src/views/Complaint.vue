<template>
  <div class="h-screen flex">
    <form-container title="complaint form">
      <label class="block">
        <span class=text-gray-700>Title</span>
        <input class="mt-1 block w-full" type="text" v-model="title">
      </label>
      <label class="block mt-3">
        <span class=text-gray-700>Description</span>
        <textarea class="mt-1 block w-full" v-model="description"></textarea>
      </label>
      <template v-slot:footer>
        <form-button text="submit" @click="login"></form-button>
      </template>
    </form-container>
  </div>
</template>

<script>
import FormContainer from '../components/FormContiner'
import FormButton from '../components/FormButton'
export default {
  components: {
    FormContainer,
    FormButton
  },
  name: 'Complaint',
  data() {
      return {
          title: null,
          description: null
      }
  }
}
</script>
