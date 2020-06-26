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
        async handler(fileId) {
          let promise = await this.fetchFile(fileId);
          this.content = promise.data;
          this.$nextTick(() => {
            this.adjustSvgSize();
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
      async fetchFile(fileId) {
        return this.$http(`/api/files/${fileId}`)
      },
      adjustSvgSize() {
        let svg = this.$refs.svg.children[0];
        if (svg != null) {
          svg.setAttribute("height", "100%");
          svg.setAttribute("width", "100%");
          this.$emit('updateLinkList', Array.from(svg.getElementsByTagName("a")));
        }
      },
      async getLink(event) {
        event.preventDefault();
        let node = event.target.parentNode;
        if (node.tagName != null) {
          while(node.tagName !== 'a' && node.tagName !== 'svg') {
            node = node.parentNode;
          }
          if (node.tagName === 'a') {
            this.$emit('openPdf', node.getAttribute('xlink:href'));
          }
        }
      }
    }
  }
</script>