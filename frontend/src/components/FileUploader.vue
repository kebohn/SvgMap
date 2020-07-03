<template>
    <div>
        <b-field>
            <b-upload name="files" @input.once="checkFirstFile()" @input="checkLinksCondition()"
                      v-model="dropFiles" type="is-link" :multiple="multiple" drag-drop expanded>
                <section class="section">
                    <div class="content has-text-centered">
                        <p>
                            <b-icon icon="upload" size="is-large"></b-icon>
                        </p>
                        <p>{{text}}</p>
                    </div>
                </section>
            </b-upload>
        </b-field>
        <div class="tags">
            <template v-if="multiple">
                <span v-for="(file, index) in dropFiles"
                      :key="index"
                      :id="file.name"
                      class="tag is-link">
                        {{ file.name }}
                        <button
                                class="delete is-small"
                                type="button"
                                @click="deleteDropFile(index)"
                        ></button>
                </span>
            </template>
            <template v-else>
            <span v-if="typeof dropFiles.name === 'string'" class="tag is-link">
                    {{ dropFiles.name }}
                     <button
                             class="delete is-small"
                             type="button"
                             @click="deleteDropFile($event)"
                     ></button>
                </span>
            </template>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            text: {
                type: String
            },
            multiple: {
                type: Boolean
            }
        },
        data() {
            return {
                dropFiles: [],
            };
        },
        methods: {
            checkFirstFile() {
                this.$emit('checkFirstFile', this.dropFiles);
            },
            checkLinksCondition() {
                this.$emit('checkLinksCondition');
            },
            deleteDropFile(index) {
                this.$emit('deleteDropFile', index);
            },
            resetDropFiles() {
                this.dropFiles = [];
            },
            removeItemFromDropFiles(index) {
                this.dropFiles.splice(index, 1);
            }
        },
    };
</script>
<style scoped>
</style>
