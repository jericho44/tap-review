import axios, { type AxiosInstance, type AxiosRequestConfig } from 'axios';
import type { ApiResponse } from '@/types/api';

const apiClient: AxiosInstance = axios.create({
  baseURL: '/api/v1',
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
  },
  withCredentials: true, // For Sanctum stateful cookie authentication
});

// Interceptor to generate / forward request ID if needed
apiClient.interceptors.request.use((config) => {
  if (!config.headers['X-Request-ID']) {
    config.headers['X-Request-ID'] = crypto.randomUUID();
  }
  return config;
});

export default apiClient;
