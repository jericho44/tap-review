<template>
  <div class="max-w-2xl space-y-6">
    <div>
      <h2 class="text-xl font-bold text-slate-900">Ubah Link Ulasan Google</h2>
      <p class="text-xs text-slate-500">
        Perubahan link tujuan ulasan akan berlaku seketika ke seluruh chip NFC dan kartu QR Anda tanpa perlu mengganti stiker.
      </p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <!-- Success Message -->
      <div v-if="successMsg" class="p-4 mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl font-medium flex items-center justify-between">
        <div class="flex items-center gap-2">
          <span>✓</span>
          <span>{{ successMsg }}</span>
        </div>
        <a 
          :href="destinationUrl" 
          target="_blank" 
          class="underline font-bold text-emerald-900 hover:text-emerald-700"
        >
          Cek Link Google ↗
        </a>
      </div>

      <!-- Error Message -->
      <div v-if="errorMsg" class="p-4 mb-6 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl font-medium">
        ⚠️ {{ errorMsg }}
      </div>

      <form @submit.prevent="saveDestination" class="space-y-5">
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">
            Link Ulasan Google Maps Baru
          </label>
          <input 
            v-model="destinationUrl" 
            type="url" 
            required
            placeholder="https://maps.app.goo.gl/... atau https://g.page/r/..." 
            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
          />
          <p class="text-[11px] text-slate-500 mt-1.5 leading-relaxed">
            Hanya domain Google resmi yang diperbolehkan (<code class="bg-slate-100 px-1 py-0.5 rounded text-indigo-700">maps.app.goo.gl</code>, <code class="bg-slate-100 px-1 py-0.5 rounded text-indigo-700">g.page</code>, atau <code class="bg-slate-100 px-1 py-0.5 rounded text-indigo-700">google.com</code>).
          </p>
        </div>

        <div class="pt-2 flex items-center gap-3">
          <button 
            type="submit" 
            :disabled="saving"
            class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs shadow-md shadow-indigo-100 transition disabled:opacity-50"
          >
            {{ saving ? 'Menyimpan & Mengupdate Cache...' : 'Simpan Perubahan Link' }}
          </button>

          <a 
            href="/r/kopisudut?src=nfc" 
            target="_blank" 
            class="px-4 py-2.5 rounded-xl border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold text-xs transition"
          >
            Uji Redirect Stiker Sekarang ↗
          </a>
        </div>
      </form>
    </div>

    <!-- Security & Policy Info Box -->
    <div class="bg-indigo-50/60 rounded-2xl border border-indigo-100 p-5 text-xs text-indigo-900 leading-relaxed">
      <h4 class="font-bold mb-1 flex items-center gap-1.5">
        <span>🛡️</span> Audit Keamanan Terintegrasi
      </h4>
      <p class="text-indigo-800/80">
        Setiap kali link ulasan diubah, sistem mencatat waktu, IP, dan histori link lama di <em>Security Audit Log</em>. Cache pengalihan langsung diperbarui otomatis dalam hitungan milidetik.
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import apiClient from '@/api/client';
import type { ApiResponse } from '@/types/api';

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
