<template>
        <div class="field is-grouped is-pulled-left">
            <b-tooltip type="is-link" label="Adjust Zoom"
                       position="is-right"
                       animated>
                <b-field >
                    <b-select v-model="zoomVal" placeholder="100%" size="is-small" @input="setZoomVal">
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
</template>

<script>
    export default {
        props: {
            title: {
                type: String
            }

        },
        data() {
            return {
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
            scale() {
                return `${this.zoomVal}%`;
            },
        },
        methods: {
            downloadFile() {
                this.$emit('downloadFile')
            },
            setZoomVal() {
                this.$emit('setZoomVal', this.scale)
            }
        }
    }
</script>
<style scoped>
</style>