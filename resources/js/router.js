import { createRouter, createWebHistory } from 'vue-router';
import Home from './components/Home.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import Dashboard from './components/Dashboard.vue';
import Users from './components/Users.vue';
import Roles from './components/Roles.vue';
import Permissions from './components/Permissions.vue';
import Profile from './components/Profile.vue';

const routes = [
    { 
      path: '/', 
      component: Home, 
      name: 'home'
    },
    { 
      path: '/login', 
      component: Login, 
      name: 'login' 
    },
    { 
      path: '/register', 
      component: Register, 
      name: 'register' 
    },
    { 
      path: '/dashboard', 
      component: Dashboard, 
      name: 'dashboard',
      meta: { requiresAuth: true } 
    },
    { 
      path: '/users', 
      component: Users, 
      name: 'users' ,
      meta: { requiresAuth: true }
    },
    { 
      path: '/roles', 
      component: Roles, 
      name: 'roles',
      meta: { requiresAuth: true } 
    },
    { 
      path: '/permissions', 
      component: Permissions, 
      name: 'permissions',
      meta: { requiresAuth: true } 
    },
    { 
      path: '/profile', 
      component: Profile, 
      name: 'profile',
      meta: { requiresAuth: true } 
    },
];

const router = createRouter({
    history: createWebHistory('/'),
    routes,
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');
    if (to.matched.some(record => record.meta.requiresAuth) && !token) {
      // Redirect to login page if not authenticated
      next({ name: 'login' });
    } else {
      next(); // Allow access
    }
  });

export default router;
