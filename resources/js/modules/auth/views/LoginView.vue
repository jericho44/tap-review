<template>
  <div class="min-h-screen bg-zinc-100 flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-lg border border-zinc-200 p-8 shadow-sm">
      <div class="text-center mb-6">
        <router-link to="/" class="inline-flex items-center gap-2 mb-4">
          <div class="w-8 h-8 rounded-lg bg-zinc-950 text-white font-mono font-bold text-sm flex items-center justify-center">
            TR
          </div>
          <span class="font-bold text-base tracking-tight text-zinc-950 uppercase">TapReview</span>
        </router-link>
        <h1 class="text-lg font-bold text-zinc-950">Masuk ke Portal Usaha</h1>
        <p class="text-xs text-zinc-500 mt-1">
          Akses analitik kunjungan stiker dan ubah target link ulasan usaha Anda.
        </p>
      </div>

      <!-- Error Message Banner -->
      <div v-if="errorMessage" class="p-3 mb-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-md font-medium flex items-center gap-2">
        <AlertTriangle class="w-4 h-4 text-rose-600 shrink-0" />
        <span>{{ errorMessage }}</span>
      </div>

      <form @submit.prevent="handleLogin" class="space-y-4">
        <div>
          <label class="block text-xs font-semibold text-zinc-800 mb-1">Alamat Email</label>
          <input 
            v-model="email" 
            type="email" 
            required 
            placeholder="nama@usahaanda.com" 
            class="w-full px-3 py-2 rounded-md border border-zinc-300 text-xs font-medium text-zinc-900 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 outline-none transition"
          />
        </div>

        <div>
          <label class="block text-xs font-semibold text-zinc-800 mb-1">Password</label>
          <input 
            v-model="password" 
            type="password" 
            required 
            placeholder="••••••••" 
            class="w-full px-3 py-2 rounded-md border border-zinc-300 text-xs font-medium text-zinc-900 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 outline-none transition"
          />
        </div>

        <button 
          type="submit" 
          :disabled="loading"
          class="w-full py-2.5 rounded-md bg-zinc-950 hover:bg-zinc-800 text-white font-semibold text-xs uppercase tracking-wider transition shadow-sm disabled:opacity-50 flex items-center justify-center gap-2"
        >
          <span v-if="loading" class="animate-spin text-xs">⏳</span>
          <span>{{ loading ? 'Memverifikasi...' : 'Masuk Sekarang' }}</span>
        </button>
      </form>

      <!-- Quick 1-Click Credentials for Development / Demo -->
      <div class="mt-8 pt-5 border-t border-zinc-100">
        <div class="text-center text-[10px] font-mono uppercase tracking-wider text-zinc-400 mb-3">
          AKSES CEPAT AKUN UJI COBA
        </div>
        <div class="space-y-2">
          <button 
            type="button"
            @click="fillCredentials('owner@kopisudut.com', 'password123')"
            class="w-full py-2 px-3 rounded-md bg-zinc-50 hover:bg-zinc-100 border border-zinc-200 text-xs font-mono text-zinc-800 flex items-center justify-between transition text-left"
          >
            <div>
              <div class="font-bold">Klien: Kopi Sudut</div>
              <div class="text-[10px] text-zinc-400">owner@kopisudut.com</div>
            </div>
            <span class="text-[10px] uppercase font-bold text-orange-600">Pilih →</span>
          </button>

          <button 
            type="button"
            @click="fillCredentials('superadmin@tapreview.id', 'password123')"
            class="w-full py-2 px-3 rounded-md bg-zinc-900 hover:bg-zinc-950 text-white border border-zinc-800 text-xs font-mono flex items-center justify-between transition text-left"
          >
            <div>
              <div class="font-bold">Super Administrator</div>
              <div class="text-[10px] text-zinc-400">superadmin@tapreview.id</div>
            </div>
            <span class="text-[10px] uppercase font-bold text-orange-400">Pilih →</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import { AlertTriangle } from 'lucide-vue-next';

const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();

const email = ref('');
const password = ref('');
const loading = ref(false);
const errorMessage = ref('');

function fillCredentials(e: string, p: string) {
  email.value = e;
  password.value = p;
  errorMessage.value = '';
}

async function handleLogin() {
  loading.value = true;
  errorMessage.value = '';

  try {
    const user = await authStore.login(email.value, password.value);

    // Check redirect query param
    const redirectPath = route.query.redirect as string;
    if (redirectPath) {
      router.push(redirectPath);
      return;
    }

    // Role-based destination
    if (user.role === 'super_admin' || user.role === 'admin_staff') {
      router.push('/admin');
    } else {
      router.push('/portal');
    }
  } catch (err: any) {
    if (err.response?.data?.message) {
      errorMessage.value = err.response.data.message;
    } else {
      errorMessage.value = err.message || 'Gagal login. Periksa email dan password Anda.';
    }
  } finally {
    loading.value = false;
  }
}
</script>
