import './bootstrap.js';
import '../css/app.css';

import { createApp, h } from 'vue';
import type { DefineComponent } from "vue";
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m.js';
import { i18nVue } from 'laravel-vue-i18n';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Notifications from 'notiwind';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(
        `./Pages/${name}.vue`,
        import.meta.glob<DefineComponent>('./Pages/**/*.vue')
    ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, (window as any).Ziggy)
            .use(i18nVue, {
                resolve: async (lang) => {
                    const langs = import.meta.glob<DefineComponent>('../../lang/*.json');
                    return await langs[`../../lang/${lang}.json`]();
                }
            })
            .use(VueSweetalert2, {
                confirmButtonColor: '#41b882',
                cancelButtonColor: '#ff7674',
            })
            .use(Notifications)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
