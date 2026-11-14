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

      <div v-if="magicSent" class="p-4 bg-zinc-50 border border-zinc-200 rounded-md text-center mb-6 space-y-1">
        <Mail class="w-6 h-6 text-zinc-800 mx-auto mb-1" />
        <h3 class="text-xs font-bold text-zinc-900">Tautan Masuk Terkirim</h3>
        <p class="text-xs text-zinc-600 leading-relaxed">
          Tautan masuk satu kali pakai telah dikirimkan ke <strong>{{ email }}</strong>.
        </p>
      </div>

      <form v-else @submit.prevent="requestMagicLink" class="space-y-4">
        <div>
          <label class="block text-xs font-semibold text-zinc-800 mb-1">Email Terdaftar</label>
          <input 
            v-model="email" 
            type="email" 
            required 
            placeholder="nama@usahaanda.com" 
            class="w-full px-3 py-2 rounded-md border border-zinc-300 text-xs font-medium text-zinc-900 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 outline-none transition"
          />
        </div>

        <button 
          type="submit" 
          :disabled="loading"
          class="w-full py-2.5 rounded-md bg-zinc-950 hover:bg-zinc-800 text-white font-semibold text-xs uppercase tracking-wider transition shadow-sm disabled:opacity-50"
        >
          {{ loading ? 'Mengirim...' : 'Kirim Magic Link Masuk' }}
        </button>
      </form>

      <!-- Quick Demo Access Section -->
      <div class="mt-8 pt-5 border-t border-zinc-100">
        <div class="text-center text-[10px] font-mono uppercase tracking-wider text-zinc-400 mb-3">
          AKSES CEPAT PENGUJIAN (DEVELOPMENT)
        </div>
        <div class="grid grid-cols-2 gap-2">
          <router-link 
            to="/portal" 
            class="py-2 px-3 rounded-md bg-zinc-100 hover:bg-zinc-200 border border-zinc-200 text-xs font-semibold text-zinc-800 text-center transition"
          >
            Portal Klien →
          </router-link>
          <router-link 
            to="/admin" 
            class="py-2 px-3 rounded-md bg-zinc-900 hover:bg-zinc-950 text-white text-xs font-semibold text-center transition"
          >
            Panel Admin →
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Mail } from 'lucide-vue-next';

const email = ref('klien@kopisudut.com');
const loading = ref(false);
const magicSent = ref(false);

function requestMagicLink() {
  loading.value = true;
  setTimeout(() => {
    loading.value = false;
    magicSent.value = true;
  }, 500);
}
</script>
