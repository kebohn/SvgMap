<template>
    <multipane class="vertical-panes" layout="vertical">
        <div class="pane" ref="svgPane" :style="{ minWidth: '30%', width: '100%'}" @mousedown.stop>
            <div class="buttons svgControls">
                <b-tooltip type="is-link" label="Show Files"
                           position="is-bottom"
                           animated>
                    <b-button size="is-medium" icon-left="file" @click="showFiles()">
                    </b-button>
                </b-tooltip>
                <b-tooltip type="is-link" label="Enlarge"
                           position="is-bottom"
                           animated>
                    <b-button size="is-medium" icon-left="plus" @click="enlargeSvg()">
                    </b-button>
                </b-tooltip>
                <b-tooltip type="is-link" label="Reduce"
                           position="is-bottom"
                           animated>
                    <b-button size="is-medium" icon-left="minus" @click="reduceSvg()">
                    </b-button>
                </b-tooltip>
                <b-tooltip type="is-link" label="Reset"
                           position="is-bottom"
                           animated>
                    <b-button size="is-medium" icon-left="expand-alt" @click="resetSvg()">
                    </b-button>
                </b-tooltip>
                <b-tooltip type="is-link" label="Close Viewer"
                           position="is-bottom"
                           animated>
                    <b-button v-if="showPdfComponent || showSrcComponent || showFileComponent"  size="is-medium" icon-left="eye-slash"
                              @click="hideComponent()">
                    </b-button>
                </b-tooltip>
            </div>
            <svg-container ref="svgContainer" class="svgContainer" :fileId=fileId v-on:openPdf="openPdf"
                                        v-on:openExternalSource="openExternalSource"></svg-container>
        </div>
        <multipane-resizer v-if="showPdfComponent || showSrcComponent || showFileComponent"></multipane-resizer>
        <div class="pane" :style="{ minWidth: '40%', flexGrow: 1}" v-if="showPdfComponent || showSrcComponent || showFileComponent">
            <pdf-viewer v-if="showPdfComponent" v-bind:file="file" v-bind:title="title" ref="pdfViewer"
            v-on:downloadFile="downloadFile"></pdf-viewer>
            <src-viewer v-if="showSrcComponent" v-bind:src="src" ref="srcViewer"></src-viewer>
            <file-viewer v-if="showFileComponent" v-bind:files="project.files" ref="fileViewer"></file-viewer>
        </div>
    </multipane>
</template>

<script>
import { Multipane, MultipaneResizer } from 'vue-multipane'
import DefaultLayout from '@/layouts/DefaultLayout';
import SvgContainer from "@/components/SvgContainer";
import PdfViewer from "@/components/PdfViewer";
import SrcViewer from "@/components/SrcViewer";
import FileViewer from "@/components/FileViewer";
export default {
    name: 'Project',
    props: {
        id: null
    },
    components: {SvgContainer, PdfViewer, SrcViewer, FileViewer, Multipane, MultipaneResizer },
    data() {
        return {
            project: Object,
            fileId: -1,
            file: null,
            title: undefined,
            src: undefined,
            showPdfComponent: false,
            showSrcComponent: false,
            showFileComponent: false,
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
        async openPdf(args) {
            if (this.showSrcComponent === false && this.showPdfComponent === false && this.showFileComponent === false) {
                this.$refs.svgContainer.resetSvg();
            }
            this.showSrcComponent = false;
            this.showPdfComponent = false;
            this.showFileComponent = false;
            this.$nextTick(async () => {
                this.showPdfComponent = true;
                let file = args.data;
                this.title = args.title;
                this.file = new Uint8Array(await file.arrayBuffer());
                this.$refs.pdfViewer.init();
            });
        },
        async openExternalSource(src) {
            if (this.showSrcComponent === false && this.showPdfComponent === false && this.showFileComponent === false) {
                this.$refs.svgContainer.resetSvg();
            }
            this.showPdfComponent = false;
            this.showFileComponent = false;
            this.showSrcComponent = true;
            this.src = src;
        },
        showFiles() {
            this.showPdfComponent = false;
            this.showSrcComponent = false;
            this.showFileComponent = true;
        },
        hideComponent() {
            this.showPdfComponent = false;
            this.showSrcComponent = false;
            this.showFileComponent = false;
            this.$refs.svgPane.style["width"] = "100%";
            this.$refs.svgContainer.resetSvg();
            this.$refs.svgContainer.resetActiveNode();
        },
        enlargeSvg() {
            this.$refs.svgContainer.enlargeSvg();
        },
        reduceSvg() {
            this.$refs.svgContainer.reduceSvg();
        },
        resetSvg() {
            this.$refs.svgContainer.resetSvg();
        },
        downloadFile() {
            let fileURL = window.URL.createObjectURL(new Blob([this.file]));
            let fileLink = document.createElement('a');
            fileLink.href = fileURL;
            fileLink.setAttribute('download', 'download.pdf');
            document.body.appendChild(fileLink);
            fileLink.click();
        }
    }
}
</script>

<style scoped>
    .svgControls {
        z-index: 2;
        position: absolute;
    }
    .layout-v > .multipane-resizer {
        height: unset;
        position: relative;
    }
    .multipane > div {
        position: unset;
        z-index: unset;
    }
    .vertical-panes > .pane {
        overflow: hidden;
        height: 80vh;
    }
    .vertical-panes > .pane ~ .pane {
        border-left: 1px solid #ccc;
    }
</style>