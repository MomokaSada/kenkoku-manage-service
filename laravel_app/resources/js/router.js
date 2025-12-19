import { createRouter, createWebHistory } from 'vue-router';

// 1. Define route components.
import Login from './views/Login.vue';
import Dashboard from './views/Dashboard.vue';
import NotFound from './views/NotFound.vue';

// 2. Define some routes
const routes = [
    { path: '/login', component: Login, name: 'Login' },
    {
        path: '/dashboard',
        component: Dashboard,
        name: 'Dashboard',
        meta: { requiresAuth: true }
    },
    // Optional: Redirect root to Login or Dashboard based on auth in future
    { path: '/', redirect: '/login' },
    // Catch all 404
    { path: '/:pathMatch(.*)*', component: NotFound, name: 'NotFound' },
]

// 3. Create the router instance and pass the `routes` option
const router = createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: createWebHistory(),
    routes, // short for `routes: routes`
})

router.beforeEach((to, from, next) => {
    const isAuthenticated = localStorage.getItem('auth_token');

    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!isAuthenticated) {
            next({ name: 'Login' });
        } else {
            next();
        }
    } else {
        // If trying to access login page while authenticated, redirect to dashboard
        if (to.name === 'Login' && isAuthenticated) {
            next({ name: 'Dashboard' });
        } else {
            next();
        }
    }
});

export default router;
