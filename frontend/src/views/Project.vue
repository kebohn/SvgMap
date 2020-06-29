<template>
  <div>
      <section class="hero">
          <div class="hero-body">
              <div class="container">
                  <h1 class="title">
                      Project {{this.project.name}}
                  </h1>
              </div>
          </div>
      </section>
      <sidebar></sidebar>
      <svg-container :fileId=fileId v-on:openPdf="openPdf"></svg-container>
      <pdf-viewer v-bind:src="src" v-if="showPdfComponent"></pdf-viewer>
      <FileUploader></FileUploader>
  </div>
</template>

<script>

import DefaultLayout from '@/layouts/DefaultLayout';
import FileUploader from "@/components/FileUploader";
import SvgContainer from "@/components/SvgContainer";
import Sidebar from "@/components/Sidebar";
import PdfViewer from "@/components/PdfViewer";
export default {
    name: 'Project',
    props: {
        id: null
    },
    components: {SvgContainer, FileUploader, Sidebar, PdfViewer},
    data() {
        return {
            project: Object,
            fileId: -1,
            src: null,
            showPdfComponent: false,
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
        },
        async openPdf(blob) {
            this.showPdfComponent = true;
            this.src = new Uint8Array(await blob.arrayBuffer());
        }
    }
}
</script>

<style>

</style>