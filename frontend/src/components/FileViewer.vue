<template>
    <div class="container p-l-lg p-r-lg">
        <b-table
                :data="files"
                :columns="columns"
                :selected.sync="selected"
                hoverable
                paginated pagination-position="top"
                per-page="20">
        </b-table>
        <b-button type="is-link" :disabled="!selected" icon-left="edit" @click="changeFile" style="float: right">
            Exchange File
        </b-button>
    </div>
</template>

<script>
    export default {
        props: {
            files: {
            }
        },
        data() {
            return {
                selected: null,
                columns: [
                    {
                        field: 'name',
                        label: 'FileName',
                    }
                ]
            }
        },
        methods: {
            changeFile() {
                console.log(this.selected)
            }
        }
    }
</script>
<style scoped>
</style>