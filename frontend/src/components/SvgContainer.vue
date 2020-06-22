<template>
  <section>
    <figure ref="svg" v-html="content"></figure>
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
                      this.$nextTick(() => {
                        let svg = this.$refs.svg.children[0];
                        svg.setAttribute("height", "100%");
                        svg.setAttribute("width", "100%");
                      })
                  });
        }
      }
    }
  }
</script>