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
    meta: { guestOnly: true },
  },

  // Protected Client Portal Routes
  {
    path: '/portal',
    component: () => import('@/layouts/ClientLayout.vue'),
    meta: { requiresAuth: true, role: 'client' },
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

  // Protected Admin Panel Routes
  {
    path: '/admin',
    component: () => import('@/layouts/AdminLayout.vue'),
    meta: { requiresAuth: true, role: 'admin' },
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

// Authentication & RBAC Navigation Guards
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('tapreview_token');
  const userJson = localStorage.getItem('tapreview_user');
  const user = userJson ? JSON.parse(userJson) : null;

  const isAuthenticated = !!token;
  const isAdmin = user?.role === 'super_admin' || user?.role === 'admin_staff';
  const isClient = user?.role === 'client_owner' || user?.role === 'client_manager';

  // 1. Guest only page (/masuk)
  if (to.meta.guestOnly && isAuthenticated) {
    if (isAdmin) {
      return next({ path: '/admin' });
    }
    return next({ path: '/portal' });
  }

  // 2. Check protected route requiring authentication
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (!isAuthenticated) {
      return next({ path: '/masuk', query: { redirect: to.fullPath } });
    }

    // Role check for admin panel
    if (to.matched.some((record) => record.meta.role === 'admin')) {
      if (!isAdmin) {
        return next({ path: '/portal' });
      }
    }

    // Role check for client portal
    if (to.matched.some((record) => record.meta.role === 'client')) {
      if (!isClient && !isAdmin) {
        return next({ path: '/masuk' });
      }
    }
  }

  next();
});

export default router;
