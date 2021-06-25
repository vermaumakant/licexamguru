/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

import Vue from "vue";
import Element from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import _Cookies from "js-cookie";
import VueRouter from "vue-router";
import routes from "./routes";
window.Cookies = _Cookies;
//console.log("@components/toolbar");
//import ToolBar from "@components/toolbar";

// Vue.component("toolbar", ToolBar);
Vue.use(VueRouter);
Vue.use(Element);
Vue.prototype.$http = window.axios.create({
    timeout: 20000,
    baseURL: "/api/v1",
    headers: {
        "X-Requested-With": "XMLHttpRequest"
    }
});
const token = Cookies.get("token");
if (token) {
    Vue.prototype.$http.defaults.headers[
        "Authorization"
    ] = window.axios.defaults.headers["Authorization"] = `Bearer ${token}`;
}

const router = new VueRouter({ mode: 'history', routes });
router.beforeEach(async (to, from, next) => {
    const token = Cookies.get("token");
    if (to.path === "/" && !to.meta.auth) {
        return next({ path: "/sign-in", query: from.query });
    }
    if (to.meta.auth) {
        if (!token) {
            return next({ path: "/sign-in", query: from.query });
        }
        return next({ path: "/admin", query: from.query });
    }
    // if (["/sign-in", "/sign-up"].indexOf(to.path) > -1 && token) {
    //     return next({ path: "/redirection", query: from.query });
    // }
    return next({ query: from.query });
});

Vue.mixin({
    filters: {
        concat(value) {
            if (!Array.isArray(value)) {
                return null;
            }

            return value.join(", ");
        }
    },
    methods: {
        async authProvider(provider) {
        }
    }
});
const app = new Vue({
    router
}).$mount("#app");
