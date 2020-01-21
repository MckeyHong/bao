window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const axios = require('axios').default;
axios.defaults.headers.post['Content-Type'] = 'application/json';
