<template>
  <section>
    <span v-html="content" />
  </section>
</template>

<script>
  export default {
    props: {
      src: {
        type: String,
        required: true,
      }
    },
    data() {
      return {
        content: '',
      }
    },
    watch: {
      src: {
        immediate: false,
        handler(src) {
          console.log(src)
          //this.$http('').then((response) => this.content = response.data);
        }
      }
    }
  }
</script>