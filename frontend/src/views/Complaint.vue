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
      <label class="block mt-3">
        <span class=text-gray-700>Urgent</span>
        <input class="ml-4" type="checkbox" v-model="urgent">
      </label>
      <template v-slot:footer>
        <form-button text="submit" @click="submit"></form-button>
      </template>
    </form-container>
  </div>
</template>

<script>
import FormContainer from '../components/FormContiner'
import FormButton from '../components/FormButton'
import axios from 'axios'
export default {
  components: {
    FormContainer,
    FormButton
  },
  name: 'Complaint',
  data() {
      return {
          title: null,
          description: null,
          urgent: false
      }
  },
  methods: {
    submit() {
        // I know this is hardcoded but I am going to move with this because I am short on time
        axios.post('http://api.complaints.local/v1/complaint', {
          title: this.title,
          description: this.description,
          urgent: this.urgent
        }, {
          headers: {
            Authorization: 'Bearer ' + this.$cookie.get('Personal Access Token')
          }
        })
        .then(() => {
          alert('Complaint saved!')
          this.clear()
        })
    },
    clear() {
      this.title = null
      this.description = null
      this.urgent = false
    }
  }
}
</script>
