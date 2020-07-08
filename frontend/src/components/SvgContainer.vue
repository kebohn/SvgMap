<template>
    <figure class="svg" ref="svg" v-html="content" @click="getLink($event)"></figure>
</template>

<script>
    export default {
        props: {
            fileId: { // File has to be fetched
                type: Number
            },
            file: { // File is already fetched
                type: String
            }
        },
        data() {
            return {
                content: '',
                pan: undefined,
                linkIsDisabled: false,
                activeNode: undefined,
                svg: undefined
            }
        },
        watch: {
            fileId: {
                immediate: false,
                async handler(fileId) {
                    let promise = await this.fetchFileById(fileId);
                    this.content = promise.data;
                    this.$nextTick(() => {
                        this.adjustSvgSize();
                    });
                }
            },
            file: {
                immediate: false,
                handler(file) {
                    this.content = file;
                    this.$nextTick(() => {
                        this.adjustSvgSize();
                    });
                }
            }
        },
        mounted() {
            this.$eventBus.$on('changeActiveNode', this.setNewActiveNode);
        },
        methods: {
            async fetchFileById(fileId) {
                return this.$http.get(`/api/files/${fileId}`);
            },
            async fetchFileByName(fileName) {
                let projectId = this.$route.params.id;
                return this.$http.get(`/api/files/${projectId}/file`,
                    {headers: {fileName}, responseType: 'blob',}).catch(() => {
                    return null;
                })
            },
            adjustSvgSize() {
                this.svg = this.$refs.svg.children[0];
                if (this.svg != null) {
                    this.svg.setAttribute("height", "100%");
                    this.svg.setAttribute("width", "100%");
                    this.$emit('updateLinkList', this.getLinkTags());
                    this.pan = this.$panzoom(this.svg, {
                        maxZoom: 4,
                        minZoom: 0.4,
                        bounds: true,
                        boundsPadding: 0.5,
                        smoothScroll: false
                    });
                }
            },
            getLinkTags() {
                return Array.from(this.svg.getElementsByTagName("a"))
            },
            async getLink(event) {
                event.preventDefault();
                if (this.linkIsDisabled) {return; }
                let node = event.target.parentNode;
                if (node.tagName !== 'FIGURE' && node.tagName !== "DIV") {
                    while (node.tagName !== 'a' && node.tagName !== 'svg') {
                        node = node.parentNode;
                    }
                    if (node.tagName === 'a') {
                        this.setNewActiveNode(node);
                        let promise = await this.fetchFileByName(node.getAttribute('xlink:href'));
                        if (promise !== null) {
                            this.$emit('openPdf', {data: promise.data, title: node.getAttribute('xlink:title')});
                        } else {
                            this.$emit('openExternalSource', node.getAttribute('xlink:href'));
                        }
                    }
                }
            },
            setNewActiveNode(node) {
                if (this.$refs.svg !== undefined) {
                    this.$refs.svg.children[0].classList.add('nonactiveNodes');
                    if (this.activeNode !== undefined) {
                        this.activeNode.classList.remove('activeNode');
                    }
                    node.classList.add('activeNode');
                    this.activeNode = node;
                }
            },
            resetActiveNode() {
                if (this.$refs.svg !== undefined) {
                    this.$refs.svg.children[0].classList.remove('nonactiveNodes');
                }
            },
            disableLinks() {
                this.linkIsDisabled = true;
            },
            enlargeSvg() {
                let coordinates = this.pan.getTransform()
                this.pan.smoothZoom(coordinates.x, coordinates.y, 1.2);
            },
            reduceSvg() {
                let coordinates = this.pan.getTransform()
                this.pan.smoothZoom(coordinates.x, coordinates.y, 0.8);
            },
            resetSvg() {
                this.pan.moveTo(0, 0);
                this.pan.zoomAbs(0, 0, 1);
            },
            disablePan() {
                this.pan.pause();
            },
            enablePan() {
                this.pan.resume();
            },
        }
    }
</script>
<style>
    .activeNode {
        fill-opacity: 100% !important;
    }
    .nonactiveNodes {
        fill-opacity: 50%;
    }
    .svg {
        height: 100vh;
    }
    .svg:focus {
        outline-color: rgba(255, 255, 255, 0);
    }
</style>