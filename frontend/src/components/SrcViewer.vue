<template>
    <iframe :src="src" class="iframeContainer"></iframe>
</template>

<script>
    export default {
        props: {
            src: {
                type: String
            }
        },
    }
</script>
<style scoped>
    .iframeContainer {
        height: 100vh;
        width: 100vh;
    }
    .iframeContainer:focus {
        outline-color: rgba(255, 255, 255, 0);
    }
</style>