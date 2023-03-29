import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import Login from './components/Login.vue'
import Dashboard from './components/Dashboard.vue'

const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Client/Dashboard,
        },
        {
            path: '/produit',
            name: 'produit',
            component: Client/Produit,
            meta: { requiresAuth: true },
        },
    ]
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.getters.isAuthenticated) {
            next({
                path: '/dashboard',
                query: { redirect: to.fullPath }
            })
        } else {
            next()
        }
    } else {
        next()
    }
})

export default router
