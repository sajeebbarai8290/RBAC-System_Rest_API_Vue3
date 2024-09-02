import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import './bootstrap';
import { createApp } from 'vue';
import router from './router';
import App from './components/App.vue';



const app = createApp(App);
app.use(router);
app.mount('#app');
