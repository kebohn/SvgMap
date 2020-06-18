<template>
  <div>
      <section class="hero">
          <div class="hero-body">
              <div class="container">
                  <h1 class="title">
                      Project
                  </h1>
              </div>
          </div>
      </section>
      <FileUploader></FileUploader>
  </div>
</template>

<script>
import DefaultLayout from '@/layouts/DefaultLayout';
import FileUploader from "@/components/FileUploader";
export default {
    name: 'Project',
    props: {
        id: null
    },
    components: {FileUploader},
    data() {
        return {
            project: Object
        }
    },
    created() {
        this.$emit('update:layout', DefaultLayout)
    },
    mounted() {
        this.fetchProject();
    },
    methods: {
        fetchProject() {
            this.$http.get(`/api/projects/${this.id}`).then(response => {
                console.log(response.data)
                this.project = response.data
                console.log(this.project);
            });
        }
    }

}
</script>


<style>

</style>