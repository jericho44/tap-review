import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  // Public Routes
  {
    path: '/',
    name: 'home',
    component: () => import('@/modules/public/views/HomeView.vue'),
  },
  {
    path: '/generator',
    name: 'generator',
    component: () => import('@/modules/public/views/QrGeneratorView.vue'),
  },
  {
    path: '/harga',
    name: 'pricing',
    component: () => import('@/modules/public/views/PricingView.vue'),
  },
  {
    path: '/pesan',
    name: 'order',
    component: () => import('@/modules/public/views/OrderView.vue'),
  },
  {
    path: '/demo',
    name: 'demo',
    component: () => import('@/modules/public/views/DemoView.vue'),
  },
  {
    path: '/masuk',
    name: 'login',
    component: () => import('@/modules/auth/views/LoginView.vue'),
  },

  // Client Portal Routes
  {
    path: '/portal',
    component: () => import('@/layouts/ClientLayout.vue'),
    children: [
      {
        path: '',
        name: 'client.dashboard',
        component: () => import('@/modules/client/views/DashboardView.vue'),
      },
      {
        path: 'points',
        name: 'client.points',
        component: () => import('@/modules/client/views/PointsView.vue'),
      },
      {
        path: 'destination',
        name: 'client.destination',
        component: () => import('@/modules/client/views/DestinationView.vue'),
      },
      {
        path: 'materials',
        name: 'client.materials',
        component: () => import('@/modules/client/views/MaterialsView.vue'),
      },
    ],
  },

  // Admin Panel Routes
  {
    path: '/admin',
    component: () => import('@/layouts/AdminLayout.vue'),
    children: [
      {
        path: '',
        name: 'admin.dashboard',
        component: () => import('@/modules/admin/views/DashboardView.vue'),
      },
      {
        path: 'clients',
        name: 'admin.clients',
        component: () => import('@/modules/admin/views/ClientsView.vue'),
      },
      {
        path: 'points',
        name: 'admin.points',
        component: () => import('@/modules/admin/views/PointsView.vue'),
      },
      {
        path: 'themes',
        name: 'admin.themes',
        component: () => import('@/modules/admin/views/ThemesView.vue'),
      },
      {
        path: 'orders',
        name: 'admin.orders',
        component: () => import('@/modules/admin/views/OrdersView.vue'),
      },
      {
        path: 'audit-logs',
        name: 'admin.audit-logs',
        component: () => import('@/modules/admin/views/AuditLogsView.vue'),
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 };
  },
});

export default router;
