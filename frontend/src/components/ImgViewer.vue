<template>
    <b-notification class="imageContainer" :closable="false">
        <section class="section">
            <div class="container">
                <div class="columns is-centered">
                    <div class="column">
                        <viewer-controls v-bind:title="title"
                                         v-on:downloadFile="downloadFile"
                                         v-on:setZoomVal="setZoomVal">
                        </viewer-controls>
                    </div>
                </div>
                <div class="columns is-centered">
                    <div class="column">
                        <div class="img">
                            <figure class="image" :style="style">
                                <img alt="" class="has-ratio" :src="src"/>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </b-notification>
</template>

<script>
    import ViewerControls from "@/components/ViewerControls";

    export default {
        components: {ViewerControls},
        props: {
            src: {
                type: String
            },
            title: {
                type: String
            }
        },
        data() {
            return {
                style: String,
            }
        },
        methods: {
            downloadFile() {
                this.$emit('downloadFile', {title: this.title});
            },
            setZoomVal(val) {
                this.style = `width: ${val}; height: ${val}`;
            }
        }
    }
</script>
<style scoped>
    .imageContainer {
        height: 100vh;
    }
    .imageContainer:focus {
        outline-color: rgba(255, 255, 255, 0);
    }
    .img {
        overflow: auto;
        position: absolute;
        max-height: 70vh;
        max-width: 70vw;
        right:1%;left:1%;
        margin:auto;
    }
</style>