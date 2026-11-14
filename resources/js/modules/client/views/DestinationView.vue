<template>
  <div class="max-w-2xl space-y-6">
    <div>
      <h2 class="text-xl font-bold tracking-tight text-zinc-950">Konfigurasi Target URL Ulasan</h2>
      <p class="text-xs text-zinc-500 font-mono mt-0.5">
        RUNTIME ROUTING CONFIGURATION · CACHE REVALIDATION
      </p>
    </div>

    <div class="bg-white rounded-lg border border-zinc-200/90 p-6 sm:p-7 shadow-sm">
      <!-- Success Message -->
      <div v-if="successMsg" class="p-4 mb-6 bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs rounded-md font-medium flex items-center justify-between">
        <div class="flex items-center gap-2">
          <Check class="w-4 h-4 text-emerald-600" />
          <span>{{ successMsg }}</span>
        </div>
        <a 
          :href="destinationUrl" 
          target="_blank" 
          class="underline font-bold text-emerald-950 hover:text-emerald-700 font-mono text-[11px]"
        >
          Cek di Maps ↗
        </a>
      </div>

      <!-- Error Message -->
      <div v-if="errorMsg" class="p-4 mb-6 bg-rose-50 border border-rose-200 text-rose-900 text-xs rounded-md font-medium flex items-center gap-2">
        <AlertTriangle class="w-4 h-4 text-rose-600 shrink-0" />
        <span>{{ errorMsg }}</span>
      </div>

      <form @submit.prevent="saveDestination" class="space-y-4">
        <div>
          <label class="block text-xs font-semibold text-zinc-800 mb-1">
            Target URL Ulasan Google Maps Baru
          </label>
          <input 
            v-model="destinationUrl" 
            type="url" 
            required
            placeholder="https://maps.app.goo.gl/... atau https://g.page/r/..." 
            class="w-full px-3 py-2 rounded-md border border-zinc-300 text-xs font-mono text-zinc-900 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 outline-none transition"
          />
          <p class="text-[11px] text-zinc-500 mt-1.5 leading-relaxed font-mono">
            DOMAINS ALLOWED: maps.app.goo.gl, g.page, google.com
          </p>
        </div>

        <div class="pt-2 flex items-center gap-3">
          <button 
            type="submit" 
            :disabled="saving"
            class="px-5 py-2.5 rounded-md bg-zinc-950 hover:bg-zinc-800 text-white font-semibold text-xs uppercase tracking-wider transition shadow-sm disabled:opacity-50"
          >
            {{ saving ? 'Menyimpan...' : 'Simpan & Revalidasi Cache' }}
          </button>

          <a 
            href="/r/kopisudut?src=nfc" 
            target="_blank" 
            class="px-4 py-2.5 rounded-md border border-zinc-300 hover:bg-zinc-50 text-zinc-800 font-semibold text-xs uppercase tracking-wider transition"
          >
            Uji Redirect Stiker ↗
          </a>
        </div>
      </form>
    </div>

    <!-- Security & Policy Info Box -->
    <div class="bg-zinc-50 rounded-lg border border-zinc-200 p-5 text-xs text-zinc-800 leading-relaxed space-y-1">
      <div class="font-bold flex items-center gap-2 font-mono text-[11px] uppercase tracking-wider text-zinc-950">
        <ShieldCheck class="w-4 h-4 text-zinc-800" />
        <span>SISTEM AUDIT KEAMANAN OTOMATIS</span>
      </div>
      <p class="text-zinc-600 text-xs">
        Setiap kali link ulasan diubah, sistem mencatat riwayat perubahan pada <em>Security Audit Log</em> (URL lama, URL baru, waktu, dan IP aktor). Cache in-memory diperbarui seketika dalam kurun waktu milidetik.
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import apiClient from '@/api/client';
import type { ApiResponse } from '@/types/api';
import { Check, AlertTriangle, ShieldCheck } from 'lucide-vue-next';

const destinationUrl = ref('');
const successMsg = ref('');
const errorMsg = ref('');
const saving = ref(false);

async function fetchDestination() {
  try {
    const res = await apiClient.get<ApiResponse<{ destination_url: string }>>('/client/destination');
    if (res.data.success && res.data.data) {
      destinationUrl.value = res.data.data.destination_url;
    }
  } catch (err) {
    console.error('Failed to fetch destination', err);
  }
}

async function saveDestination() {
  saving.value = true;
  successMsg.value = '';
  errorMsg.value = '';

  try {
    const res = await apiClient.put<ApiResponse<{ destination_url: string }>>('/client/destination', {
      destination_url: destinationUrl.value,
    });

    if (res.data.success) {
      successMsg.value = res.data.message || 'Link ulasan berhasil diperbarui dan aktif di seluruh stiker.';
      destinationUrl.value = res.data.data.destination_url;
    }
  } catch (err: any) {
    if (err.response?.data?.errors?.destination_url) {
      errorMsg.value = err.response.data.errors.destination_url[0];
    } else if (err.response?.data?.message) {
      errorMsg.value = err.response.data.message;
    } else {
      errorMsg.value = 'Gagal menyimpan link ulasan. Periksa format URL Anda.';
    }
  } finally {
    saving.value = false;
  }
}

onMounted(() => {
  fetchDestination();
});
</script>
