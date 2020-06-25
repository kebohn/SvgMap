<template>
  <section>
    <pdf :src="src"></pdf>
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
        type: String
      }
    },
    data() {
      return {
      }
    },
    methods: {
    }
  }
</script>