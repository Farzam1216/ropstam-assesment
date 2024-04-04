import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import Dashboard from '../components/Dashboard.vue';
import Category from '../components/Category.vue';
import Car from '../components/Car.vue';




const routes = [
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/dashboard', component: Dashboard  , meta: { requiresAuth: true }},
  { path: '/category', component: Category  , meta: { requiresAuth: true }},
  { path: '/car', component: Car  , meta: { requiresAuth: true }},

];

const router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = localStorage.getItem('token');
    if (to.meta.requiresAuth && !isAuthenticated) {
      // Redirect to login page if authentication is required but user is not authenticated
      next('/login');
      // Show message indicating the user needs to log in
      // You can use a global notification system or simply set a data property in your Vue instance
      // Example: app.$data.message = 'Please log in to access the dashboard';
    } else {
      next();
    }
  });

export default router;
