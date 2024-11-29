// import './bootstrap';
import "vue-select/dist/vue-select.css";
import "vue3-toastify/dist/index.css";
import VueApexCharts from "vue3-apexcharts";

import {
    createApp,
    h
} from 'vue'
import {
    createInertiaApp,
} from '@inertiajs/vue3'

createInertiaApp({
    resolve: name => {
        const pages =
            import.meta.glob('./Pages/**/*.vue', {
                eager: true
            })
        return pages[`./Pages/${name}.vue`]
    },
    setup({
        el,
        App,
        props,
        plugin
    }) {
        createApp({
                render: () => h(App, props),
            })
            .use(plugin)
            .use(VueApexCharts)
            .mount(el)
    },
})
