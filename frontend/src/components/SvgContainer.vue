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
                panzoomInstance: undefined
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
                let svg = this.$refs.svg.children[0];
                if (svg != null) {
                    svg.setAttribute("height", "100%");
                    svg.setAttribute("width", "100%");
                    this.$emit('updateLinkList', Array.from(svg.getElementsByTagName("a")));
                    this.panzoomInstance = this.$panzoom(svg, {
                        maxZoom: 4,
                        minZoom: 0.2,
                        bounds: true,
                        boundsPadding: 0.3
                    });
                }
            },
            async getLink(event) {
                event.preventDefault();
                let node = event.target.parentNode;
                if (node.tagName !== 'FIGURE') {
                    while (node.tagName !== 'a' && node.tagName !== 'svg') {
                        node = node.parentNode;
                    }
                    if (node.tagName === 'a') {
                        let promise = await this.fetchFileByName(node.getAttribute('xlink:href'))
                        if (promise !== null) {
                            this.$emit('openPdf', promise.data);
                        }
                    }
                }
            },
            enlargeSvg() {
                let coordinates = this.panzoomInstance.getTransform()
                this.panzoomInstance.smoothZoom(coordinates.x, coordinates.y, 1.25);
            },
            reduceSvg() {
                let coordinates = this.panzoomInstance.getTransform()
                this.panzoomInstance.smoothZoom(coordinates.x, coordinates.y, 0.8);
            }
        }
    }
</script>
<style scoped>
    .svg {
        height: 100vh;
    }
</style>