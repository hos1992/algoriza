<script setup>
import FormError from "@/Components/Dashboard/Alerts/FormError.vue";
import { ref, onMounted, computed } from "vue";
import ImageModal from "@/Components/Dashboard/Modals/ImageModal.vue";

const thumbnail = ref();
const inputAccept = ref("*");
const downloadLink = ref(null);
const selectedFile = ref(null);
const selectedFileSize = ref(null);
const selectedFileName = ref(null);

onMounted(() => {
  if (props.type === "image") {
    props.value ? (thumbnail.value = props.value) : null;
    inputAccept.value = "image/*";

    if (props.modelValue) {
      const validImageTypes = ["image/gif", "image/jpeg", "image/png"];
      let file = props.modelValue;
      selectedFile.value = file;
      selectedFileSize.value = clacFileSize(file["size"]);
      selectedFileName.value = file["name"];
      if (validImageTypes.includes(file["type"])) {
        thumbnail.value = URL.createObjectURL(file);
      }
    }
  }

  if (props.type === "file") {
    props.value ? (downloadLink.value = props.value) : null;
  }
});

let props = defineProps({
  name: String,
  type: String,
  label: String,
  placeHolder: String,
  className: String,
  id: String,
  error: String,
  value: String,
  modelValue: [Object, String],
  disabled: Boolean,
});

const showSelected = (e) => {
  const validImageTypes = ["image/gif", "image/jpeg", "image/png"];
  const file = e.target.files[0];
  if (!file) {
    thumbnail.value = null;
    return;
  }
  selectedFile.value = file;
  selectedFileSize.value = clacFileSize(file["size"]);
  selectedFileName.value = file["name"];
  if (validImageTypes.includes(file["type"])) {
    thumbnail.value = URL.createObjectURL(file);
  }
};

const clacFileSize = (bytes) => {
  const sizes = ["Bytes", "KB", "MB", "GB", "TB"];
  if (bytes === 0) return "n/a";
  const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)), 10);
  if (i === 0) return `${bytes} ${sizes[i]}`;
  return `${(bytes / 1024 ** i).toFixed(1)} ${sizes[i]}`;
};
</script>
<template>
  <label class="uk-form-label"
    >{{ label }}
    <span v-if="type === 'image'">
      <a v-if="thumbnail" :href="thumbnail" target="_blank">
        <img
          :src="thumbnail"
          :alt="name + ' image'"
          width="70"
          class="current-image"
        />
      </a>

      <!-- <ImageModal
        v-if="thumbnail"
        :id="name + '_' + id"
        :image-url="thumbnail"
        :image-name="name"
      /> -->
    </span>
    <span v-if="type === 'file'">
      <!-- add download link for the file -->
    </span>
  </label>
  <div class="uk-form-controls">
    <input
      class="uk-input sc-input-outline"
      type="file"
      :id="id"
      :name="name"
      :accept="inputAccept"
      :placeholder="placeHolder ?? ''"
      :disabled="disabled"
      @change="showSelected"
      @input="$emit('update:modelValue', $event.target.value)"
    />
  </div>

  <FormError :error="error" />
</template>
