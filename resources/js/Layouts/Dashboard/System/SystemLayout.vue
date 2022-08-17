<script setup>
import TopNav from "@/Layouts/Dashboard/TopNav.vue";
import SideMenu from "@/Layouts/Dashboard/SideMenu.vue";
</script>

<template>

    <TopNav
        home-url="/ad"
        :has-search="false"
        :search-url="''"
        :has-notifications="true"
        :notifications="{}"
        :profile-urls="{
            myProfile : '/system/my-profile',
            settings: '/system/settings',
            logout : '/system/logout'
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
                'type' : 'single',
                'icon' : 'mdi-home',
                'text' : 'الرئيسية',
                'url' : '/system'
            },
            {
                'type' : 'dropdown',
                'icon' : 'mdi-account',
                'text' : 'الفواتير',
                'links' : [
                    {
                        'text' : 'الجميع',
                        'url' : '/admin/users'
                    },
                    {
                        'text' : 'غير مفعلين',
                        'url' : '/admin/users?active=0',
                    },
                ],
            },
        ]"
    />


    <div id="sc-page-wrapper">
        <slot/>
    </div>


</template>
