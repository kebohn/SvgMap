<template>
 <div>
     About Page
 </div>
</template>

<script>
import DefaultLayout from "@/layouts/DefaultLayout";

export default {
    name: 'About',
    created() {
        this.$emit('update:layout', DefaultLayout)
    }

}
</script>

<style>

</style>