window._ = require('lodash');

window.axios = require('axios');

const token = localStorage.getItem("token");
if (token) {
    window.axios.defaults.headers.common["Authorization"] = "Bearer " + token;
}