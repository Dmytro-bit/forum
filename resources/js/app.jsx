import {createRoot} from 'react-dom/client';
import {createInertiaApp} from '@inertiajs/react';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '../css/app.css';

import Pusher from 'pusher-js'
import Echo    from 'laravel-echo'

// expose globally
window.Pusher = Pusher
window.Echo    = new Echo({
    broadcaster: 'pusher',
    key:         import.meta.env.VITE_PUSHER_APP_KEY,
    cluster:     import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS:    true,
})

createInertiaApp({
    resolve: name =>
        resolvePageComponent(
            `./Pages/${name}.jsx`,
            import.meta.glob('./Pages/**/*.jsx')
        ),
    setup({el, App, props}) {
        createRoot(el).render(<App {...props} />);
    },
});
