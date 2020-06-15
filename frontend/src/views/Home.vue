<template>
  <div>
      <h1>Home</h1>
      <router-link to="/about">About</router-link>
      <router-link to="/not-found">Not found</router-link>
  </div>
</template>

<script>
import DefaultLayout from '@/layouts/DefaultLayout'
export default {
    name: 'Home',
    created() {
        this.$emit('update:layout', DefaultLayout)
    }

}
</script>


<style>

</style>