<template>
    <project-list></project-list>
</template>

<script>
import DefaultLayout from '@/layouts/DefaultLayout';
import ProjectList from "@/components/ProjectList";
export default {
    name: 'Projects',
    components: {ProjectList},
    created() {
        this.$emit('update:layout', DefaultLayout)
        this.$eventBus.$emit('titleUpdated', 'Projects');
    }

}
</script>


<style>

</style>