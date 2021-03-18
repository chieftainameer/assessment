import Vue from "vue";
import VueRouter from "vue-router";

import AppComponent from "./../components/users/Home";
import SignUp from "./../components/users/SignUp";
import Users from "./../components/admins/Users";
import Admin from './../components/admins/Main';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: AppComponent,
    },
    {
        path:'/admin',
        component: Admin,
    },
    {
        path:'/signup/:email',
        component: SignUp
    },
    {
        path: '/users',
        component: Users
    }
];

const router = new VueRouter({ routes });

export default router;