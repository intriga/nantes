/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';
import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});
app.component('Bootstrap4Pagination', Bootstrap4Pagination);

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);


// modules posts
import ListPost from './posts/ListPost.vue';
import CreatePost from './posts/CreatePost.vue';
import ShowPost from './posts/ShowPost.vue';
import EditPost from './posts/EditPost.vue';

app.component('list-post', ListPost);
app.component('create-post', CreatePost);
app.component('show-post', ShowPost);
app.component('edit-post', EditPost);


// modules categories
import ListCategories from './categories/ListCategories.vue';
import CreateCategory from './categories/CreateCategory.vue';
import ShowCategory from './categories/ShowCategory.vue';
import EditCategory from './categories/EditCategory.vue';

app.component('list-categories', ListCategories);
app.component('create-category', CreateCategory);
app.component('show-category', ShowCategory);
app.component('edit-category', EditCategory);


// modules users
import ListUsers from './users/ListUsers.vue';
import CreateUser from './users/CreateUser.vue';


app.component('list-users', ListUsers);
app.component('create-user', CreateUser);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
