<template>
  <section>
      <b-notification class="wrapper" :closable="false">
          <b-loading :is-full-page="false" :active.sync="isLoading">
            <b-icon
                    icon="sync-alt" size="is-large" custom-class="fa-spin">
            </b-icon>
          </b-loading>
        <pdf v-for="i in numPages"
             :key="i"
             :src="src"
             :page="i"
             style="display: inline-block; width: 100%"
             @num-pages="pageCount = $event"
             @page-loaded="loading($event)">
        </pdf>
      </b-notification>
  </section>
</template>

<script>
  import pdf from 'vue-pdf'
  export default {
    components: {
      pdf: pdf
    },
    props: {
      file: {
        type: Uint8Array
      }
    },
    data() {
      return {
        progress: 0,
        isLoading: true,
        currentPage: 0,
        pageCount: 0,
        src: undefined,
        numPages: undefined,
      }
    },
    mounted() {
    },
    methods: {
      init() {
        this.$nextTick(() => {
          this.src = pdf.createLoadingTask(this.file);
          this.src.promise.then(pdf => {
            this.numPages = pdf.numPages;
          });
      });
      },
      loading(loadedPages) {
        this.isLoading = Math.round(loadedPages / this.pageCount * 100) !== 100;
      }
    }
  }
</script>
<style scoped>
  .wrapper {
    height: 500px;
    overflow-x:hidden;
    overflow-y:auto
  }

  </style>