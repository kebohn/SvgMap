<template>
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
            <b-button v-if="args.showPdfComponent || args.showSrcComponent || args.showFileComponent || args.showImgComponent"
                      size="is-medium" icon-left="eye-slash"
                      @click="hideComponent()">
            </b-button>
        </b-tooltip>
    </div>
</template>

<script>
    export default {
        props: {
            args: {}
        },
        methods: {
            showFiles() {
                this.$emit('showFiles');
            },
            enlargeSvg() {
                this.$emit('enlargeSvg');
            },
            reduceSvg() {
                this.$emit('reduceSvg');
            },
            resetSvg() {
                this.$emit('resetSvg');
            },
            hideComponent() {
                this.$emit('hideComponent');
            }
        }
    }
</script>
<style scoped>
</style>