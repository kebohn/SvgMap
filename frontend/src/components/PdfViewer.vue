<template>
    <b-notification :closable="false">
        <b-loading :is-full-page="false" :active.sync="isLoading">
            <b-icon icon="sync-alt" size="is-large" custom-class="fa-spin">
            </b-icon>
        </b-loading>
        <b-pagination v-if="!isLoading"
                      :total="numPages"
                      :current.sync="current"
                      range-before="1"
                      range-after="1"
                      order="is-centered"
                      perPage="1"
                      icon-prev="chevron-left"
                      icon-next="chevron-right"
                      @change="page = $event">
        </b-pagination>
        <pdf :src="src"
             :page="page"
             @loaded="isLoading = false">
        </pdf>
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
                pageCount: undefined,
                numPages: undefined,
                pdf: undefined,
                pages: [],
                page: undefined,
                current: 1,
            }
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
        }
    }
</script>
<style scoped>
</style>