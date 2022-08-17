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
    levels: {
        type: Array,
        required: true,
    },
    onChangeUrl: String,
    error: String,
});

let levelsRef = ref(props.levels);

const emit = defineEmits(['update:modelValue']);
watch(selected, value => {
    emit('update:modelValue', value);
});


let triggerChange = (e) => {
    selected.value = e.target.value;
    axios.get(props.onChangeUrl + '&id=' + e.target.value + '&editCategoryId=' + props.modelValue, {}).then(response => {
        console.log(response.data);
        levelsRef.value = response.data;
    });

};
</script>


<template>
    <label class="uk-form-label">{{ label }}</label>

    <div>
        <select
            v-for="level in levelsRef"
            @input="triggerChange($event)"
            class="uk-select uk-margin-small-bottom">

            <option selected disabled>Choose</option>

            <template v-for="option in level.options">

                <option :selected="level.selected === option.value" :value="option.value">
                    {{ option.label }}
                </option>

            </template>

        </select>

    </div>
    <FormError :error="error"/>
</template>
