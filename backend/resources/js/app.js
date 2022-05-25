require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
// Vuex Store
import store from './store';
// Global Mixins
import mixins from './mixins';
// Vue Sweet Alert 2
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

// Google Map
import VueGoogleMaps from '@fawmi/vue-google-maps'
const mapConfig = {
    load: {
        key: 'AIzaSyDPT51F0bPpkzrT8RNBRg87q1phEQhUOys',
        libraries: "places"
    },
}

// App Name
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

// Global Components
import components from '@/components.js';

// Init Inertial App
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(store)
            .use(plugin)
            .use(components)
            .use(VueSweetalert2)
            .use(VueGoogleMaps, mapConfig)
            .mixin(mixins)
            .mount(el);
    },
});

// Inertia Progress Bar
InertiaProgress.init({ color: '#4B5563' });
