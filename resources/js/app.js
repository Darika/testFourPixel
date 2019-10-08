/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.VueScrollTo = require('vue-scrollto');

var options = {
    container: '#container',
    easing: 'ease-in',
    offset: -60,
    force: true,
    cancelable: true,
    onStart: function(element) {
        // scrolling started
    },
    onDone: function(element) {
        // scrolling is done
    },
    onCancel: function() {
        // scrolling has been interrupted
    },
    x: false,
    y: true
}


import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

import UsersIndex from './components/users/UsersIndex.vue';
import UserCreate from './components/users/UserCreate.vue';
import UserEdit from './components/users/UserEdit.vue';
import DepartmentsIndex from './components/departments/DepartmentsIndex.vue';
import DepartmentsCreate from './components/departments/DepartmentCreate.vue';
import DepartmentsEdit from './components/departments/DepartmentEdit.vue';

const routes = [
    {
        path: '/',
        components: {
            usersIndex: UsersIndex,
            departmentsIndex: DepartmentsIndex
        }
    },
    {path: '/admin/users/create', component: UserCreate, name: 'createUser'},
    {path: '/admin/users/edit/:id', component: UserEdit, name: 'editUser'},
    {path: '/admin/departments/edit/:id', component: DepartmentsEdit, name: 'editDepartment'},
    {path: '/admin/departments/create', component: DepartmentsCreate, name: 'createDepartment'},
];

const router = new VueRouter({ routes });

const app = new Vue({ router }).$mount('#app');
