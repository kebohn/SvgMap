<template>
  <div>
      <h1>Projects</h1>
      <projects></projects>
  </div>
</template>

<script>
import DefaultLayout from '@/layouts/DefaultLayout';
import Projects from "@/components/Projects";
export default {
    name: 'Home',
    components: {Projects},
    created() {
        this.$emit('update:layout', DefaultLayout)
    }

}
</script>


<style>

</style>