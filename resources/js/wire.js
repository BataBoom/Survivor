import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import collapse from '@alpinejs/collapse';
import Clipboard from "@ryangjchandler/alpine-clipboard";
import Tooltip from "@ryangjchandler/alpine-tooltip";
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import anchor from '@alpinejs/anchor';
import mask from '@alpinejs/mask';
import intersect from '@alpinejs/intersect';
import '../css/app.css';

Alpine.plugin(intersect);
Alpine.plugin(mask);
Alpine.plugin(Tooltip);
Alpine.plugin(collapse);
Alpine.plugin(Clipboard);
Alpine.plugin(anchor);

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    wssPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});


Livewire.start()