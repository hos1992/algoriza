<script setup>
import {ref, watch} from "vue";
import FormError from "@/Components/Dashboard/Alerts/FormError.vue";
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

let selected = ref(props.modelValue);

const props = defineProps({
    name: String,
    type: String,
    label: String,
    placeHolder: String,
    className: String,
    id: String,
    modelValue: [String, Number, Array, Object],
    multiple: Boolean,
    disabled: Boolean,
    options: {
        type: Object,
        required: true,
    },
    error: String,
});

const emit = defineEmits(['update:modelValue']);
watch(selected, value => {
    emit('update:modelValue', value);
});

</script>


<template>
    <label class="uk-form-label">{{ label }}</label>
    <div style="background: #fff;">
        <v-select
            dir="rtl"
            v-model="selected"
            :options="options"
            :multiple="multiple"
            :reduce="option => option.value"
        ></v-select>
    </div>
    <FormError :error="error"/>
</template>
