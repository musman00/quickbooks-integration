import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const initializeInertiaApp = () => {
    createInertiaApp({
        title: (title) => [title, appName].join(' - '),
        resolve: (name) => {
            const pageImporter = import.meta.glob('./Pages/**/*.jsx');
            return resolvePageComponent(`./Pages/${name}.jsx`, pageImporter);
        },
        setup({ el, App, props }) {
            const root = createRoot(el);
            root.render(<App {...props} />);
        },
        progress: {
            color: '#4B5563',
        },
    });
};

//Initialize app
initializeInertiaApp();