<template>
  <div class="h-screen flex">
    <form-container title="login form">
      <label class="block">
        <span class=text-gray-700>Email</span>
        <input class="mt-1 block w-full" type="text" v-model="email">
      </label>
      <label class="block mt-3">
        <span class=text-gray-700>Password</span>
        <input class="mt-1 block w-full" type="password" v-model="password">
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
import axios from 'axios'
export default {
  components: {
    FormContainer,
    FormButton
  },
  name: 'Login',
  data() {
    return {
      email: null,
      password: null
    }
  },
  methods: {
    login() {
        // I know this is hardcoded but I am going to move with this because I am short on time
        axios.post('http://api.complaints.local/v1/login', {
          email: this.email,
          password: this.password
        })
        .then((response) => {
          this.$cookie.set('Personal Access Token', response.data.data.api_token, 1)
          this.$router.push('Complaint');
        })
    }
  }
}
</script>
