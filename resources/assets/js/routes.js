//imports
import Vue from "vue";
import VueRouter from "vue-router";
import LoginComponent from "./components/LoginComponent.vue";
import LogoutComponent from "./components/LogoutComponent.vue";
import DashboardComponent from "./components/panel/DashboardComponent.vue";
import IndexTeamComponent from "./components/panel/teams/IndexTeamComponent.vue";
import CreateTeamComponent from "./components/panel/teams/CreateTeamComponent.vue";
import EditTeamComponent from "./components/panel/teams/EditTeamComponent.vue";
import ShowTeamComponent from "./components/panel/teams/ShowTeamComponent.vue";
import IndexPlayerComponent from "./components/panel/players/IndexPlayerComponent.vue";
import CreatePlayerComponent from "./components/panel/players/CreatePlayerComponent.vue";
import EditPlayerComponent from "./components/panel/players/EditPlayerComponent.vue";

import store from "./store/index";
Vue.use(VueRouter);

//routes
const routes = [
    {
        path: '/',
        redirect: {name: 'login'}
    },

    {
        path: '/login',
        name: 'login',
        component: LoginComponent
    },
    {
        path: '/logout',
        name: 'logout',
        component: LogoutComponent
    },
    {
        path: '/panel/dashboard',
        name: 'dashboard',
        component: DashboardComponent,
        meta: {requiresAuth: true}  // auth
    },
    {
        path: '/panel/teams',
        name: 'index-team',
        component: IndexTeamComponent,
        meta: {requiresAuth: true}  // auth
    },
    {
        path: '/panel/teams/create',
        name: 'create-team',
        component: CreateTeamComponent,
        meta: {requiresAuth: true}  // auth
    },
    {
        path: '/panel/teams/:id/edit',
        name: 'edit-team',
        component: EditTeamComponent,
        meta: {requiresAuth: true}  // auth
    },
    {
        path: '/panel/teams/:id',
        name: 'show-team',
        component: ShowTeamComponent,
        meta: {requiresAuth: true}  // auth
    },
    {
        path: '/panel/players',
        name: 'index-player',
        component: IndexPlayerComponent,
        meta: {requiresAuth: true}  // auth
    },
    {
        path: '/panel/players/create',
        name: 'create-player',
        component: CreatePlayerComponent,
        meta: {requiresAuth: true}  // auth
    },
    {
        path: '/panel/players/:id/edit',
        name: 'edit-player',
        component: EditPlayerComponent,
        meta: {requiresAuth: true}  // auth
    },
];

const router = new VueRouter({
    // mode: 'history',
    routes
});
router.beforeEach((to, from, next) => {

    // check if the route requires authentication and user is not logged in
    if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedIn) {
        // redirect to login page
        next({name: 'login'});
        return
    }

    // if logged in redirect to dashboard
    if (to.path === '/login' && store.state.isLoggedIn) {
        next({name: 'dashboard'});
        return
    }

    next()
});
export default router;