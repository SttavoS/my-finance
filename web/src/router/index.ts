import { createRouter, createWebHistory } from 'vue-router';
import DashboardView from '@/views/DashboardView.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: DashboardView,
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/DashboardView.vue'),
    },
    {
      path: '/plano-contas',
      name: 'plano-contas',
      component: () => import('../views/PlanoContas.vue'),
    },
    {
      path: '/transacoes',
      name: 'transacoes',
      component: () => import('../views/Transacoes.vue'),
    },
  ],
});

export default router;
