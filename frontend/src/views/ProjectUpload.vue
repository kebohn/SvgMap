<template>
    <div>
        <div class="field is-grouped m-t-md is-pulled-right">
            <div class="control">
                <button :disabled=isDisabled
                        @click="submit()" class="button is-link">Submit
                </button>
            </div>
        </div>
        <div class="is-clearfix"></div>

        <b-field label="ProjectName">
            <b-input v-model="projectName" @input="checkSubmitCondition"></b-input>
        </b-field>
        <b-field>
            <div class="buttons">
                <b-button size="is-small"
                          v-for="(link, index) in links"
                          :key="index"
                          v-bind:class="uploaded[index] === true ? 'is-success' : 'is-danger'"
                          @click="activateBtn(index)">
                    {{link.getAttribute("xlink:title")}}
                </b-button>
            </div>
        </b-field>
        <file-uploader ref="fileUploader" v-if="showFileUpload"
                       v-on:checkFirstFile="checkFirstFile"
                       v-on:checkLinksCondition="checkLinksCondition"
                       v-on:deleteDropFile="deleteDropFile"
                       v-bind:text="`Drop your files here or click to upload,
                                        the first uploaded file must be a 'svg'-file`"
                       v-bind:multiple="true">
        </file-uploader>
        <svg-container class="svgContainer"
                       ref="svgContainer"
                       :file=file
                       v-on:updateLinkList="updateLinkList">
        </svg-container>
    </div>
</template>

<script>
    import DefaultLayout from "@/layouts/DefaultLayout";
    import FileUploader from "@/components/FileUploader";
    import SvgContainer from "@/components/SvgContainer";

    export default {
        name: "FileUpload",
        components: {FileUploader, SvgContainer},
        data() {
            return {
                file: null,
                projectName: '',
                links: [],
                clicked: Number,
                uploaded: [],
                showFileUpload: true,
                isDisabled: true,
            };
        },
        created() {
            this.$emit('update:layout', DefaultLayout)
            this.$eventBus.$emit('titleUpdated', 'New Project');
        },
        methods: {
            submit() {
                let formData = new FormData();
                for (let i = 0; i < this.$refs.fileUploader.dropFiles.length; i++) {
                    let file = this.$refs.fileUploader.dropFiles[i];
                    formData.append('files[' + i + ']', file);
                }
                this.$http.post('/api/projects', formData, {
                    headers: {'x-project-title': this.projectName}
                }).then(response => {
                    this.$buefy.toast.open(`Project created successfully`)
                    this.$router.push({name: 'Project', params: {id: response.data['projectId']}})

                }).catch(error => {
                    this.$buefy.toast.open(`An error occurred, please try again!\n ${error}`);
                });
            },
            deleteDropFile(index) {
                if (this.getFileExtension(this.$refs.fileUploader.dropFiles[index].name) === 'svg') {
                    this.resetFileUploadForm();
                    this.isDisabled = true;
                } else {
                    this.$refs.fileUploader.removeItemFromDropFiles(index);
                    this.checkLinksCondition()
                }
            },
            checkFirstFile(files) {
                if (this.getFileExtension(files[0].name) === 'svg') {
                    const reader = new FileReader();
                    reader.readAsText(files[0]);
                    reader.onload = e => this.file = e.target.result;
                } else {
                    this.$refs.fileUploader.resetDropFiles();
                    this.$buefy.toast.open({
                        message: `Please upload a ".svg"-file`,
                        type: 'is-danger'
                    });
                    this.resetFileUploadForm();
                }
            },
            checkLinksCondition() {
                this.uploaded = new Array(this.links.length).fill(false);
                for (let [indexEntry, item] of this.links.entries()) {
                    for (let file of this.$refs.fileUploader.dropFiles) {
                        if (file.name === this.getBaseName(item.getAttribute("xlink:href"))) {
                            this.uploaded[indexEntry] = true;
                        }
                    }
                }
                this.checkSubmitCondition();
            },
            checkSubmitCondition() {
                if (this.projectName === '' || this.file === null) {
                    this.isDisabled = true;
                    return;
                }
                for (let item of this.uploaded) {
                    if (item === false) {
                        this.isDisabled = true;
                        return;
                    }
                }
                this.isDisabled = false;
            },
            updateLinkList(list) {
                for (let item of list) {
                    if (!this.isUrl(item.getAttribute("xlink:href"))) {
                        this.links.push(item);
                    }
                }
                this.uploaded = new Array(this.links.length).fill(false);
                this.$nextTick(() => {
                    this.$refs.svgContainer.disableLinks();
                    this.$refs.svgContainer.disablePan();
                })
            },
            activateBtn(e) {
                this.clicked = e;
            },
            getBaseName(str) {
                return str.substr(str.lastIndexOf("\\") + 1);
            },
            getFileExtension(file) {
                return file.split('.').pop().toLowerCase()
            },
            isUrl(file) {
                let regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@\-/]))?/
                return regexp.test(file.toLowerCase());
            },
            resetFileUploadForm() {
                this.showFileUpload = false;
                this.$nextTick(() => {
                    this.file = null;
                    this.clicked = null;
                    this.links = [];
                    this.showFileUpload = true;
                });
                this.$refs.fileUploader.resetDropFiles();
            }
        }
    }
</script>

<style scoped>
    .svgContainer {
        height: 50vh;
    }
</style>