<script setup>
defineProps({
    formTitle: String,
});
</script>

<template>
    <div class="uk-card uk-margin-top">
        <div class="uk-card-body">
            <h5 v-if="formTitle" class="uk-heading-line"><span> {{ formTitle }} </span></h5>
            <div class="uk-fieldset md-bg-grey-100 sc-padding">
                <slot/>
            </div>
        </div>
    </div>
</template>
