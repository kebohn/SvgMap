<template>
  <section>
    <figure ref="svg" v-html="content" @click="getLink($event)"></figure>
  </section>
</template>

<script>
  export default {
    props: {
      fileId: { // File has to be fetched
        type: Number
      },
      file: { // File is already fetched
        type: String
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
                    this.adjustSvgSize();
                  });
              });
        }
      },
      file: {
        immediate: false,
        handler(file) {
          this.content = file;
          this.$nextTick(() => {
            this.adjustSvgSize();
          });
        }
      }
    },

    methods: {
      adjustSvgSize() {
        let svg = this.$refs.svg.children[0];
        if (svg != null) {
          svg.setAttribute("height", "100%");
          svg.setAttribute("width", "100%");
          this.$emit('updateLinkList', Array.from(svg.getElementsByTagName("a")));
        }
      },
      getLink(event) {
        console.log(event.target);
        event.preventDefault()
      }
    }
  }
</script>