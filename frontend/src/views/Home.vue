<template>
  <div class="flex h-screen">
    <div class="m-auto">
      <h1 class="text-7xl text-center">
        ABC Company
      </h1>
      <h3 class="text-4xl text-center text-gray-600 mt-5">
        Complaints Portal
      </h3>
      <div class="flex justify-center mt-10">
        <form-button text="login" class="mr-1" @click="$router.push('Login')"></form-button>
        <form-button text="register" class="ml-1"></form-button>
      </div>
    </div>
  </div>
</template>

<script>
import FormButton from '../components/FormButton.vue'
export default {
  components: { FormButton },
  name: 'Home'
}
</script>
