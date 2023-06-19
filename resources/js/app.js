import './bootstrap';
import { createApp } from 'vue';
import MessageIndex from './components/MessageIndex.vue';

const app = createApp(MessageIndex);

app.mount('#app');