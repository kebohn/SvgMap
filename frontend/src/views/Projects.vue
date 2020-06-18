<template>
  <div>
      <section class="hero">
          <div class="hero-body">
              <div class="container">
                  <h1 class="title">
                      Projects
                  </h1>
              </div>
          </div>
      </section>
      <project-list></project-list>
  </div>
</template>

<script>
import DefaultLayout from '@/layouts/DefaultLayout';
import ProjectList from "@/components/ProjectList";
export default {
    name: 'Projects',
    components: {ProjectList},
    created() {
        this.$emit('update:layout', DefaultLayout)
    }

}
</script>


<style>

</style>