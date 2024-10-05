import { createApp } from 'vue';
import App from './App.vue';
import './assets/styles/tailwind.css';
import './assets/styles/base.scss';
import { CkeditorPlugin } from '@ckeditor/ckeditor5-vue';

createApp(App).use(CkeditorPlugin).mount('#app');
