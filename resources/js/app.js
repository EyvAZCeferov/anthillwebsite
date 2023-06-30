import './bootstrap';
import { createApp } from 'vue';
import MessageIndex from './components/MessageIndex.vue';
// import { connectecho } from './getmessagecount';
const app = createApp(MessageIndex);

app.mount('#app');

// connectecho();
