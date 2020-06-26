<template>
  <div ref='viewer'></div>
</template>

<script>
  export default {
    name: 'WebViewer',
    props: {
      path: String,
      src: String
    },
    mounted: function () {
      console.log(this.url)
      WebViewer({
        path: this.path,
        initialDoc: this.src, // replace with your own PDF file
      }, this.$refs.viewer).then((instance) => {

      });
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  div {
    width: 100%;
    height: 100vh;
  }
</style>