import './bootstrap';
// import '../css/app.css';
import {createApp, h} from 'vue';
import {createInertiaApp, Head, Link} from '@inertiajs/inertia-vue3';
import {InertiaProgress} from '@inertiajs/progress';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';
import AdminLayout from '@/Layouts/Dashboard/Admin/AdminLayout.vue';
import {createI18n} from "vue-i18n";
import {Messages} from "./messages";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        // const page = require(`./Pages/${name}`).default;
        const page = resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'));
        page.then((module) => {
            module.default.layout = module.default.layout || AdminLayout;
        });
        return page;
    },
    setup({el, app, props, plugin}) {


        // Create VueI18n instance with options
        const i18n = createI18n({
            legacy: false,
            locale: 'ar', // set locale
            fallbackLocale: 'en', // set locale
            messages: Messages, // set locale messages
            globalInjection: true,
        });


        return createApp({render: () => h(app, props)})
            .use(plugin)
            .use(i18n)
            .use(ZiggyVue, Ziggy)
            .component("Link", Link)
            .component("Head", Head)
            .mount(el);
    },
});

InertiaProgress.init({color: '#4B5563'});
