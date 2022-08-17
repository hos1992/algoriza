<script setup>
import FormError from "@/Components/Dashboard/Alerts/FormError.vue";

const props = defineProps({
    name: String,
    type: String,
    label: String,
    placeHolder: String,
    className: String,
    id: String,
    modelValue: String,
    error: String,
    hasEditor: Boolean,
    disabled: Boolean,

});
</script>
<template>


    <label class="uk-form-label">{{ label }}</label>
    <div class="uk-form-controls">

        <textarea class="uk-textarea sc-textarea-outline"
                  rows="5"
                  data-sc-input="outline"
                  :id="id"
                  :name="name"
                  :placeholder="placeHolder ?? ''"
                  :disabled="disabled"
                  :value="modelValue"
                  @input="$emit('update:modelValue', $event.target.value)"
        ></textarea>

    </div>


    <FormError :error="error"/>
</template>
