<script setup>
import { computed, ref, watch } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import Input from "./Input.vue";
import Select from "./Select.vue";
import { debounce, throttle } from "lodash";
import { Inertia } from "@inertiajs/inertia";

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
  // resetOnSubmit: {
  //     type: Boolean,
  //     default: true,
  // },
  // closeModalOnSuccess: {
  //     type: Boolean,
  //     default: true,
  // },
  // showNotificationOnSuccess: {
  //     type: Boolean,
  //     default: true,
  // },
  // saveAndCloseChoice: {
  //     type: Boolean,
  //     default: true,
  // },
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

let formSubmit = () => {
  let data = form.data();
  Object.keys(data).forEach((key) => {
    if (data[key] === null || data[key] === "" || !data[key]) {
      delete data[key];
    }
  });
  let url = props.formAction;
  Inertia.get(url, data, {
    preserveState: true,
    preserveScroll: true,
    replace: true,
  });
};

watch(
  form,
  debounce(function (val) {
    formSubmit();
  }, 200),
  {
    deep: true,
  }
);
</script>

<template>
  <form @submit.prevent="formSubmit" class="form" :class="formClass">
    <div
      v-for="row in formRows"
      class="uk-grid-medium uk-child-width-expand@s"
      uk-grid
      :key="'filter_' + row[0]"
    >
      <template v-for="input in row" :key="input.name">
        <!-- Hidden INPUT -->

        <input
          v-if="input.type === 'hidden'"
          type="hidden"
          :name="input.name"
          :id="'filter_' + input.name"
          v-model="form[input.name]"
        />

        <!-- NORMAL INPUT -->
        <div v-if="inputTagAllowedTypes.includes(input.type)">
          <Input
            v-model="form[input.name]"
            :type="input.type"
            :label="input.label"
            :name="input.name"
            :id="'filter_' + input.name"
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
      </template>
    </div>
  </form>
</template>
