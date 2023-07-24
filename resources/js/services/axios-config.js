import axios from 'axios';

axios.defaults.headers.common = {
    "Content-Type": "application/json;charset=utf-8",
};

axios.defaults.baseUrl = "http://project-php:8081/server/";