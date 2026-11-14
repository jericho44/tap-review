<template>
  <div class="space-y-6">
    <!-- Top Greeting -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h2 class="text-xl font-bold text-slate-900">
          Ringkasan Ulasan & Kunjungan: {{ summary.business_name || 'Kopi Sudut' }}
        </h2>
        <p class="text-xs text-slate-500">
          Data analitik tap NFC dan scan QR usaha Anda tersinkronisasi realtime dari database.
        </p>
      </div>

      <div class="flex items-center gap-2">
        <button 
          @click="fetchSummary" 
          :disabled="loading"
          class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 shadow-sm transition text-xs flex items-center gap-1"
          title="Perbarui Data"
        >
          <span :class="{'animate-spin': loading}">🔄</span> Segarkan
        </button>
        <router-link to="/portal/destination" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 shadow-sm transition">
          Ganti Link Ulasan
        </router-link>
        <router-link to="/portal/materials" class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-xs font-semibold text-white shadow-sm transition">
          Cetak Materi QR
        </router-link>
      </div>
    </div>

    <!-- Loading Skeleton -->
    <div v-if="loading && !summary.business_name" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 animate-pulse">
      <div v-for="i in 4" :key="i" class="h-28 bg-white rounded-2xl border border-slate-200"></div>
    </div>

    <!-- Metric Cards -->
    <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="flex items-center justify-between text-slate-400 mb-2">
          <span class="text-xs font-semibold uppercase">Hari Ini</span>
          <span class="text-base">📅</span>
        </div>
        <div class="text-2xl font-extrabold text-slate-900">{{ summary.today_taps }}</div>
        <div class="text-[11px] text-emerald-600 font-medium mt-1">
          {{ summary.today_taps > 0 ? 'Kunjungan baru tercatat' : 'Belum ada tap hari ini' }}
        </div>
      </div>

      <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="flex items-center justify-between text-slate-400 mb-2">
          <span class="text-xs font-semibold uppercase">7 Hari Terakhir</span>
          <span class="text-base">📈</span>
        </div>
        <div class="text-2xl font-extrabold text-slate-900">{{ summary.last_7_days }}</div>
        <div class="text-[11px] text-slate-500 mt-1">Total interaksi minggu ini</div>
      </div>

      <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="flex items-center justify-between text-slate-400 mb-2">
          <span class="text-xs font-semibold uppercase">30 Hari Terakhir</span>
          <span class="text-base">🚀</span>
        </div>
        <div class="text-2xl font-extrabold text-indigo-600">{{ summary.last_30_days }}</div>
        <div class="text-[11px] text-emerald-600 font-medium mt-1">Pelanggan menuju Google Maps</div>
      </div>

      <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="flex items-center justify-between text-slate-400 mb-2">
          <span class="text-xs font-semibold uppercase">Rasio Sumber</span>
          <span class="text-base">📲</span>
        </div>
        <div class="text-2xl font-extrabold text-slate-900">{{ summary.nfc_percentage }}% NFC</div>
        <div class="text-[11px] text-slate-500 mt-1">{{ summary.qr_percentage }}% dari scan kode QR</div>
      </div>
    </div>

    <!-- Visual Chart & Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-bold text-slate-900">Aktivitas Tap 7 Hari Terakhir</h3>
          <span class="text-xs text-slate-400 font-medium">Berdasarkan waktu tap UTC</span>
        </div>

        <div class="h-48 flex items-end justify-between gap-3 pt-6 border-b border-slate-100 pb-2">
          <div v-for="(day, idx) in chartDays" :key="idx" class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
            <span class="text-[10px] font-mono text-slate-600 font-bold">{{ day.taps }}</span>
            <div class="w-full bg-slate-100 rounded-t-lg relative flex flex-col justify-end overflow-hidden max-w-[42px]" :style="{ height: '110px' }">
              <div 
                class="w-full bg-indigo-600 hover:bg-indigo-700 rounded-t-md transition-all duration-500 shadow-sm" 
                :style="{ height: calculateHeight(day.taps) }"
              ></div>
            </div>
            <span class="text-[11px] text-slate-600 font-semibold">{{ day.label }}</span>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
        <div>
          <h3 class="text-sm font-bold text-slate-900 mb-2">Link Ulasan Google Aktif</h3>
          <p class="text-xs text-slate-500 mb-4 leading-relaxed">
            Semua stiker meja kasir dan akrilik Anda saat ini mengarah ke alamat resmi ini:
          </p>
          <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-xs text-indigo-700 font-mono break-all mb-4 select-all">
            {{ summary.current_destination || 'https://maps.app.goo.gl/kopi-sudut-official' }}
          </div>
        </div>

        <router-link 
          to="/portal/destination" 
          class="w-full py-2.5 rounded-xl border border-indigo-200 text-indigo-600 text-center text-xs font-semibold hover:bg-indigo-50 transition"
        >
          Ubah URL Tujuan →
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import apiClient from '@/api/client';
import type { ApiResponse } from '@/types/api';

interface DayActivity {
  label: string;
  date: string;
  taps: number;
}

interface SummaryData {
  business_name: string;
  slug: string;
  today_taps: number;
  last_7_days: number;
  last_30_days: number;
  total_taps: number;
  nfc_percentage: number;
  qr_percentage: number;
  current_destination: string;
  chart_days?: DayActivity[];
}

const loading = ref(false);
const summary = ref<SummaryData>({
  business_name: '',
  slug: '',
  today_taps: 0,
  last_7_days: 0,
  last_30_days: 0,
  total_taps: 0,
  nfc_percentage: 60,
  qr_percentage: 40,
  current_destination: '',
});

const chartDays = ref<DayActivity[]>([
  { label: 'Sen', date: '', taps: 0 },
  { label: 'Sel', date: '', taps: 0 },
  { label: 'Rab', date: '', taps: 0 },
  { label: 'Kam', date: '', taps: 0 },
  { label: 'Jum', date: '', taps: 0 },
  { label: 'Sab', date: '', taps: 0 },
  { label: 'Min', date: '', taps: 0 },
]);

function calculateHeight(taps: number): string {
  const max = Math.max(...chartDays.value.map(d => d.taps), 5);
  const percentage = Math.round((taps / max) * 100);
  return `${Math.max(percentage, 8)}%`;
}

async function fetchSummary() {
  loading.value = true;
  try {
    const res = await apiClient.get<ApiResponse<SummaryData>>('/client/dashboard/summary');
    if (res.data.success && res.data.data) {
      summary.value = res.data.data;
      if (res.data.data.chart_days && res.data.data.chart_days.length > 0) {
        chartDays.value = res.data.data.chart_days;
      }
    }
  } catch (err) {
    console.error('Failed to fetch dashboard summary', err);
  } finally {
    loading.value = false;
  }
}

onMounted(() => {
  fetchSummary();
});
</script>
