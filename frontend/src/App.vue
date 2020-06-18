<template>
  <div>
    <component :is='layout'>
    <router-view :layout.sync='layout'></router-view>
    </component>
  </div>
</template>

<script>

export default {
  name: 'App',
  data() {
    return {
      // fallback in case no layout defined for a specific view
      layout: 'div',
    }
  }
}
</script>

<style scoped>

</style>