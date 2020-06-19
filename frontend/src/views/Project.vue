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
      <svg-container :fileId=fileId></svg-container>
      <FileUploader></FileUploader>
  </div>
</template>

<script>
import DefaultLayout from '@/layouts/DefaultLayout';
import FileUploader from "@/components/FileUploader";
import SvgContainer from "@/components/SvgContainer";
export default {
    name: 'Project',
    props: {
        id: null
    },
    components: {SvgContainer, FileUploader},
    data() {
        return {
            project: Object,
            fileId: -1,
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
                this.project = response.data
                for (let file of response.data.files) {
                    if (file.name.split('.').pop().toLowerCase() === 'svg') {
                        this.fileId = file.id;
                        break;
                    }
                }
            });
        }
    }

}
</script>

<style>

</style>