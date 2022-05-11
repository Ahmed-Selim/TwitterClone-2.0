/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import { createApp } from "vue";
import ExampleComponent from './components/ExampleComponent';
require('./bootstrap');


const app = createApp({});
app.component('example-component', ExampleComponent);
app.mount('#app');