<script setup>
import {computed, ref} from "vue";
import {useForm, usePage} from "@inertiajs/inertia-vue3";
// import Swal from 'sweetalert2';
import Input from "./Input.vue";
import InputFile from "./InputFile.vue";
import SubmitButton from "./SubmitButton.vue";
import Select from "./Select.vue";
import Textarea from "./Textarea.vue";
// import the library
import {createToast, withProps} from 'mosha-vue-toastify';
// import the styling for the toast
import 'mosha-vue-toastify/dist/style.css'
import CheckBoxGroups from "@/Components/Dashboard/Forms/CheckBoxGroups.vue";
import SubmitButtonsWithCloseOption from "@/Components/Dashboard/Forms/SubmitButtonsWithCloseOption.vue";
import SelectLevels from "@/Components/Dashboard/Forms/SelectLevels.vue";


let closeModalOnSuccess = ref(true);

const props = defineProps({
    errors: Object,
    submitButtonText: String,
    formClass: String,
    formAction: String,
    formMethod: String,
    formRows: {
        type: Array,
        validator(value) {
            for (let row in value) {
                if (!Array.isArray(value[row])) {
                    console.error("The formRows prop values must be of type Array !");
                    return false;
                }

                for (let key in value[row]) {
                    let obj = value[row][key];
                    if (!obj.hasOwnProperty("label") || !obj.label) {
                        console.error(
                            'An input does not have the "label" prop OR the prop has no value !'
                        );
                        return false;
                    }
                    if (!obj.hasOwnProperty("name") || !obj.name) {
                        console.error(
                            'An input does not have the "name" prop OR the prop has no value !'
                        );
                        return false;
                    }
                    if (!obj.hasOwnProperty("type") || !obj.type) {
                        console.error(
                            'An input does not have the "type" prop OR the prop has no value !'
                        );
                        return false;
                    }
                    if (!obj.hasOwnProperty("value")) {
                        console.error('An input does not have the "value" prop !');
                        return false;
                    }
                }
            }

            return true;
        },
    },
    resetOnSubmit: {
        type: Boolean,
        default: true,
    },
    // closeModalOnSuccess: {
    //     type: Boolean,
    //     default: true,
    // },
    showNotificationOnSuccess: {
        type: Boolean,
        default: true,
    },
    saveAndCloseChoice: {
        type: Boolean,
        default: true,
    },

});

const inputTagAllowedTypes = computed(() => {
    return [
        "text",
        "number",
        "date",
        "time",
        "email",
        "color",
        "week",
        "month",
        "password",
        "datetime-local",

    ];
});

const inputFileAllowedTypes = computed(() => {
    return ["file", "image"];
});

const form = useForm(
    computed(() => {
        let data = {};
        if (Array.isArray(props.formRows)) {
            for (let row in props.formRows) {
                if (Array.isArray(props.formRows[row])) {
                    for (let key in props.formRows[row]) {
                        if (
                            inputFileAllowedTypes.value.includes(
                                props.formRows[row][key].type
                            )
                        ) {
                            data[props.formRows[row][key].name] = null;
                        } else {
                            data[props.formRows[row][key].name] =
                                props.formRows[row][key].value;
                        }
                    }
                }
            }
        }
        return data;
    }).value
);

const formSubmit = () => {
    form.clearErrors();
    form.submit(props.formMethod, props.formAction, {
        // forceFormData: true,
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {

            if (props.resetOnSubmit) {
                form.reset();
            }

            if (closeModalOnSuccess.value) {
                let modal = document.getElementsByClassName('uk-open');
                UIkit.modal(modal).hide();
            }

            if (props.showNotificationOnSuccess) {
                createToast(' تم تحديث البيانات بنجاح ', {
                    position: 'top-left',
                    type: 'success',
                    // hideProgressBar: 'true',
                    transition: 'bounce',
                    // toastBackgroundColor: '#2e7d32',
                    showIcon: true,

                });
            }

        },
        onError: () => {
            createToast(' خطأ فى معالجة البيانات ! ', {
                position: 'top-left',
                type: 'danger',
                // hideProgressBar: 'true',
                transition: 'bounce',
                // toastBackgroundColor: '#2e7d32',
                showIcon: true,

            });
        },
    });

};
</script>

<template>
    <form @submit.prevent="formSubmit" class="form" :class="formClass" enctype="multipart/form-data">
        <div
            v-for="row in formRows"
            class="uk-grid-medium uk-child-width-expand@s"
            uk-grid
            :key="row[0]"
        >
            <template v-for="input in row" :key="input.name">
                <!-- Hidden INPUT -->

                <input
                    v-if="input.type === 'hidden'"
                    type="hidden"
                    :name="input.name"
                    :id="input.name"
                    v-model="form[input.name]"
                />

                <!-- NORMAL INPUT -->
                <div v-if="inputTagAllowedTypes.includes(input.type)">
                    <Input
                        v-model="form[input.name]"
                        :type="input.type"
                        :label="input.label"
                        :name="input.name"
                        :placeholder="input.placeholder"
                        :id="input.name"
                        :disabled="input.disabled"
                        :error="form.errors[input.name]"
                    />
                </div>

                <!-- file INPUT -->
                <div v-if="inputFileAllowedTypes.includes(input.type)">
                    <InputFile
                        v-model="form[input.name]"
                        :type="input.type"
                        :label="input.label"
                        :name="input.name"
                        :id="input.name"
                        :value="input.value"
                        :disabled="input.disabled"
                        :error="form.errors[input.name]"
                    />
                </div>

                <div v-if="input.type === 'select'">
                    <Select
                        v-model="form[input.name]"
                        :type="input.type"
                        :label="input.label"
                        :name="input.name"
                        :id="input.name"
                        :options="input.options"
                        :multiple="input.multiple"
                        :disabled="input.disabled"
                        :error="form.errors[input.name]"
                    />
                </div>

                <div v-if="input.type === 'textarea'">
                  <Textarea
                      v-model="form[input.name]"
                      :label="input.label"
                      :name="input.name"
                      :id="input.name"
                      :disabled="input.disabled"
                      :error="form.errors[input.name]"
                  />
                </div>


                <div v-if="input.type === 'checkbox_groups'">
                    <CheckBoxGroups
                        v-model="form[input.name]"
                        :label="input.label"
                        :name="input.name"
                        :id="input.name"
                        :options="input.options"
                        :disabled="input.disabled"
                        :error="form.errors[input.name]"
                    />
                </div>

                <div v-if="input.type === 'select_levels'">

                    <SelectLevels
                        v-model="form[input.name]"
                        :type="input.type"
                        :label="input.label"
                        :name="input.name"
                        :id="input.name"
                        :levels="input.levels"
                        :on-change-url="input.onChangeUrl"
                        :edit-model-id="input.editModelId"
                        :multiple="input.multiple"
                        :disabled="input.disabled"
                        :error="form.errors[input.name]"
                    />

                </div>


            </template>
        </div>


        <template v-if="saveAndCloseChoice">
            <SubmitButtonsWithCloseOption
                @clickAndClose="closeModalOnSuccess = true"
                @clickAndDonotClose="closeModalOnSuccess = false"
                :processing="form.processing"
                :submitButtonText="submitButtonText"
            />
        </template>

        <SubmitButton
            v-else
            :processing="form.processing"
            :submitButtonText="submitButtonText"
        />


    </form>
</template>
