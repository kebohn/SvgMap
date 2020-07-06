<template>
    <b-notification class="wrapper" :closable="false">
                <b-field class=" is-pulled-right">
                    <b-select v-model="zoomVal" placeholder="100%" size="is-small">
                        <option v-for="option in options" v-bind:value="option.value">
                            {{option.text}}
                        </option>
                    </b-select>
                </b-field>
        <b-loading :is-full-page="false" :active.sync="isLoading">
            <b-icon icon="sync-alt" size="is-large" custom-class="fa-spin">
            </b-icon>
        </b-loading>
        <b-pagination v-if="!isLoading"
                      :total="numPages"
                      :current.sync="current"
                      perPage="1"
                      size="is-small"
                      simple="true"
                      order="is-centered"
                      icon-prev="chevron-left"
                      icon-next="chevron-right"
                      @change="page = $event">
        </b-pagination>
        <div class="pdfContainer m-t-md column is-centered">
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
            }
        }
    }
</script>
<style scoped>
    .wrapper {
        height:100vh;
        position:relative;
    }
    .pdfContainer {
        overflow: auto;
        position: absolute;
        max-height: 65vh;
        max-width: 35vw;
        right:0;left:0;
        margin:auto;
    }
</style>