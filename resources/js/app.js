import './bootstrap';
import { createApp } from 'vue';
import router from './router'
import App from './App.vue';
import store from './store'

const app = createApp({});

app.component('app-component', App);

app.use(router).use(store).mount('#app');
