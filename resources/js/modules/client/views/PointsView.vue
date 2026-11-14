<template>
  <div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h2 class="text-xl font-bold tracking-tight text-zinc-950">Titik Stiker & Chip NFC</h2>
        <p class="text-xs text-zinc-500 font-mono mt-0.5">
          STATUS HARDWARE MEJA KASIR & STATISTIK JALUR FISIK
        </p>
      </div>

      <button 
        @click="fetchPoints" 
        :disabled="loading"
        class="self-start sm:self-auto px-3 py-1.5 rounded-md bg-white border border-zinc-300 text-xs font-semibold uppercase tracking-wider text-zinc-700 hover:bg-zinc-50 shadow-sm transition flex items-center gap-1.5"
      >
        <RefreshCw class="w-3.5 h-3.5" :class="{'animate-spin': loading}" />
        <span>Sinkronisasi Data</span>
      </button>
    </div>

    <!-- Points Table -->
    <div class="bg-white rounded-lg border border-zinc-200/90 overflow-hidden shadow-sm">
      <table class="w-full text-left text-xs">
        <thead class="bg-zinc-50 border-b border-zinc-200 text-zinc-500 font-mono font-semibold uppercase text-[10px]">
          <tr>
            <th class="py-3 px-4">KODE TITIK</th>
            <th class="py-3 px-4">LOKASI FISIK</th>
            <th class="py-3 px-4 text-center">NFC TAPS</th>
            <th class="py-3 px-4 text-center">QR SCANS</th>
            <th class="py-3 px-4 text-center font-bold">TOTAL</th>
            <th class="py-3 px-4">STATUS CHIP</th>
            <th class="py-3 px-4 text-right">UJI JALUR</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-zinc-100 text-zinc-700">
          <tr v-for="point in points" :key="point.point_code" class="hover:bg-zinc-50/70 transition">
            <td class="py-3.5 px-4 font-mono font-bold text-zinc-950">
              {{ point.point_code }}
            </td>
            <td class="py-3.5 px-4">
              <div class="font-semibold text-zinc-900">{{ point.location_label }}</div>
              <div class="text-[10px] text-zinc-400 font-mono">CHIP UID: {{ point.nfc_uid || 'NONE' }}</div>
            </td>
            <td class="py-3.5 px-4 text-center font-mono">
              <span class="inline-flex items-center px-2 py-0.5 rounded bg-zinc-100 text-zinc-800 font-medium border border-zinc-200">
                {{ point.nfc_taps }}
              </span>
            </td>
            <td class="py-3.5 px-4 text-center font-mono">
              <span class="inline-flex items-center px-2 py-0.5 rounded bg-orange-50 text-orange-800 font-medium border border-orange-200">
                {{ point.qr_scans }}
              </span>
            </td>
            <td class="py-3.5 px-4 text-center font-mono font-bold text-zinc-950">
              {{ point.total_taps }}
            </td>
            <td class="py-3.5 px-4 font-mono text-[11px]">
              <span 
                class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider"
                :class="point.chip_status === 'locked' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-zinc-100 text-zinc-700 border border-zinc-200'"
              >
                <Lock class="w-3 h-3 text-emerald-600" />
                <span>{{ point.chip_status === 'locked' ? 'LOCKED (AMAN)' : point.chip_status }}</span>
              </span>
            </td>
            <td class="py-3.5 px-4 text-right space-x-1.5 font-mono text-[10px]">
              <a 
                :href="point.nfc_url" 
                target="_blank" 
                class="inline-block px-2 py-1 rounded bg-zinc-100 hover:bg-zinc-200 text-zinc-800 font-semibold border border-zinc-200 transition"
                title="Simulasi Tap NFC"
              >
                TAP NFC ↗
              </a>
              <a 
                :href="point.qr_url" 
                target="_blank" 
                class="inline-block px-2 py-1 rounded bg-orange-50 hover:bg-orange-100 text-orange-950 font-semibold border border-orange-200 transition"
                title="Simulasi Scan QR"
              >
                SCAN QR ↗
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
import { RefreshCw, Lock } from 'lucide-vue-next';

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
