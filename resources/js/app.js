import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { createPinia } from "pinia"; // ✅ Import Pinia

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob("./Pages/**/*.vue")),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        const pinia = createPinia(); // ✅ Create Pinia instance
        app.use(pinia); // ✅ Register Pinia globally

        return app.use(plugin).use(ZiggyVue).mount(el);
    },
    progress: {
        color: "#FE4D01",
    },
});


