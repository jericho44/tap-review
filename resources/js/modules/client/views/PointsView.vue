<template>
  <div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h2 class="text-xl font-bold text-slate-900">Titik Stiker (NFC & QR)</h2>
        <p class="text-xs text-slate-500">
          Daftar lokasi stiker yang terpasang di tempat usaha Anda beserta metrik kunjungan masing-masing.
        </p>
      </div>

      <button 
        @click="fetchPoints" 
        :disabled="loading"
        class="self-start sm:self-auto px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-700 hover:bg-slate-50 shadow-sm transition flex items-center gap-1.5"
      >
        <span :class="{'animate-spin': loading}">🔄</span> Segarkan Titik
      </button>
    </div>

    <!-- Points Table -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
      <div v-if="loading && points.length === 0" class="p-8 text-center text-xs text-slate-400">
        Memuat data titik...
      </div>

      <table v-else class="w-full text-left text-xs">
        <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase">
          <tr>
            <th class="py-3 px-4">Kode Titik</th>
            <th class="py-3 px-4">Label Lokasi</th>
            <th class="py-3 px-4 text-center">Tap NFC</th>
            <th class="py-3 px-4 text-center">Scan QR</th>
            <th class="py-3 px-4 text-center font-bold">Total Kunjungan</th>
            <th class="py-3 px-4">Status Chip</th>
            <th class="py-3 px-4 text-right">Uji Link Langsung</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700">
          <tr v-for="point in points" :key="point.point_code" class="hover:bg-slate-50/70 transition">
            <td class="py-3.5 px-4 font-mono font-bold text-indigo-600">
              {{ point.point_code }}
            </td>
            <td class="py-3.5 px-4">
              <div class="font-semibold text-slate-900">{{ point.location_label }}</div>
              <div class="text-[10px] text-slate-400 font-mono">UID: {{ point.nfc_uid || 'Belum dicatat' }}</div>
            </td>
            <td class="py-3.5 px-4 text-center font-medium">
              <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-700 font-mono">
                {{ point.nfc_taps }} tap
              </span>
            </td>
            <td class="py-3.5 px-4 text-center font-medium">
              <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-amber-50 text-amber-800 font-mono">
                {{ point.qr_scans }} scan
              </span>
            </td>
            <td class="py-3.5 px-4 text-center font-extrabold text-slate-900">
              {{ point.total_taps }}
            </td>
            <td class="py-3.5 px-4">
              <span 
                class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold"
                :class="point.chip_status === 'locked' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700'"
              >
                {{ point.chip_status === 'locked' ? '🔒 Terkunci (Locked)' : point.chip_status }}
              </span>
            </td>
            <td class="py-3.5 px-4 text-right space-x-1">
              <a 
                :href="point.nfc_url" 
                target="_blank" 
                class="inline-block px-2.5 py-1 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-[10px] font-semibold transition"
                title="Simulasi Tap NFC"
              >
                Uji NFC ↗
              </a>
              <a 
                :href="point.qr_url" 
                target="_blank" 
                class="inline-block px-2.5 py-1 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-900 text-[10px] font-semibold transition"
                title="Simulasi Scan QR"
              >
                Uji QR ↗
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import apiClient from '@/api/client';
import type { ApiResponse } from '@/types/api';

interface PointItem {
  uuid: string;
  point_code: string;
  location_label: string;
  nfc_uid: string | null;
  chip_status: string;
  physical_status: string;
  nfc_taps: number;
  qr_scans: number;
  total_taps: number;
  nfc_url: string;
  qr_url: string;
}

const points = ref<PointItem[]>([]);
const loading = ref(false);

async function fetchPoints() {
  loading.value = true;
  try {
    const res = await apiClient.get<ApiResponse<PointItem[]>>('/client/points');
    if (res.data.success && res.data.data) {
      points.value = res.data.data;
    }
  } catch (err) {
    console.error('Failed to fetch points', err);
  } finally {
    loading.value = false;
  }
}

onMounted(() => {
  fetchPoints();
});
</script>
