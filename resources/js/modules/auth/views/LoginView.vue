<template>
  <div class="min-h-screen bg-slate-100 flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
      <div class="text-center mb-8">
        <router-link to="/" class="inline-flex items-center gap-2 mb-4">
          <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold text-xl">
            T
          </div>
          <span class="font-extrabold text-xl text-slate-900">Tap<span class="text-indigo-600">Review</span></span>
        </router-link>
        <h1 class="text-xl font-bold text-slate-900">Masuk ke Portal Usaha</h1>
        <p class="text-xs text-slate-500 mt-1">
          Akses ringkasan tap, ubah link ulasan, dan unduh materi cetak.
        </p>
      </div>

      <div v-if="magicSent" class="p-4 bg-indigo-50 border border-indigo-200 rounded-xl text-center mb-6">
        <div class="text-2xl mb-2">📩</div>
        <h3 class="text-sm font-bold text-indigo-900 mb-1">Tautan Masuk Terkirim!</h3>
        <p class="text-xs text-indigo-700">
          Kami telah mengirimkan link masuk langsung ke email <strong>{{ email }}</strong>. Silakan periksa inbox atau folder spam Anda.
        </p>
      </div>

      <form v-else @submit.prevent="requestMagicLink" class="space-y-4">
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Email Terdaftar</label>
          <input 
            v-model="email" 
            type="email" 
            required 
            placeholder="nama@usahaanda.com" 
            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
          />
        </div>

        <button 
          type="submit" 
          :disabled="loading"
          class="w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md shadow-indigo-200 transition disabled:opacity-50"
        >
          {{ loading ? 'Mengirim Magic Link...' : 'Kirim Tautan Masuk (Magic Link)' }}
        </button>
      </form>

      <!-- Quick Demo Access Section -->
      <div class="mt-8 pt-6 border-t border-slate-100">
        <div class="text-center text-[11px] font-semibold uppercase tracking-wider text-slate-400 mb-3">
          Akses Cepat Pengujian (Mode Demo)
        </div>
        <div class="grid grid-cols-2 gap-3">
          <router-link 
            to="/portal" 
            class="py-2 px-3 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs font-medium text-slate-700 text-center transition"
          >
            Masuk Portal Klien →
          </router-link>
          <router-link 
            to="/admin" 
            class="py-2 px-3 rounded-lg bg-amber-50 hover:bg-amber-100 border border-amber-200 text-xs font-medium text-amber-900 text-center transition"
          >
            Masuk Panel Admin →
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const email = ref('klien@kopisudut.com');
const loading = ref(false);
const magicSent = ref(false);

function requestMagicLink() {
  loading.value = true;
  setTimeout(() => {
    loading.value = false;
    magicSent.value = true;
  }, 600);
}
</script>
