<template>
    <div class="container p-l-lg p-r-lg">
        <b-table
                :data="files"
                :columns="columns"
                :selected.sync="selected"
                hoverable
                paginated pagination-position="top"
                per-page="15"
                @click="checkLinksCondition(); setNewActiveNode($event)">
        </b-table>
        <file-uploader ref="fileUploader" class="m-t-xl"
                       v-on:checkLinksCondition="checkLinksCondition"
                       v-on:deleteDropFile="deleteDropFile"
                       v-bind:text="'Drop your file here'"
                       v-bind:multiple=false>
        </file-uploader>
        <div class="field is-grouped m-t-md is-pulled-right">
            <div class="control">
                <button :disabled=isDisabled
                        @click="exchangeFile" class="button is-link">Exchange File
                </button>
            </div>
        </div>
        <div class="is-clearfix"></div>
    </div>
</template>

<script>
    import FileUploader from "@/components/FileUploader";

    export default {
        components: {FileUploader},
        props: {
            files: {
            },
            links: {
            }
        },
        data() {
            return {
                selected: null,
                isDisabled: true,
                columns: [
                    {
                        field: 'name',
                        label: 'FileName',
                    }
                ]
            }
        },
        methods: {
            exchangeFile() {
                if (this.selected.name === this.$refs.fileUploader.dropFiles.name) {
                    this.$buefy.dialog.confirm({
                        title: 'Exchange File',
                        message: `Are you sure you want to <b>exchange the File ${this.selected.name}</b>?<br>
                                  This action cannot be undone.`,
                        confirmText: 'Exchange File',
                        type: 'is-danger',
                        hasIcon: true,
                        onConfirm: () => {
                            this.updateFile(this.$refs.fileUploader.dropFiles);
                        }
                    })
                } else {
                    this.$buefy.toast.open({
                        message: `Filenames do not match, please try again`,
                        type: 'is-warning'
                    });
                }
            },
            updateFile(newFile) {
                let formData = new FormData();
                    formData.append('files[0]', newFile);
                this.$http.post(`/api/files/${this.selected.id}`, formData)
                .then(() => {
                    this.$buefy.toast.open({
                        message: `File '${this.selected.name}' changed successfully`,
                        type: 'is-success'
                    });
                }).catch(error => {
                    this.$buefy.toast.open({
                        message: `An error occurred, please try again!\n ${error}`,
                        type: 'is-danger'
                    });
                });
            },
            checkLinksCondition() {
                this.$nextTick(() => {
                    this.isDisabled = this.selected === null || this.$refs.fileUploader.dropFiles.name === undefined;
                })
            },
            deleteDropFile() {
                this.isDisabled = true;
                this.$refs.fileUploader.resetDropFiles()
            },
            setNewActiveNode(file) {
                this.links.forEach(link => {
                    if (this.getBaseName(link.getAttribute('xlink:href')) === file.name) {
                        this.$eventBus.$emit("changeActiveNode", link)
                    }
                })
            },
            getBaseName(str) {
                return str.substr(str.lastIndexOf("\\") + 1);
            }
        }
    }
</script>
<style scoped>
</style>