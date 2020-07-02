<template>
    <section>
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

        <b-field v-if="showFileUpload">
            <b-upload name="files" @input.once="checkFirstFile()" @input="checkLinksCondition()"
                      v-model="dropFiles" multiple drag-drop expanded>
                <section class="section">
                    <div class="content has-text-centered">
                        <p>
                            <b-icon icon="upload" size="is-large"></b-icon>
                        </p>
                        <p>Drop your files here or click to upload, the first uploaded file <b>must</b> be a <q>.svg</q>
                            file</p>
                    </div>
                </section>
            </b-upload>
        </b-field>

        <div class="tags">
              <span
                      v-for="(file, index) in dropFiles"
                      :key="index"
                      :id="file.name"
                      class="tag is-info">
                {{ file.name }}
                <button
                        class="delete is-small"
                        type="button"
                        @click="deleteDropFile(index)"
                ></button>
              </span>
        </div>
        <svg-container class="svgContainer" ref="svgContainer" :file=file
                       v-on:updateLinkList="updateLinkList"></svg-container>
    </section>
</template>

<script>
    import SvgContainer from "@/components/SvgContainer";

    export default {
        components: {SvgContainer},
        data() {
            return {
                dropFiles: [],
                file: null,
                projectName: '',
                links: [],
                clicked: Number,
                uploaded: [],
                showFileUpload: true,
                isDisabled: true
            };
        },
        methods: {
            submit() {
                let formData = new FormData();
                for (let i = 0; i < this.dropFiles.length; i++) {
                    let file = this.dropFiles[i];
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
                if (this.getFileExtension(this.dropFiles[index].name) === 'svg') {
                    this.resetFileUploadForm();
                    this.isDisabled = true;
                } else {
                    this.dropFiles.splice(index, 1);
                    this.checkLinksCondition()
                }
            },
            checkFirstFile() {
                if (this.getFileExtension(this.dropFiles[0].name) === 'svg') {
                    const reader = new FileReader();
                    reader.readAsText(this.dropFiles[0]);
                    reader.onload = e => this.file = e.target.result;
                } else {
                    this.dropFiles = [];
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
                    for (let file of this.dropFiles) {
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
                    this.dropFiles = [];
                    this.file = null;
                    this.clicked = null;
                    this.links = [];
                    this.showFileUpload = true;
                })
            }
        },
    };
</script>
<style scoped>
    .svgContainer {
        height: 50vh;
    }
</style>
