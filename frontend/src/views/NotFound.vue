<template>
  <div>
      This page does not exist
  </div>
</template>

<script>
import PageNotFoundLayout from "@/layouts/PageNotFoundLayout";

export default {
    name: 'Home',
    created() {
        this.$emit('update:layout', PageNotFoundLayout)
    }
}

</script>

<style>

</style>