<template>
    <div class="container p-l-lg p-r-lg">
        <b-table
                :data="files"
                :columns="columns"
                :selected.sync="selected"
                hoverable
                paginated pagination-position="top"
                per-page="15"
                @click="checkLinksCondition">
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
                    this.$buefy.toast.open(`Filenames do not match, please try again\n`);
                }
            },
            updateFile(newFile) {
                console.log(newFile);
            },
            checkLinksCondition() {
                this.$nextTick(() => {
                    this.isDisabled = this.selected === null || this.$refs.fileUploader.dropFiles.name === undefined;
                })
            },
            deleteDropFile(index) {
                this.isDisabled = true;
                this.$refs.fileUploader.resetDropFiles()
            },
        }
    }
</script>
<style scoped>
</style>