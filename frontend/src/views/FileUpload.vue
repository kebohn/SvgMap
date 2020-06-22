<template>
    <div>
        <section class="hero">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title">
                        New Project
                    </h1>
                </div>
            </div>
        </section>
        <FileUploader></FileUploader>
    </div>
</template>

<script>
    import DefaultLayout from "@/layouts/DefaultLayout";
    import FileUploader from "@/components/FileUploader";

    export default {
        name: "FileUpload",
        components: {FileUploader},
        created() {
            this.$emit('update:layout', DefaultLayout)
        }
    }
</script>

<style scoped>

</style>