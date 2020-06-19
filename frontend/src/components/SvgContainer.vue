<template>
  <section>
    <figure v-html="content"></figure>
  </section>
</template>

<script>
  export default {
    props: {
      fileId: {
        type: Number,
        required: true,
      }
    },
    data() {
      return {
        content: '',
      }
    },
    watch: {
      fileId: {
        immediate: false,
        handler(fileId) {
          this.$http(`/api/files/${fileId}`)
                  .then((response) => {
                      this.content = response.data;
                  });
        }
      }
    }
  }
</script>