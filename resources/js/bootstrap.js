import _ from 'lodash';
import dayjs from 'dayjs';
window._ = _;

import 'dayjs/locale/en';
import 'dayjs/locale/az';
import 'dayjs/locale/ru';
import relativeTime from 'dayjs/plugin/relativeTime';
dayjs.extend(relativeTime);

import axios from 'axios';
window.axios = axios;
window.dayjs = dayjs;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});