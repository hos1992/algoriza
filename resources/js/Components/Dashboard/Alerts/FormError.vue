<template>
    <span v-if="error" v-text="error" class="parsley-required">

    </span>
</template>

<script setup>
defineProps({error: String});
</script>
<style>
.parsley-required {
    color: red;
}
</style>
