<template>
    <b-notification class="wrapper" :closable="false">
        <div class="field is-grouped is-pulled-left">
            <b-tooltip type="is-link" label="Adjust Zoom"
                       position="is-right"
                       animated>
                <b-field >
                    <b-select v-model="zoomVal" placeholder="100%" size="is-small">
                        <option v-for="(option, index) in options" v-bind:value="option.value" :key="index">
                            {{option.text}}
                        </option>
                    </b-select>
                </b-field>
            </b-tooltip>
            <b-tooltip type="is-link" :label="title"
                       position="is-right"
                       animated>
                <b-button size="is-small"
                          icon-left="info">
                </b-button>
            </b-tooltip>
            <b-tooltip type="is-link" label="Download File"
                       position="is-right"
                       animated>
                <b-button size="is-small"
                          icon-left="download"
                          @click="downloadFile">
                </b-button>
            </b-tooltip>

        </div>
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
                 :style="width">
            </pdf>
        </div>
    </b-notification>
</template>

<script>
    import pdf from 'vue-pdf'
    import range from 'lodash.range';

    export default {
        components: {
            pdf: pdf
        },
        props: {
            file: {
                type: Uint8Array
            },
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
                pages: [],
                page: undefined,
                current: 1,
                zoomVal: 100,
                options: [
                    { text: '50%', value: '50' },
                    { text: '75%', value: '75' },
                    { text: '100%', value: '100' },
                    { text: '125%', value: '125' },
                    { text: '150%', value: '150' },
                    { text: '175%', value: '175' },
                    { text: '200%', value: '200' },
                    { text: '225%', value: '225' },
                    { text: '250%', value: '250' },
                ]
            }
        },
        computed: {
            width() {
                return `width: ${this.zoomVal}%`;
            },
        },
        watch: {
            pdf(pdf) {
                this.pages = [];
                const promises = range(1, pdf.numPages).map(number => pdf.getPage(number));
                Promise.all(promises).then(pages => {
                    this.pages = pages;
                });
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
                this.$emit('downloadFile')

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
        max-height: 74vh;
        max-width: 70vw;
        right:1%;left:1%;
        margin:auto;
    }
</style>