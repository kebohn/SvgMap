<template>
</template>

<script>
import DefaultLayout from '@/layouts/DefaultLayout';
export default {
    name: 'Impressum',
    created() {
        this.$emit('update:layout', DefaultLayout);
        this.$eventBus.$emit('titleUpdated', 'Impressum');
    }
}
</script>
<style>

</style>