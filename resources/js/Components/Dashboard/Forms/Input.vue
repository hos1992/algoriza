<script setup>
import FormError from "@/Components/Dashboard/Alerts/FormError.vue";

defineProps({
    name: String,
    type: String,
    label: String,
    placeHolder: String,
    className: String,
    id: String,
    modelValue: String,
    error: String,
    disabled: Boolean,
});

</script>
<template>


    <label class="uk-form-label">{{ label }}</label>
    <div class="uk-form-controls">
        <input class="uk-input sc-input-outline"
               :type="type"
               :id="id"
               :name="name"
               :placeholder="placeHolder ?? ''"
               :value="modelValue"
               :disabled="disabled"
               @input="$emit('update:modelValue', $event.target.value)"
        >

    </div>


    <FormError :error="error"/>

</template>
