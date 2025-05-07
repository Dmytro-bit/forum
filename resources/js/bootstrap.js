import axios from 'axios';

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

axios.defaults.baseURL = window.location.origin;
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
