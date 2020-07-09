<template>
    <b-notification class="wrapper" :closable="false">
        <section class="section">
            <div class="container">
                <div class="columns is-centered">
                    <div class="column">
                        <figure class="image">
                            <iframe :src="src" class="iframeContainer"></iframe>
                        </figure>
                    </div>
                </div>
            </div>
        </section>
    </b-notification>
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
    .wrapper {
        height: 100vh;
    }
    .iframeContainer {
        width: 100%;
    }
    .iframeContainer:focus {
        outline-color: rgba(255, 255, 255, 0);
    }
</style>