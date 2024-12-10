import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
if(window.location.href.split("/")[3] === 'company' && localStorage.getItem("company_token")) {
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem("company_token")}`
} else if(localStorage.getItem("token")) {
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem("token")}`;
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
