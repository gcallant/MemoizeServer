import Colors from "./components/Colors";
import Typography from "./components/Typography";
import Illustrations from "./components/Illustrations";
import NotFound from "./components/NotFound";
import SiteStats from "./components/SiteStats";
import Achievements from "./components/Achievements";
import Login from "./components/Login";
import Vue from "vue";
import Router from "vue-router";
import axios from "axios";
import Home from "./components/Home";
import Logout from "./components/Logout";

Vue.use(Router);


/**
 * Sends a post request to isAuthenticated with axios default headers.
 * @returns 200 if authenticated, or 401 otherwise.
 */
const isAuthenticated = async () => {
    let response = await axios.get('/api/isAuthenticated');

    return response.status === 200;
}

/**
 * Removes revoked or unauthorized tokens from localstorage
 */
const removeTokenIfExisting = () => {
    if (localStorage.getItem('memoizeToken') != null) {
        localStorage.removeItem('memoizeToken')
    }
}

/**
 * Async function that is called before each page load that needs to be authenticated.
 */
const beforeEnter = async (to, from, next) => {
    try {
        let authenticated = await isAuthenticated();
        if (authenticated) {
            next()
        } else {
            next('/login')
            removeTokenIfExisting()
        }
    } catch (e) {
        next('/login')
        removeTokenIfExisting()
    }
}

/**
 * Our Vue Router.
 */
export default new Router({
    mode: 'history',

    linkActiveClass: 'font-bold',

    routes: [
        {
            path: '/',
            component: Home,
            beforeEnter
        },
        {
            path: '*',
            component: NotFound,
            beforeEnter
        },
        {
            path: '/colors',
            component: Colors,
            beforeEnter
        },
        {
            path: '/typography',
            component: Typography,
            beforeEnter
        },
        {
            path: '/illustrations',
            component: Illustrations,
            beforeEnter
        },
        {
            path: '/site-stats',
            component: SiteStats,
            beforeEnter
        },
        {
            path: '/achievements',
            component: Achievements,
            beforeEnter
        },
        {
            path: '/login',
            component: Login,
            meta: {requiresAuth: false}
        },
        {
            path: '/logout',
            component: Logout,
            beforeEnter
        },
        {
            path: '/home',
            component: Home,
            beforeEnter
        }
    ]
});
