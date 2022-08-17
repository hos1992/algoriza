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
  <label v-if="label" :for="id ?? name" class="uk-margin-small-right">{{
    label
  }}</label>

  <div class="uk-form-controls">
    <input
      type="checkbox"
      data-sc-switchery
      data-switchery-size="large"
      :type="type"
      :id="id ?? name"
      :name="name"
      :placeholder="placeHolder ?? ''"
      :value="modelValue"
      :disabled="disabled"
      @input="$emit('update:modelValue', $event.target.value)"
    />
  </div>

  <FormError v-if="error" :error="error" />
</template>
