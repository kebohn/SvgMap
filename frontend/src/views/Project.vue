<template>
    <multipane class="vertical-panes" layout="vertical">
        <div class="pane" :style="{ minWidth: '30%', width:'100%'}" @mousedown.stop>
            <svg-container class="svg" :fileId=fileId v-on:openPdf="openPdf"></svg-container>
        </div>
        <multipane-resizer></multipane-resizer>
        <div class="pane" :style="{ minWidth: '50%', flexGrow: 1}" v-if="showPdfComponent">
            <pdf-viewer v-bind:file="file" ref="pdfViewer"></pdf-viewer>
        </div>
    </multipane>
</template>

<script>
import { Multipane, MultipaneResizer } from 'vue-multipane'
import DefaultLayout from '@/layouts/DefaultLayout';
import SvgContainer from "@/components/SvgContainer";
import PdfViewer from "@/components/PdfViewer";
export default {
    name: 'Project',
    props: {
        id: null
    },
    components: {SvgContainer, PdfViewer, Multipane, MultipaneResizer },
    data() {
        return {
            project: Object,
            fileId: -1,
            file: null,
            showPdfComponent: false,
        }
    },
    created() {
        this.$emit('update:layout', DefaultLayout)
    },
    mounted() {
        this.fetchProject();
    },
    methods: {
        fetchProject() {
            this.$http.get(`/api/projects/${this.id}`).then(response => {
                this.project = response.data;
                this.$eventBus.$emit('titleUpdated', this.project.name);
                for (let file of response.data.files) {
                    if (file.name.split('.').pop().toLowerCase() === 'svg') {
                        this.fileId = file.id;
                        break;
                    }
                }
            });
        },
        async openPdf(blob) {
            this.showPdfComponent = false;
            this.$nextTick(async () => {
                this.showPdfComponent = true;
                this.file = new Uint8Array(await blob.arrayBuffer());
                this.$refs.pdfViewer.init();
            });
        }
    }
}
</script>

<style scoped>
    .layout-v > .multipane-resizer {
        height: unset;
    }
    .multipane > div {
        position: unset;
        z-index: unset;
    }
    .vertical-panes > .pane {
        overflow: hidden;
    }
    .vertical-panes > .pane ~ .pane {
        border-left: 1px solid #ccc;
    }
</style>