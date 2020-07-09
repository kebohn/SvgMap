<template>
    <b-notification class="wrapper" :closable="false">
        <section class="section ">
            <div class="container">

                <viewer-controls v-bind:title="title" v-on:downloadFile="downloadFile"
                                 v-on:setZoomVal="setZoomVal">
                </viewer-controls>
                <b-loading :is-full-page="false" :active.sync="isLoading">
                    <b-icon icon="sync-alt" size="is-large" custom-class="fa-spin">
                    </b-icon>
                </b-loading>
                <b-pagination v-if="!isLoading"
                              :total="numPages"
                              :current.sync="current"
                              perPage="1"
                              size="is-small"
                              simple="simple"
                              order="is-right"
                              icon-prev="chevron-left"
                              icon-next="chevron-right"
                              @change="page = $event">
                </b-pagination>
                <h1 class="title is-5"></h1>
                <div class="pdfContainer">
                    <pdf ref="pdf" :src="src"
                         :page="page"
                         @loaded="isLoading = false"
                         :style="style">
                    </pdf>
                </div>

            </div>
        </section>
    </b-notification>
</template>

<script>
    import pdf from 'vue-pdf'
    import ViewerControls from "@/components/ViewerControls";

    export default {
        components: {pdf, ViewerControls},
        props: {
            file: {},
            title: {
                type: String
            }
        },
        data() {
            return {
                isLoading: true,
                src: undefined,
                numPages: undefined,
                pdf: undefined,
                page: undefined,
                current: 1,
                style: String
            }
        },
        computed: {
            width() {
                return `width: ${this.zoomVal}%`;
            },
        },
        methods: {
            init() {
                this.$nextTick(() => {
                    this.src = pdf.createLoadingTask(this.file);
                    this.src.promise.then(pdf => {
                        this.pdf = pdf;
                        this.numPages = pdf.numPages;
                    });
                });
            },
            downloadFile() {
                this.$emit('downloadFile', {title: this.title});
            },
            setZoomVal(val) {
                this.style = 'width: ' + val;
            }
        }
    }
</script>
<style scoped>
    .wrapper {
        height:100vh;
    }
    .pdfContainer {
        overflow: auto;
        position: absolute;
        max-height: 70vh;
        max-width: 70vw;
        right:1%;left:1%;
        margin:auto;
    }
</style>