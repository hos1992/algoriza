<script setup>
import TopNav from "@/Layouts/Dashboard/TopNav.vue";
import SideMenu from "@/Layouts/Dashboard/SideMenu.vue";
import {usePage} from '@inertiajs/inertia-vue3';
import {computed} from "vue";

let urlStr = (route) => {
    return route.replace(/^.*\/\/[^\/]+/, "");
};

const permissions = computed(() => usePage().props.value.menuPermissions.admin)

</script>

<template>
    <TopNav
        home-url="/ad"
        :has-search="false"
        :search-url="''"
        :has-notifications="true"
        :notifications="{}"
        :profile-urls="{
      myProfile: '#',
      settings: '#',
      logout: '/ad/logout',
    }"
    />

    <!--  type = single - dropdown - sectionTitle  -->
    <SideMenu
        :menu="[
      // {
      //     'type' : 'sectionTitle',
      //     'text' : 'روابط',
      // },
      {
        type: 'single',
        icon: 'mdi-home',
        text: $t('homePage'),
        url: urlStr(route('admin.home')),
        can: true,

      },
      {
        type: 'single',
        icon: 'mdi-folder-multiple',
        text: $t('categories'),
        url: urlStr(route('categories.index')),
        can: permissions.canIndexCategories,
      },
      {
        type: 'single',
        icon: 'mdi-cart',
        text: $t('products'),
        url: urlStr(route('products.index')),
        can: permissions.canIndexProducts,
      },
      {
        type: 'single',
        icon: 'mdi-account-supervisor-circle',
        text: $t('administration'),
        url: urlStr(route('admins.index')),
        can: permissions.canIndexAdmins,
      },
      {
        type: 'single',
        icon: 'mdi-shield-lock',
        text: $t('rolesAndPermissions'),
        url: urlStr(route('roles.index')),
        can: permissions.canIndexRoles,

      },

    ]"
    />

    <div id="sc-page-wrapper">
        <slot/>
    </div>
</template>
