<template>
    <!--TODO: insert content-->
    <div></div>
</template>

<script>
import DefaultLayout from '@/layouts/DefaultLayout';
export default {
    name: 'Datenschutz',
    created() {
        this.$emit('update:layout', DefaultLayout);
        this.$eventBus.$emit('titleUpdated', 'Datenschutz');
    }
}
</script>


<style>

</style>