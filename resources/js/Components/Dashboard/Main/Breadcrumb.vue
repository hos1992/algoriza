<script setup>
const props = defineProps({
  heading: String,
  headingUrl: String,
  tree: Array,
});
</script>


<template>
  <div id="sc-page-top-bar" class="sc-top-bar">
    <div class="sc-top-bar-content uk-flex uk-flex-middle uk-width-1-1">
      <ul class="uk-breadcrumb uk-margin-remove uk-flex uk-flex-middle">
        <li v-if="headingUrl">
          <Link :href="headingUrl">
            {{ heading }}
          </Link>
        </li>
        <li v-else class="uk-active">
          <span>
            {{ heading }}
          </span>
        </li>
        <template v-if="tree">
          <template v-for="(item, key) in tree" :key="key">
            <li v-if="item.type === 'url'">
              <Link :href="item.url ?? '#'">
                {{ item.text }}
              </Link>
            </li>

            <li v-if="item.type === 'text'" class="uk-active">
              <span>
                {{ item.text }}
              </span>
            </li>
          </template>
        </template>
      </ul>
    </div>
  </div>
</template>
