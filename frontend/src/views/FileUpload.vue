<template>
    <FileUploader></FileUploader>
</template>

<script>
    import DefaultLayout from "@/layouts/DefaultLayout";
    import FileUploader from "@/components/FileUploader";

    export default {
        name: "FileUpload",
        components: {FileUploader},
        created() {
            this.$emit('update:layout', DefaultLayout)
            this.$eventBus.$emit('titleUpdated', 'New Project');
        },
    }
</script>

<style scoped>

</style>