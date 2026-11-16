import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import apiClient from '@/api/client';
import type { ApiResponse } from '@/types/api';

export interface AuthUser {
  uuid: string;
  name: string;
  email: string;
  role: 'super_admin' | 'admin_staff' | 'client_owner' | 'client_manager' | string;
  tenant_id: number | null;
  business_name?: string | null;
  client_slug?: string | null;
}

export const useAuthStore = defineStore('auth', () => {
  const token = ref<string | null>(localStorage.getItem('tapreview_token'));
  const user = ref<AuthUser | null>(
    localStorage.getItem('tapreview_user')
      ? JSON.parse(localStorage.getItem('tapreview_user')!)
      : null
  );

  const isAuthenticated = computed(() => !!token.value);
  const isAdmin = computed(() => user.value?.role === 'super_admin' || user.value?.role === 'admin_staff');
  const isClient = computed(() => user.value?.role === 'client_owner' || user.value?.role === 'client_manager');

  async function login(email: string, password: string): Promise<AuthUser> {
    const res = await apiClient.post<ApiResponse<{ token: string; user: AuthUser }>>('/auth/login', {
      email,
      password,
    });

    if (res.data.success && res.data.data) {
      token.value = res.data.data.token;
      user.value = res.data.data.user;

      localStorage.setItem('tapreview_token', res.data.data.token);
      localStorage.setItem('tapreview_user', JSON.stringify(res.data.data.user));

      return res.data.data.user;
    }

    throw new Error(res.data.message || 'Login gagal.');
  }

  async function fetchUser(): Promise<AuthUser | null> {
    if (!token.value) return null;

    try {
      const res = await apiClient.get<ApiResponse<AuthUser>>('/auth/me');
      if (res.data.success && res.data.data) {
        user.value = res.data.data;
        localStorage.setItem('tapreview_user', JSON.stringify(res.data.data));
        return res.data.data;
      }
    } catch {
      logout();
    }
    return null;
  }

  async function logout() {
    try {
      if (token.value) {
        await apiClient.post('/auth/logout');
      }
    } catch {
      // Ignore network errors on logout
    } finally {
      token.value = null;
      user.value = null;
      localStorage.removeItem('tapreview_token');
      localStorage.removeItem('tapreview_user');
      window.location.href = '/masuk';
    }
  }

  return {
    token,
    user,
    isAuthenticated,
    isAdmin,
    isClient,
    login,
    fetchUser,
    logout,
  };
});
