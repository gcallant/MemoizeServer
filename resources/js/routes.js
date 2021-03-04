import Logo from "./components/Logo";
import LogoSymbol from "./components/LogoSymbol";
import Colors from "./components/Colors";
import Typography from "./components/Typography";
import Mascot from "./components/Mascot";
import Illustrations from "./components/Illustrations";

import Wallpapers from "./components/Wallpapers";
import NotFound from "./components/NotFound";
import SiteStats from "./components/SiteStats";
import Achievements from "./components/Achievements";
import Login from "./components/Login";
import Vue from "vue";
import Router from "vue-router";
import LoggedIn from "./components/LoggedIn";
import axios from "axios";
import Home from "./components/Home";
import Logout from "./components/Logout";

Vue.use(Router);

let LoadersAndAnimations = () => import('./components/LoadersAndAnimations');

async function isAuthenticated () {
    var response = await axios.get('/api/isAuthenticated');

    return response.status === 200;
}

/**
 * Removes revoked or unauthorized tokens from localstorage
 */
function removeTokenIfExisting() {
    if (localStorage.getItem('memoizeToken') != null) {
        localStorage.removeItem('memoizeToken')
    }
}

async function beforeEnter(to, from, next){
    try{
        let authenticated = await isAuthenticated();
        if(authenticated){
            next()
        }
        else {
            next('/login')
            removeTokenIfExisting()
        }
    } catch (e) {
        next('/login')
        removeTokenIfExisting()
    }
}

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
            path: '/logged-in',
            component: LoggedIn,
            meta: {requiresAuth: false}
        },

        {
            path: '/logo',
            component: Logo,
            beforeEnter
        },

        {
            path: '/logo-symbol',
            component: LogoSymbol,
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
            path: '/mascot',
            component: Mascot,
            beforeEnter
        },
        {
            path: '/illustrations',
            component: Illustrations,
            beforeEnter
        },
        {
            path: '/loaders-and-animations',
            component: LoadersAndAnimations,
            beforeEnter
        },
        {
            path: '/wallpapers',
            component: Wallpapers,
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
