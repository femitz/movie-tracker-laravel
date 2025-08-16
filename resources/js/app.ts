import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';

const theme = localStorage.getItem('appearance');

const optionsPrimeVueLight = {
    prefix: 'p',
    light: true,
    darkModeSelector: false,
    cssLayer: false
}

const optionsPrimeVueDark = {
    prefix: 'p',
    dark: true,
    darkModeSelector: true,
    cssLayer: false
}

const optionsPrimeVueSystem = {
    prefix: 'p',
    darkModeSelector: 'system',
    cssLayer: false
}

var optionsPrimeVue: any = "";
if (theme === 'dark') {
    optionsPrimeVue = optionsPrimeVueDark;
} else if (theme === 'light') {
    optionsPrimeVue = optionsPrimeVueLight;
} else {
    optionsPrimeVue = optionsPrimeVueSystem;
}

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                theme: {
                    preset: Aura,
                    options: optionsPrimeVue
                },
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
