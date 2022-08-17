<style>
.uk-badge {
    margin: 1px 2px !important;
    font-size: 14px !important;
    height: auto !important;
}
</style>

<script setup>
const props = defineProps({
    text: [String, Array],
    className: {
        type: String,
        default: 'md-bg-teal-600',
    }
});
</script>

<template>

    <span v-if="typeof text === 'string'" :class="'uk-badge ' + className ">
        {{ text }}
    </span>

    <template v-if="typeof text === 'object'">

        <span v-for="t in text" :class="'uk-badge ' + className ">
            {{ t }}
        </span>

    </template>


</template>
