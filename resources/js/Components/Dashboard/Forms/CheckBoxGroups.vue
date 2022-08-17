<style>
.cursor-pointer {
    cursor: pointer;
}
</style>

<script setup>


import {ref, watch} from "vue";
import FormError from "@/Components/Dashboard/Alerts/FormError.vue";
import Checkbox from "@/Components/Dashboard/Forms/Checkbox.vue";

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


let clickInput = (input) => {
    setTimeout(function () {
        document.getElementById(input.id).click();
    }, 20);
};

let checkAll = (e) => {
    let target = e.target;

    let inputs;
    if (target.tagName === 'A' || target.tagName === 'a') {
        inputs = target.parentNode.parentNode.parentNode.getElementsByTagName('input');
    } else {
        inputs = target.parentNode.parentNode.parentNode.parentNode.getElementsByTagName('input');
    }

    for (let item of inputs) {
        if (!Array.from(selected.value).includes(parseInt(item.value))) {
            clickInput(item);
        }
    }

};

let unCheckAll = (e) => {
    let target = e.target;

    let inputs;
    if (target.tagName === 'A' || target.tagName === 'a') {
        inputs = target.parentNode.parentNode.parentNode.getElementsByTagName('input');
    } else {
        inputs = target.parentNode.parentNode.parentNode.parentNode.getElementsByTagName('input');
    }

    for (let item of inputs) {
        if (Array.from(selected.value).includes(parseInt(item.value))) {
            clickInput(item);
        }
    }

};

</script>


<template>
    <label class="uk-form-label">{{ label }}</label>
    <div class="uk-padding-small uk-grid-medium  uk-child-width-1-3@m uk-grid-match" uk-grid>

        <div v-for="(moduleOptions, module) in options" :key="module">

            <div :id="module">


                <strong>
                    {{ $t(module) }}
                </strong>


                <div class="uk-grid-medium uk-width-auto uk-flex-middle uk-grid uk-padding-small">
                    <a href="#" class="sc-button  md-bg-green-400"
                       @click="checkAll"
                    >
                        <i class="mdi mdi-check-circle md-color-white"></i>
                    </a>
                    &nbsp;
                    <a href="#" class="sc-button  md-bg-red-400"
                       @click="unCheckAll"
                    >
                        <i class="mdi mdi-bookmark-remove md-color-white"></i>
                    </a>
                </div>


            </div>

            <div v-for="option in moduleOptions">

                <div class="uk-form-controls">
                    <input type="checkbox"
                           data-sc-switchery
                           data-switchery-size="large"
                           :id="option.name"
                           :name="option.name"
                           :value="option.id"
                           v-model="selected"
                    />
                    <label v-if="label" :for="option.name" class="uk-margin-small-right">{{
                            $t(option.name)
                        }}</label>

                </div>

            </div>
        </div>


    </div>
    <FormError :error="error"/>


</template>
