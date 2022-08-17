<script setup>
defineProps({
    menu: Object,
});


</script>
<template>
    <aside id="sc-sidebar-main" class="sc-sidebar-info-fixed">
        <div class="uk-offcanvas-bar">
            <div class="sc-sidebar-main-scrollable" data-sc-scrollbar="visible-y">
                <ul class="sc-sidebar-menu uk-nav">


                    <template v-if="menu.length" v-for="item in menu">

                        <template v-if="item.can">
                            <li v-if="item.type === 'sectionTitle'" class="sc-sidebar-menu-heading">
                                <span>{{ item.text }}</span>
                            </li>

                            <li v-if="item.type === 'single'" :title="item.text"
                                :class="{ 'sc-page-active': $page.url.startsWith(item.url) }">
                                <Link :href="item.url">


	                    	   <span class="uk-nav-icon">
                                <i :class="'mdi ' +  item.icon"></i>
	                           </span>

                                    <span class="uk-nav-title">
                                    {{ item.text }}
                                </span>

                                </Link>
                            </li>

                            <li v-if="item.type === 'dropdown'" :title="item.text">
                                <a href="#">
	                    	    <span class="uk-nav-icon">
                                    <i :class="'mdi ' + item.icon"></i>
	                            </span>
                                    <span class="uk-nav-title">{{ item.text }}</span>
                                </a>

                                <ul class="sc-sidebar-menu-sub">

                                    <li v-for="link in item.links"
                                        :class="{ 'sc-page-active': $page.url.startsWith(link) }">

                                        <Link :href="link.url">
                                            {{ link.text }}
                                        </Link>


                                    </li>

                                </ul>
                            </li>

                        </template>


                    </template>


                </ul>

            </div>
            <div class="sc-sidebar-info">
                version: 0.1.0
            </div>
        </div>
    </aside>
</template>
