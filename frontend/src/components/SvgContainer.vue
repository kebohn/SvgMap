<template>
  <section>
    <figure ref="svg" v-html="content" @click="getLink($event)"></figure>
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
                        /*
                        let list = Array.from(svg.getElementsByTagName("a"));

                        for (const c of list) {
                          console.log(c)
                        }

                         */
                      })
                  });
        }
      }
    },
    methods: {
      getLink(event) {
        console.log(event.target.parentNode.parentNode);
        event.preventDefault()
      }
    }
  }
</script>