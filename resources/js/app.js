import './bootstrap';
import { createApp } from 'vue';

// Import komponentów
import CardsList from './components/CardsList.vue';
import CardForm from './components/CardForm.vue';

const app = createApp({});

// Rejestracja komponentów
app.component('cards-list', CardsList);
app.component('card-form', CardForm);

app.mount('#app');