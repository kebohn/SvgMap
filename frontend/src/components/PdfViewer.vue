<template>
  <section>
    <pdf :src="src"
         @num-pages="pageCount = $event"
         @page-loaded="currentPage = $event">
    </pdf>
  </section>
</template>

<script>
  import pdf from 'vue-pdf'
  export default {
    components: {
      pdf: pdf
    },
    props: {
      src: {
        type: Uint8Array
      }
    },
    data() {
      return {
        currentPage: 0,
        pageCount: 0,
      }
    },
    methods: {
    }
  }
</script>