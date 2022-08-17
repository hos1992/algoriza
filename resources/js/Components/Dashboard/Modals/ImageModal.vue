<style>
.current-image {
  margin: 5px;
  border-radius: 10px;
  max-width: 50px;
  border: 2px solid rgba(178, 177, 177, 0.92);
}

.modal-image-wrapper {
  text-align: center;
}
</style>
<script setup>
defineProps({
  id: String,
  imageUrl: String,
  imageName: String,
});
</script>

<template>
  <a
    :href="imageUrl"
    type="button"
    :data-uk-toggle="'target: #' + id"
    aria-expanded="true"
  >
    <img class="current-image" :src="imageUrl" :alt="imageName" />
  </a>

  <teleport to="body">
    <div :id="id" data-uk-modal>
      <div class="uk-modal-dialog uk-modal-body modal-image-wrapper">
        <button
          class="uk-modal-close-outside"
          type="button"
          data-uk-close
        ></button>
        <img class="modal-image" :src="imageUrl" :alt="imageName" />
      </div>
    </div>
  </teleport>
</template>
