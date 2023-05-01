import './bootstrap';
import '../css/app.css';
// import 'vue-multiselect/dist/vue-multiselect.min.css';
import Multiselect from '@suadelabs/vue3-multiselect';

import BaseInput from './Pages/Form/BaseInput.vue';
import BaseTextarea from './Pages/Form/BaseTextarea.vue';

import VSimpleTable from './Pages/Common/v-table/VSimpleTable.vue';
import VTableHead from './Pages/Common/v-table/VTableHead.vue';
import VPaginate from './Pages/Common/v-table/VPaginate.vue';
import NotFound from './Pages/Common/NotFound.vue';
import OverlayPreloader from './Pages/Common/OverlayPreloader.vue';
import ListPreloader from './Pages/Common/ListPreloader.vue';



import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

import commonMixin from './mixin/common';
import formActionMixin from './mixin/form-action';
import store from './store';


// const appName = window.document.getElementsByTagName('title')[0] ? .innerText || 'Laravel';
const appName = 'ISP';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`,
        import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(store)
            .mixin(commonMixin)
            .mixin(formActionMixin)
            .component('v-simple-table', VSimpleTable)
            .component('v-table-head', VTableHead)
            .component('v-paginate', VPaginate)
            .component('not-found', NotFound)
            .component('overlay-preloader', OverlayPreloader)
            .component('list-preloader', ListPreloader)
            .component('BaseInput', BaseInput)
            .component('BaseTextarea', BaseTextarea)
            .component('multi-select', Multiselect)
            .component('Link', Link)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});