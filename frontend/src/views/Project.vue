<template>
    <multipane class="vertical-panes" layout="vertical">
        <div class="pane" ref="svgPane" :style="{ minWidth: '30%', width: '100%'}" @mousedown.stop>
            <svg-controls v-bind:args="projectControlArgs"
                          v-on:showFiles="showFiles"
                          v-on:enlargeSvg="enlargeSvg"
                          v-on:reduceSvg="reduceSvg"
                          v-on:resetSvg="resetSvg"
                          v-on:hideComponent="hideComponent">
            </svg-controls>
            <svg-container ref="svgContainer" class="svgContainer" :fileId=fileId
                           v-on:openFile="openFile"
                           v-on:openExternalSource="openExternalSource">
            </svg-container>
        </div>
        <multipane-resizer v-if="showPdfComponent || showSrcComponent || showFileComponent || showImgComponent">
        </multipane-resizer>
        <div class="pane" :style="{ minWidth: '40%', flexGrow: 1}"
             v-if="showPdfComponent || showSrcComponent || showFileComponent || showImgComponent">
            <pdf-viewer v-if="showPdfComponent" v-bind:file="file" v-bind:title="title"
                        v-on:downloadFile="downloadFile"
                        ref="pdfViewer"
            ></pdf-viewer>
            <src-viewer v-if="showSrcComponent" v-bind:src="src" ref="srcViewer"></src-viewer>
            <file-viewer v-if="showFileComponent" v-bind:files="project.files"
                         v-bind:links="links"
                         ref="fileViewer">
            </file-viewer>
            <img-viewer v-if="showImgComponent" v-bind:src="src" v-bind:title="title"
                        v-on:downloadFile="downloadFile"
                        ref="imgViewer">
            </img-viewer>
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
import ImgViewer from "@/components/ImgViewer";
import SvgControls from "@/components/SvgControls";
export default {
    name: 'Project',
    props: {
        id: null
    },
    components: {SvgContainer, PdfViewer, SrcViewer, FileViewer, ImgViewer, SvgControls, Multipane, MultipaneResizer},
    data() {
        return {
            project: Object,
            fileId: -1,
            file: null,
            title: undefined,
            src: undefined,
            links: undefined,
            showPdfComponent: false,
            showSrcComponent: false,
            showFileComponent: false,
            showImgComponent: false,
        }
    },
    computed: {
        projectControlArgs() {
            return {
                showPdfComponent: this.showPdfComponent,
                showSrcComponent: this.showSrcComponent,
                showFileComponent: this.showFileComponent,
                showImgComponent: this.showImgComponent
            }
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
        async openFile(args) {
            if (this.showSrcComponent === false && this.showPdfComponent === false && this.showFileComponent === false) {
                this.$refs.svgContainer.resetSvg();
            }
            this.showSrcComponent = false;
            this.showPdfComponent = false;
            this.showFileComponent = false;
            this.showImgComponent = false;
            this.$nextTick(async () => {
                this.title = args.title;
                let ext = args.title.split('.').pop().toLowerCase();
                if (ext === 'pdf') {
                    this.showPdfComponent = true;
                    this.file = new Uint8Array(await args.data.arrayBuffer());
                    this.$refs.pdfViewer.init();
                } else if (ext === 'jpg' || ext === 'png' || ext === 'jpeg') {
                    this.showImgComponent = true;
                    this.file = await args.data.arrayBuffer();
                    this.src = URL.createObjectURL(args.data) ;
                } else {
                    console.log("asd")
                }
            });
        },
        async openExternalSource(src) {
            if (this.showSrcComponent === false && this.showPdfComponent === false && this.showFileComponent === false) {
                this.$refs.svgContainer.resetSvg();
            }
            this.showPdfComponent = false;
            this.showFileComponent = false;
            this.showImgComponent = false;
            this.showSrcComponent = true;
            this.src = src
        },
        showFiles() {
            this.showPdfComponent = false;
            this.showSrcComponent = false;
            this.showFileComponent = true;
            this.showImgComponent = false;
            this.$refs.svgContainer.resetActiveNode();
            this.links = this.$refs.svgContainer.getLinkTags();
        },
        hideComponent() {
            this.showPdfComponent = false;
            this.showSrcComponent = false;
            this.showFileComponent = false;
            this.showImgComponent = false;
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
        downloadFile(args) {
            let fileURL = window.URL.createObjectURL(new Blob([this.file]));
            let fileLink = document.createElement('a');
            fileLink.href = fileURL;
            fileLink.setAttribute('download', args.title);
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