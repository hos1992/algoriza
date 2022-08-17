<script setup>
const props = defineProps({
  links: Object,
  meta: Object,
});
</script>
<template>
  <div class="uk-card uk-margin-top">
    <div class="uk-card-body">
      <ul class="uk-pagination uk-flex-center" data-uk-margin="">
        <template v-for="link in links" :key="link">
          <li class="" :class="link.active ? 'uk-active' : ''" v-if="link.url">
            <Link
              class=""
              :href="link.url"
              v-html="link.label"
              preserve-scroll
              replace
            />
          </li>
          <li v-else class="uk-disabled">
            <a
              class=""
              href="#"
              tabindex="-1"
              aria-disabled="true"
              v-html="link.label"
            >
            </a>
          </li>
        </template>
      </ul>
    </div>
  </div>
</template>
