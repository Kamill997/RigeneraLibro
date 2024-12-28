import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
 
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster:'pusher',
    key:import.meta.env.VITE_PUSHER_APP_KEY, 
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS:false,
    //debug:true,
    authorizer: (channel) => {
        return {
            authorize: (socketId, callback) => {
                axios.post('/broadcasting/auth', {
                    socket_id: socketId,
                    channel_name: channel.name
                })
                .then(response => {
                    callback(null, response.data);
                })
                .catch(error => {
                    callback(error);
                });
            }
        };
    }
});


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './chat';
