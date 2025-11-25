// Basic front-end bootstrap for app.js
import axios from 'axios';

// Initialize axios
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
